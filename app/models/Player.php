<?php

class Player {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Get all players belonging to a team
     */
    public function getByTeamId($team_id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM players WHERE team_id = :team_id ORDER BY jersey_number ASC");
            $stmt->execute([':team_id' => $team_id]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting players by team_id: " . $e->getMessage());
            throw new Exception("Gagal mengambil data pemain.");
        }
    }

    /**
     * Get player by ID
     */
    public function getById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM players WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error getting player by id: " . $e->getMessage());
            throw new Exception("Gagal mengambil data pemain.");
        }
    }

    /**
     * Check if a jersey number is already taken in the same team
     */
    public function isJerseyTaken($team_id, $jersey_number, $exclude_id = null) {
        try {
            $query = "SELECT COUNT(*) FROM players WHERE team_id = :team_id AND jersey_number = :jersey_number";
            $params = [
                ':team_id' => $team_id,
                ':jersey_number' => $jersey_number
            ];

            if ($exclude_id !== null) {
                $query .= " AND id != :exclude_id";
                $params[':exclude_id'] = $exclude_id;
            }

            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error checking jersey taken: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a new player
     */
    public function create($team_id, $player_name, $jersey_number, $position, $identity_card, $photo) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO players (team_id, player_name, jersey_number, position, identity_card, photo) 
                VALUES (:team_id, :player_name, :jersey_number, :position, :identity_card, :photo)
            ");
            return $stmt->execute([
                ':team_id' => $team_id,
                ':player_name' => $player_name,
                ':jersey_number' => $jersey_number,
                ':position' => $position,
                ':identity_card' => $identity_card,
                ':photo' => $photo
            ]);
        } catch (PDOException $e) {
            error_log("Error creating player: " . $e->getMessage());
            throw new Exception("Gagal menambahkan pemain baru.");
        }
    }

    /**
     * Update player details
     */
    public function update($id, $player_name, $jersey_number, $position, $identity_card, $photo) {
        try {
            $stmt = $this->db->prepare("
                UPDATE players 
                SET player_name = :player_name, jersey_number = :jersey_number, 
                    position = :position, identity_card = :identity_card, photo = :photo 
                WHERE id = :id
            ");
            return $stmt->execute([
                ':id' => $id,
                ':player_name' => $player_name,
                ':jersey_number' => $jersey_number,
                ':position' => $position,
                ':identity_card' => $identity_card,
                ':photo' => $photo
            ]);
        } catch (PDOException $e) {
            error_log("Error updating player: " . $e->getMessage());
            throw new Exception("Gagal memperbarui data pemain.");
        }
    }

    /**
     * Delete player
     */
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM players WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting player: " . $e->getMessage());
            throw new Exception("Gagal menghapus pemain.");
        }
    }
}
