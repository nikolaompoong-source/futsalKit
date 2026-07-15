<?php

require_once APPROOT . '/models/MatchModel.php';
require_once APPROOT . '/models/Team.php';

class MatchController extends Controller {
    private $matchModel;
    private $teamModel;

    public function __construct() {
        Session::requireLogin();
        $this->matchModel = new MatchModel();
        $this->teamModel = new Team();
    }

    /**
     * View all match fixtures and results
     */
    public function index() {
        try {
            $matches = $this->matchModel->getAll();
            $this->view('matches/index', [
                'title' => 'Jadwal Pertandingan | FutsalKit',
                'matches' => $matches
            ]);
        } catch (Exception $e) {
            Session::setFlash('danger', $e->getMessage());
            $this->redirect('/dashboard');
        }
    }

    /**
     * Create a new match fixture (Admin only)
     */
    public function create() {
        Session::requireRole('admin');

        try {
            $teams = $this->teamModel->getApprovedTeams();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $tournament_name = isset($_POST['tournament_name']) ? trim($_POST['tournament_name']) : '';
                $home_team_id = isset($_POST['home_team_id']) ? (int)$_POST['home_team_id'] : 0;
                $away_team_id = isset($_POST['away_team_id']) ? (int)$_POST['away_team_id'] : 0;
                $match_date = isset($_POST['match_date']) ? trim($_POST['match_date']) : '';
                $match_time = isset($_POST['match_time']) ? trim($_POST['match_time']) : '';
                $venue = isset($_POST['venue']) ? trim($_POST['venue']) : '';

                // Server-side validation
                if (empty($tournament_name) || empty($match_date) || empty($match_time) || empty($venue) || $home_team_id <= 0 || $away_team_id <= 0) {
                    Session::setFlash('danger', 'Semua kolom wajib diisi.');
                    $this->view('matches/create', [
                        'title' => 'Tambah Jadwal | FutsalKit',
                        'teams' => $teams,
                        'tournament_name' => $tournament_name,
                        'home_team_id' => $home_team_id,
                        'away_team_id' => $away_team_id,
                        'match_date' => $match_date,
                        'match_time' => $match_time,
                        'venue' => $venue
                    ]);
                    return;
                }

                if ($home_team_id === $away_team_id) {
                    Session::setFlash('danger', 'Tim kandang dan tim tandang tidak boleh sama.');
                    $this->view('matches/create', [
                        'title' => 'Tambah Jadwal | FutsalKit',
                        'teams' => $teams,
                        'tournament_name' => $tournament_name,
                        'home_team_id' => $home_team_id,
                        'away_team_id' => $away_team_id,
                        'match_date' => $match_date,
                        'match_time' => $match_time,
                        'venue' => $venue
                    ]);
                    return;
                }

                $this->matchModel->create($tournament_name, $home_team_id, $away_team_id, $match_date, $match_time, $venue);
                Session::setFlash('success', 'Jadwal pertandingan berhasil ditambahkan.');
                $this->redirect('/matches');
            } else {
                $this->view('matches/create', [
                    'title' => 'Tambah Jadwal | FutsalKit',
                    'teams' => $teams
                ]);
            }
        } catch (Exception $e) {
            Session::setFlash('danger', $e->getMessage());
            $this->redirect('/matches');
        }
    }

    /**
     * Edit match fixture / update score (Admin only)
     */
    public function edit($id = null) {
        Session::requireRole('admin');

        if ($id === null) {
            $this->redirect('/matches');
        }

        try {
            $match = $this->matchModel->getById($id);
            if (!$match) {
                Session::setFlash('danger', 'Jadwal pertandingan tidak ditemukan.');
                $this->redirect('/matches');
            }

            $teams = $this->teamModel->getApprovedTeams();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $tournament_name = isset($_POST['tournament_name']) ? trim($_POST['tournament_name']) : '';
                $home_team_id = isset($_POST['home_team_id']) ? (int)$_POST['home_team_id'] : 0;
                $away_team_id = isset($_POST['away_team_id']) ? (int)$_POST['away_team_id'] : 0;
                $match_date = isset($_POST['match_date']) ? trim($_POST['match_date']) : '';
                $match_time = isset($_POST['match_time']) ? trim($_POST['match_time']) : '';
                $venue = isset($_POST['venue']) ? trim($_POST['venue']) : '';
                $status = isset($_POST['status']) ? trim($_POST['status']) : 'scheduled';
                
                // Retrieve scores (can be empty/null if scheduled)
                $score_home = (isset($_POST['score_home']) && $_POST['score_home'] !== '') ? (int)$_POST['score_home'] : null;
                $score_away = (isset($_POST['score_away']) && $_POST['score_away'] !== '') ? (int)$_POST['score_away'] : null;

                // Server-side validation
                if (empty($tournament_name) || empty($match_date) || empty($match_time) || empty($venue) || $home_team_id <= 0 || $away_team_id <= 0) {
                    Session::setFlash('danger', 'Semua kolom utama wajib diisi.');
                    $this->view('matches/edit', [
                        'title' => 'Edit Jadwal & Skor | FutsalKit',
                        'match' => $match,
                        'teams' => $teams
                    ]);
                    return;
                }

                if ($home_team_id === $away_team_id) {
                    Session::setFlash('danger', 'Tim kandang dan tim tandang tidak boleh sama.');
                    $this->view('matches/edit', [
                        'title' => 'Edit Jadwal & Skor | FutsalKit',
                        'match' => $match,
                        'teams' => $teams
                    ]);
                    return;
                }

                // If status is finished, score must be filled
                if ($status === 'finished' && ($score_home === null || $score_away === null)) {
                    Session::setFlash('danger', 'Skor harus diisi jika status pertandingan Selesai (Finished).');
                    $this->view('matches/edit', [
                        'title' => 'Edit Jadwal & Skor | FutsalKit',
                        'match' => $match,
                        'teams' => $teams
                    ]);
                    return;
                }

                // Update database
                $this->matchModel->update($id, $tournament_name, $home_team_id, $away_team_id, $match_date, $match_time, $venue, $status, $score_home, $score_away);
                Session::setFlash('success', 'Jadwal pertandingan/skor berhasil diperbarui.');
                $this->redirect('/matches');
            } else {
                $this->view('matches/edit', [
                    'title' => 'Edit Jadwal & Skor | FutsalKit',
                    'match' => $match,
                    'teams' => $teams
                ]);
            }
        } catch (Exception $e) {
            Session::setFlash('danger', $e->getMessage());
            $this->redirect('/matches');
        }
    }

    /**
     * Delete match fixture (Admin only)
     */
    public function delete($id = null) {
        Session::requireRole('admin');

        if ($id === null) {
            $this->redirect('/matches');
        }

        try {
            $this->matchModel->delete($id);
            Session::setFlash('success', 'Jadwal pertandingan berhasil dihapus.');
        } catch (Exception $e) {
            Session::setFlash('danger', $e->getMessage());
        }
        $this->redirect('/matches');
    }
}
