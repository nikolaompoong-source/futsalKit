<?php

require_once APPROOT . '/models/Team.php';
require_once APPROOT . '/models/Player.php';
require_once APPROOT . '/models/MatchModel.php';

class DashboardController extends Controller {
    private $teamModel;
    private $playerModel;
    private $matchModel;

    public function __construct() {
        Session::requireLogin();
        $this->teamModel = new Team();
        $this->playerModel = new Player();
        $this->matchModel = new MatchModel();
    }

    /**
     * Display Dashboard
     */
    public function index() {
        $data = [
            'title' => 'Dashboard | FutsalKit'
        ];

        try {
            if (Session::isAdmin()) {
                // Fetch stats for Admin dashboard
                $teams = $this->teamModel->getAll();
                $matches = $this->matchModel->getAll();
                
                $data['total_teams'] = count($teams);
                $data['total_matches'] = count($matches);
                
                $pending_count = 0;
                foreach ($teams as $t) {
                    if ($t['status'] === 'pending') {
                        $pending_count++;
                    }
                }
                $data['pending_teams'] = $pending_count;

                // Simple count of players using PDO query directly for dashboard
                $db = Database::connect();
                $data['total_players'] = $db->query("SELECT COUNT(*) FROM players")->fetchColumn();
                $data['total_users'] = $db->query("SELECT COUNT(*) FROM users WHERE role = 'manager'")->fetchColumn();
            } else {
                // Fetch stats for Manager dashboard
                $manager_id = Session::get('user_id');
                $team = $this->teamModel->getByManagerId($manager_id);
                
                $data['has_team'] = ($team !== false);
                
                if ($data['has_team']) {
                    $data['team'] = $team;
                    $players = $this->playerModel->getByTeamId($team['id']);
                    $data['total_players'] = count($players);
                    
                    // Count matches involving this team
                    $db = Database::connect();
                    $stmt = $db->prepare("SELECT COUNT(*) FROM matches WHERE home_team_id = :team_id OR away_team_id = :team_id");
                    $stmt->execute([':team_id' => $team['id']]);
                    $data['total_matches'] = $stmt->fetchColumn();
                } else {
                    $data['total_players'] = 0;
                    $data['total_matches'] = 0;
                }
            }

            $this->view('dashboard/index', $data);
        } catch (Exception $e) {
            // Safe Try-Catch Error Handling
            Session::setFlash('danger', 'Gagal memuat beberapa data statistik: ' . $e->getMessage());
            $this->view('dashboard/index', $data);
        }
    }
}
