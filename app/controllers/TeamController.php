<?php

require_once APPROOT . '/models/Team.php';
require_once APPROOT . '/models/Player.php';

class TeamController extends Controller {
    private $teamModel;
    private $playerModel;

    public function __construct() {
        Session::requireLogin();
        $this->teamModel = new Team();
        $this->playerModel = new Player();
    }

    /**
     * List all teams (Admin) or redirect to own team (Manager)
     */
    public function index() {
        if (Session::isAdmin()) {
            try {
                $teams = $this->teamModel->getAll();
                $this->view('teams/index', [
                    'title' => 'Daftar Tim | FutsalKit',
                    'teams' => $teams
                ]);
            } catch (Exception $e) {
                Session::setFlash('danger', $e->getMessage());
                $this->redirect('/dashboard');
            }
        } else {
            // Manager: redirect to team detail if exists, else redirect to register
            $manager_id = Session::get('user_id');
            try {
                $team = $this->teamModel->getByManagerId($manager_id);
                if ($team) {
                    $this->redirect('/teams/detail/' . $team['id']);
                } else {
                    $this->redirect('/teams/register');
                }
            } catch (Exception $e) {
                Session::setFlash('danger', $e->getMessage());
                $this->redirect('/dashboard');
            }
        }
    }

    /**
     * Register a new Team (Manager only)
     */
    public function register() {
        if (Session::isAdmin()) {
            Session::setFlash('danger', 'Admin tidak dapat mendaftarkan tim.');
            $this->redirect('/dashboard');
        }

        $manager_id = Session::get('user_id');

        // Check if already has a team
        if ($this->teamModel->hasTeam($manager_id)) {
            Session::setFlash('warning', 'Anda sudah mendaftarkan tim.');
            $this->redirect('/teams');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $team_name = isset($_POST['team_name']) ? trim($_POST['team_name']) : '';
            $contact_number = isset($_POST['contact_number']) ? trim($_POST['contact_number']) : '';
            $logo_name = null;

            // Server-Side Input Validation
            if (empty($team_name) || empty($contact_number)) {
                Session::setFlash('danger', 'Nama tim dan nomor kontak wajib diisi.');
                $this->view('teams/register', [
                    'title' => 'Daftar Tim Baru | FutsalKit',
                    'team_name' => $team_name,
                    'contact_number' => $contact_number
                ]);
                return;
            }

            // File Upload Validation (Logo)
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE) {
                $file = $_FILES['logo'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];

                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];

                if ($fileError !== 0) {
                    Session::setFlash('danger', 'Terjadi kesalahan saat mengunggah file.');
                    $this->view('teams/register', [
                        'title' => 'Daftar Tim Baru | FutsalKit',
                        'team_name' => $team_name,
                        'contact_number' => $contact_number
                    ]);
                    return;
                }

                if (!in_array($fileExt, $allowedExts)) {
                    Session::setFlash('danger', 'Ekstensi file logo tidak valid. Hanya JPG, JPEG, PNG, dan PDF yang diperbolehkan.');
                    $this->view('teams/register', [
                        'title' => 'Daftar Tim Baru | FutsalKit',
                        'team_name' => $team_name,
                        'contact_number' => $contact_number
                    ]);
                    return;
                }

                if ($fileSize > 2097152) { // 2MB in bytes
                    Session::setFlash('danger', 'Ukuran file logo maksimal 2MB.');
                    $this->view('teams/register', [
                        'title' => 'Daftar Tim Baru | FutsalKit',
                        'team_name' => $team_name,
                        'contact_number' => $contact_number
                    ]);
                    return;
                }

                // Generate secure and unique file name
                $logo_name = uniqid('logo_', true) . '.' . $fileExt;
                $uploadDirectory = 'uploads/logos/';
                
                if (!move_uploaded_file($fileTmpName, $uploadDirectory . $logo_name)) {
                    Session::setFlash('danger', 'Gagal memindahkan file ke folder penyimpanan.');
                    $this->view('teams/register', [
                        'title' => 'Daftar Tim Baru | FutsalKit',
                        'team_name' => $team_name,
                        'contact_number' => $contact_number
                    ]);
                    return;
                }
            }

            try {
                $this->teamModel->create($manager_id, $team_name, $logo_name, $contact_number);
                Session::setFlash('success', 'Pendaftaran tim berhasil diajukan! Menunggu persetujuan Admin.');
                $this->redirect('/teams');
            } catch (Exception $e) {
                // Delete uploaded file if database insertion failed
                if ($logo_name && file_exists('uploads/logos/' . $logo_name)) {
                    unlink('uploads/logos/' . $logo_name);
                }
                Session::setFlash('danger', $e->getMessage());
                $this->view('teams/register', [
                    'title' => 'Daftar Tim Baru | FutsalKit',
                    'team_name' => $team_name,
                    'contact_number' => $contact_number
                ]);
            }
        } else {
            $this->view('teams/register', [
                'title' => 'Daftar Tim Baru | FutsalKit'
            ]);
        }
    }

    /**
     * Display Team Detail (all logged-in users)
     */
    public function detail($id = null) {
        if ($id === null) {
            $this->redirect('/dashboard');
        }

        try {
            $team = $this->teamModel->getById($id);
            if (!$team) {
                Session::setFlash('danger', 'Tim tidak ditemukan.');
                $this->redirect('/dashboard');
            }

            $players = $this->playerModel->getByTeamId($id);

            $this->view('teams/detail', [
                'title' => 'Detail Tim | FutsalKit',
                'team' => $team,
                'players' => $players
            ]);
        } catch (Exception $e) {
            Session::setFlash('danger', $e->getMessage());
            $this->redirect('/dashboard');
        }
    }

    /**
     * Approve Team (Admin only)
     */
    public function approve($id = null) {
        Session::requireRole('admin');
        if ($id === null) {
            $this->redirect('/teams');
        }

        try {
            $this->teamModel->updateStatus($id, 'approved');
            Session::setFlash('success', 'Status tim berhasil disetujui.');
        } catch (Exception $e) {
            Session::setFlash('danger', $e->getMessage());
        }
        $this->redirect('/teams');
    }

    /**
     * Reject Team (Admin only)
     */
    public function reject($id = null) {
        Session::requireRole('admin');
        if ($id === null) {
            $this->redirect('/teams');
        }

        try {
            $this->teamModel->updateStatus($id, 'rejected');
            Session::setFlash('success', 'Status tim berhasil ditolak.');
        } catch (Exception $e) {
            Session::setFlash('danger', $e->getMessage());
        }
        $this->redirect('/teams');
    }

    /**
     * Delete Team (Admin or Owner Manager)
     */
    public function delete($id = null) {
        if ($id === null) {
            $this->redirect('/dashboard');
        }

        try {
            $team = $this->teamModel->getById($id);
            if (!$team) {
                Session::setFlash('danger', 'Tim tidak ditemukan.');
                $this->redirect('/dashboard');
            }

            // Authorization: Admin can delete, Manager can only delete their own team
            if (!Session::isAdmin() && Session::get('user_id') != $team['manager_id']) {
                Session::setFlash('danger', 'Anda tidak berhak menghapus tim ini.');
                $this->redirect('/dashboard');
            }

            // Remove logo file if exists
            if ($team['logo'] && file_exists('uploads/logos/' . $team['logo'])) {
                unlink('uploads/logos/' . $team['logo']);
            }

            $this->teamModel->delete($id);
            Session::setFlash('success', 'Tim berhasil dihapus dari sistem.');
        } catch (Exception $e) {
            Session::setFlash('danger', $e->getMessage());
        }

        if (Session::isAdmin()) {
            $this->redirect('/teams');
        } else {
            $this->redirect('/dashboard');
        }
    }
}
