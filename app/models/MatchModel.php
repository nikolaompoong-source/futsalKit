<?php

class MatchModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Get all matches with home and away team details
     */
    public function getAll() {
        try {
            $stmt = $this->db->query("
                SELECT m.*, 
                       t_home.team_name as home_team_name, t_home.logo as home_team_logo,
                       t_away.team_name as away_team_name, t_away.logo as away_team_logo
                FROM matches m
                JOIN teams t_home ON m.home_team_id = t_home.id
                JOIN teams t_away ON m.away_team_id = t_away.id
                ORDER BY m.match_date ASC, m.match_time ASC
            ");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting matches: " . $e->getMessage());
            throw new Exception("Gagal mengambil data jadwal pertandingan.");
        }
    }

    /**
     * Get match details by ID
     */
    public function getById($id) {
        try {
            $stmt = $this->db->prepare("
                SELECT m.*, 
                       t_home.team_name as home_team_name, t_home.logo as home_team_logo,
                       t_away.team_name as away_team_name, t_away.logo as away_team_logo
                FROM matches m
                JOIN teams t_home ON m.home_team_id = t_home.id
                JOIN teams t_away ON m.away_team_id = t_away.id
                WHERE m.id = :id
            ");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error getting match by id: " . $e->getMessage());
            throw new Exception("Gagal mengambil data pertandingan.");
        }
    }

    /**
     * Create a new match fixture (Admin)
     */
    public function create($tournament_name, $home_team_id, $away_team_id, $match_date, $match_time, $venue) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO matches (tournament_name, home_team_id, away_team_id, match_date, match_time, venue, status) 
                VALUES (:tournament_name, :home_team_id, :away_team_id, :match_date, :match_time, :venue, 'scheduled')
            ");
            return $stmt->execute([
                ':tournament_name' => $tournament_name,
                ':home_team_id' => $home_team_id,
                ':away_team_id' => $away_team_id,
                ':match_date' => $match_date,
                ':match_time' => $match_time,
                ':venue' => $venue
            ]);
        } catch (PDOException $e) {
            error_log("Error creating match: " . $e->getMessage());
            throw new Exception("Gagal membuat jadwal pertandingan baru.");
        }
    }

    /**
     * Update match details (Admin)
     */
    public function update($id, $tournament_name, $home_team_id, $away_team_id, $match_date, $match_time, $venue, $status, $score_home = null, $score_away = null) {
        try {
            $stmt = $this->db->prepare("
                UPDATE matches 
                SET tournament_name = :tournament_name, home_team_id = :home_team_id, away_team_id = :away_team_id, 
                    match_date = :match_date, match_time = :match_time, venue = :venue, status = :status,
                    score_home = :score_home, score_away = :score_away
                WHERE id = :id
            ");
            return $stmt->execute([
                ':id' => $id,
                ':tournament_name' => $tournament_name,
                ':home_team_id' => $home_team_id,
                ':away_team_id' => $away_team_id,
                ':match_date' => $match_date,
                ':match_time' => $match_time,
                ':venue' => $venue,
                ':status' => $status,
                ':score_home' => $score_home,
                ':score_away' => $score_away
            ]);
        } catch (PDOException $e) {
            error_log("Error updating match: " . $e->getMessage());
            throw new Exception("Gagal memperbarui jadwal pertandingan.");
        }
    }

    /**
     * Delete match fixture (Admin)
     */
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM matches WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting match: " . $e->getMessage());
            throw new Exception("Gagal menghapus jadwal pertandingan.");
        }
    }
}
