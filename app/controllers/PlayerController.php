<?php

require_once APPROOT . '/models/Player.php';
require_once APPROOT . '/models/Team.php';

class PlayerController extends Controller {
    private $playerModel;
    private $teamModel;

    public function __construct() {
        Session::requireLogin();
        $this->playerModel = new Player();
        $this->teamModel = new Team();
    }

    /**
     * Helper to verify if the manager has an approved team
     */
    private function getApprovedManagerTeam() {
        if (Session::isAdmin()) {
            Session::setFlash('danger', 'Admin mengelola tim melalui menu Tim.');
            $this->redirect('/teams');
        }

        $manager_id = Session::get('user_id');
        $team = $this->teamModel->getByManagerId($manager_id);

        if (!$team) {
            Session::setFlash('warning', 'Silakan daftarkan tim Anda terlebih dahulu.');
            $this->redirect('/teams/register');
        }

        if ($team['status'] !== 'approved') {
            Session::setFlash('warning', 'Tim Anda belum disetujui oleh Admin. Anda baru bisa mengelola pemain setelah status disetujui.');
            $this->redirect('/dashboard');
        }

        return $team;
    }

    /**
     * Display Manager's players roster
     */
    public function index() {
        $team = $this->getApprovedManagerTeam();

        try {
            $players = $this->playerModel->getByTeamId($team['id']);
            $this->view('players/index', [
                'title' => 'Roster Pemain | FutsalKit',
                'team' => $team,
                'players' => $players
            ]);
        } catch (Exception $e) {
            Session::setFlash('danger', $e->getMessage());
            $this->redirect('/dashboard');
        }
    }

    /**
     * Add new player (Manager only)
     */
    public function create() {
        $team = $this->getApprovedManagerTeam();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $player_name = isset($_POST['player_name']) ? trim($_POST['player_name']) : '';
            $jersey_number = isset($_POST['jersey_number']) ? (int)$_POST['jersey_number'] : 0;
            $position = isset($_POST['position']) ? trim($_POST['position']) : '';
            $identity_name = null;
            $photo_name = null;

            // Server-Side Input Validation
            if (empty($player_name) || empty($position) || $jersey_number <= 0) {
                Session::setFlash('danger', 'Nama pemain, nomor punggung (positif), dan posisi wajib diisi.');
                $this->view('players/create', [
                    'title' => 'Tambah Pemain | FutsalKit',
                    'player_name' => $player_name,
                    'jersey_number' => $jersey_number,
                    'position' => $position
                ]);
                return;
            }

            if (!isset($_FILES['identity_card']) || $_FILES['identity_card']['error'] === UPLOAD_ERR_NO_FILE) {
                Session::setFlash('danger', 'Berkas identitas wajib diunggah.');
                $this->view('players/create', [
                    'title' => 'Tambah Pemain | FutsalKit',
                    'player_name' => $player_name,
                    'jersey_number' => $jersey_number,
                    'position' => $position
                ]);
                return;
            }

            if (!isset($_FILES['photo']) || $_FILES['photo']['error'] === UPLOAD_ERR_NO_FILE) {
                Session::setFlash('danger', 'Foto pemain wajib diunggah.');
                $this->view('players/create', [
                    'title' => 'Tambah Pemain | FutsalKit',
                    'player_name' => $player_name,
                    'jersey_number' => $jersey_number,
                    'position' => $position
                ]);
                return;
            }

            try {
                // Validate unique jersey number inside the team
                if ($this->playerModel->isJerseyTaken($team['id'], $jersey_number)) {
                    Session::setFlash('danger', 'Nomor punggung ' . $jersey_number . ' sudah digunakan oleh pemain lain di tim Anda.');
                    $this->view('players/create', [
                        'title' => 'Tambah Pemain | FutsalKit',
                        'player_name' => $player_name,
                        'jersey_number' => $jersey_number,
                        'position' => $position
                    ]);
                    return;
                }

                // File Upload Validation (Identity Card / Photo)
                if (isset($_FILES['identity_card']) && $_FILES['identity_card']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $file = $_FILES['identity_card'];
                    $fileName = $file['name'];
                    $fileTmpName = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileError = $file['error'];

                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];

                    if ($fileError !== 0) {
                        Session::setFlash('danger', 'Terjadi kesalahan saat mengunggah berkas.');
                        $this->view('players/create', [
                            'title' => 'Tambah Pemain | FutsalKit',
                            'player_name' => $player_name,
                            'jersey_number' => $jersey_number,
                            'position' => $position
                        ]);
                        return;
                    }

                    if (!in_array($fileExt, $allowedExts)) {
                        Session::setFlash('danger', 'Ekstensi berkas tidak valid. Hanya JPG, JPEG, PNG, dan PDF yang diperbolehkan.');
                        $this->view('players/create', [
                            'title' => 'Tambah Pemain | FutsalKit',
                            'player_name' => $player_name,
                            'jersey_number' => $jersey_number,
                            'position' => $position
                        ]);
                        return;
                    }

                    if ($fileSize > 2097152) { // 2MB
                        Session::setFlash('danger', 'Ukuran berkas identitas maksimal 2MB.');
                        $this->view('players/create', [
                            'title' => 'Tambah Pemain | FutsalKit',
                            'player_name' => $player_name,
                            'jersey_number' => $jersey_number,
                            'position' => $position
                        ]);
                        return;
                    }

                    // Secure and unique filename
                    $identity_name = uniqid('identity_', true) . '.' . $fileExt;
                    $uploadDirectory = 'uploads/identities/';
                    
                    if (!move_uploaded_file($fileTmpName, $uploadDirectory . $identity_name)) {
                        Session::setFlash('danger', 'Gagal menyimpan berkas identitas.');
                        $this->view('players/create', [
                            'title' => 'Tambah Pemain | FutsalKit',
                            'player_name' => $player_name,
                            'jersey_number' => $jersey_number,
                            'position' => $position
                        ]);
                        return;
                    }
                }

                // File Upload Validation (Player Photo)
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $file = $_FILES['photo'];
                    $fileName = $file['name'];
                    $fileTmpName = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileError = $file['error'];

                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $allowedExts = ['jpg', 'jpeg', 'png'];

                    if ($fileError !== 0) {
                        Session::setFlash('danger', 'Terjadi kesalahan saat mengunggah foto pemain.');
                        $this->view('players/create', [
                            'title' => 'Tambah Pemain | FutsalKit',
                            'player_name' => $player_name,
                            'jersey_number' => $jersey_number,
                            'position' => $position
                        ]);
                        return;
                    }

                    if (!in_array($fileExt, $allowedExts)) {
                        Session::setFlash('danger', 'Ekstensi foto tidak valid. Hanya JPG, JPEG, dan PNG yang diperbolehkan.');
                        $this->view('players/create', [
                            'title' => 'Tambah Pemain | FutsalKit',
                            'player_name' => $player_name,
                            'jersey_number' => $jersey_number,
                            'position' => $position
                        ]);
                        return;
                    }

                    if ($fileSize > 2097152) {
                        Session::setFlash('danger', 'Ukuran foto pemain maksimal 2MB.');
                        $this->view('players/create', [
                            'title' => 'Tambah Pemain | FutsalKit',
                            'player_name' => $player_name,
                            'jersey_number' => $jersey_number,
                            'position' => $position
                        ]);
                        return;
                    }

                    $photo_name = uniqid('player_', true) . '.' . $fileExt;
                    $uploadDirectory = 'uploads/photos/';

                    if (!move_uploaded_file($fileTmpName, $uploadDirectory . $photo_name)) {
                        Session::setFlash('danger', 'Gagal menyimpan foto pemain.');
                        $this->view('players/create', [
                            'title' => 'Tambah Pemain | FutsalKit',
                            'player_name' => $player_name,
                            'jersey_number' => $jersey_number,
                            'position' => $position
                        ]);
                        return;
                    }
                }

                $this->playerModel->create($team['id'], $player_name, $jersey_number, $position, $identity_name, $photo_name);
                Session::setFlash('success', 'Pemain berhasil ditambahkan.');
                $this->redirect('/players');
            } catch (Exception $e) {
                // Delete uploaded file if database insert fails
                if ($identity_name && file_exists('uploads/identities/' . $identity_name)) {
                    unlink('uploads/identities/' . $identity_name);
                }
                if ($photo_name && file_exists('uploads/photos/' . $photo_name)) {
                    unlink('uploads/photos/' . $photo_name);
                }
                Session::setFlash('danger', $e->getMessage());
                $this->view('players/create', [
                    'title' => 'Tambah Pemain | FutsalKit',
                    'player_name' => $player_name,
                    'jersey_number' => $jersey_number,
                    'position' => $position
                ]);
            }
        } else {
            $this->view('players/create', [
                'title' => 'Tambah Pemain | FutsalKit'
            ]);
        }
    }

    /**
     * Edit existing player (Manager only)
     */
    public function edit($id = null) {
        $team = $this->getApprovedManagerTeam();

        if ($id === null) {
            $this->redirect('/players');
        }

        try {
            $player = $this->playerModel->getById($id);
            if (!$player || $player['team_id'] !== $team['id']) {
                Session::setFlash('danger', 'Pemain tidak ditemukan atau bukan milik tim Anda.');
                $this->redirect('/players');
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $player_name = isset($_POST['player_name']) ? trim($_POST['player_name']) : '';
                $jersey_number = isset($_POST['jersey_number']) ? (int)$_POST['jersey_number'] : 0;
                $position = isset($_POST['position']) ? trim($_POST['position']) : '';
                $identity_name = $player['identity_card'];
                $photo_name = isset($player['photo']) ? $player['photo'] : null;

                // Input validation
                if (empty($player_name) || empty($position) || $jersey_number <= 0) {
                    Session::setFlash('danger', 'Nama, nomor punggung, dan posisi wajib diisi.');
                    $this->view('players/edit', [
                        'title' => 'Edit Pemain | FutsalKit',
                        'player' => $player
                    ]);
                    return;
                }

                // Validate jersey number (exclude this player)
                if ($this->playerModel->isJerseyTaken($team['id'], $jersey_number, $id)) {
                    Session::setFlash('danger', 'Nomor punggung ' . $jersey_number . ' sudah digunakan oleh pemain lain.');
                    $this->view('players/edit', [
                        'title' => 'Edit Pemain | FutsalKit',
                        'player' => array_merge($player, [
                            'player_name' => $player_name,
                            'jersey_number' => $jersey_number,
                            'position' => $position
                        ])
                    ]);
                    return;
                }

                // File Upload Validation (New Identity Card)
                if (isset($_FILES['identity_card']) && $_FILES['identity_card']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $file = $_FILES['identity_card'];
                    $fileName = $file['name'];
                    $fileTmpName = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileError = $file['error'];

                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];

                    if ($fileError === 0 && in_array($fileExt, $allowedExts) && $fileSize <= 2097152) {
                        $new_identity_name = uniqid('identity_', true) . '.' . $fileExt;
                        $uploadDirectory = 'uploads/identities/';

                        if (move_uploaded_file($fileTmpName, $uploadDirectory . $new_identity_name)) {
                            // Delete old file if exists
                            if ($player['identity_card'] && file_exists($uploadDirectory . $player['identity_card'])) {
                                unlink($uploadDirectory . $player['identity_card']);
                            }
                            $identity_name = $new_identity_name;
                        } else {
                            Session::setFlash('danger', 'Gagal mengunggah berkas identitas baru.');
                        }
                    } else {
                        Session::setFlash('danger', 'Berkas identitas tidak valid. Pastikan format JPG/PNG/PDF dan ukuran maks 2MB.');
                        $this->view('players/edit', [
                            'title' => 'Edit Pemain | FutsalKit',
                            'player' => $player
                        ]);
                        return;
                    }
                }

                // File Upload Validation (New Player Photo)
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $file = $_FILES['photo'];
                    $fileName = $file['name'];
                    $fileTmpName = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileError = $file['error'];

                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $allowedExts = ['jpg', 'jpeg', 'png'];

                    if ($fileError === 0 && in_array($fileExt, $allowedExts) && $fileSize <= 2097152) {
                        $new_photo_name = uniqid('player_', true) . '.' . $fileExt;
                        $uploadDirectory = 'uploads/photos/';

                        if (move_uploaded_file($fileTmpName, $uploadDirectory . $new_photo_name)) {
                            if (!empty($player['photo']) && file_exists($uploadDirectory . $player['photo'])) {
                                unlink($uploadDirectory . $player['photo']);
                            }
                            $photo_name = $new_photo_name;
                        } else {
                            Session::setFlash('danger', 'Gagal mengunggah foto pemain baru.');
                        }
                    } else {
                        Session::setFlash('danger', 'Foto pemain tidak valid. Pastikan format JPG/PNG dan ukuran maks 2MB.');
                        $this->view('players/edit', [
                            'title' => 'Edit Pemain | FutsalKit',
                            'player' => $player
                        ]);
                        return;
                    }
                }

                $this->playerModel->update($id, $player_name, $jersey_number, $position, $identity_name, $photo_name);
                Session::setFlash('success', 'Data pemain berhasil diperbarui.');
                $this->redirect('/players');
            } else {
                $this->view('players/edit', [
                    'title' => 'Edit Pemain | FutsalKit',
                    'player' => $player
                ]);
            }
        } catch (Exception $e) {
            Session::setFlash('danger', $e->getMessage());
            $this->redirect('/players');
        }
    }

    /**
     * Delete player (Manager only)
     */
    public function delete($id = null) {
        $team = $this->getApprovedManagerTeam();

        if ($id === null) {
            $this->redirect('/players');
        }

        try {
            $player = $this->playerModel->getById($id);
            if (!$player || $player['team_id'] !== $team['id']) {
                Session::setFlash('danger', 'Pemain tidak ditemukan atau bukan milik tim Anda.');
                $this->redirect('/players');
            }

            // Remove file if exists
            if ($player['identity_card'] && file_exists('uploads/identities/' . $player['identity_card'])) {
                unlink('uploads/identities/' . $player['identity_card']);
            }
            if (!empty($player['photo']) && file_exists('uploads/photos/' . $player['photo'])) {
                unlink('uploads/photos/' . $player['photo']);
            }

            $this->playerModel->delete($id);
            Session::setFlash('success', 'Pemain berhasil dihapus.');
        } catch (Exception $e) {
            Session::setFlash('danger', $e->getMessage());
        }
        $this->redirect('/players');
    }
}
