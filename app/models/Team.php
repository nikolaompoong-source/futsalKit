<?php

class Team {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Get all teams in the system (with manager name)
     */
    public function getAll() {
        try {
            $stmt = $this->db->query("
                SELECT t.*, u.name as manager_name, u.email as manager_email 
                FROM teams t 
                JOIN users u ON t.manager_id = u.id 
                ORDER BY t.created_at DESC
            ");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting all teams: " . $e->getMessage());
            throw new Exception("Gagal mengambil data tim.");
        }
    }

    /**
     * Get approved teams (for matches selection)
     */
    public function getApprovedTeams() {
        try {
            $stmt = $this->db->query("SELECT * FROM teams WHERE status = 'approved' ORDER BY team_name ASC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting approved teams: " . $e->getMessage());
            throw new Exception("Gagal mengambil data tim yang disetujui.");
        }
    }

    /**
     * Get team details by its ID
     */
    public function getById($id) {
        try {
            $stmt = $this->db->prepare("
                SELECT t.*, u.name as manager_name, u.email as manager_email 
                FROM teams t 
                JOIN users u ON t.manager_id = u.id 
                WHERE t.id = :id
            ");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error getting team by id: " . $e->getMessage());
            throw new Exception("Gagal mengambil detail tim.");
        }
    }

    /**
     * Get team details by Manager's User ID
     */
    public function getByManagerId($manager_id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM teams WHERE manager_id = :manager_id");
            $stmt->execute([':manager_id' => $manager_id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error getting team by manager_id: " . $e->getMessage());
            throw new Exception("Gagal mengambil data tim manajer.");
        }
    }

    /**
     * Check if a manager has already registered a team
     */
    public function hasTeam($manager_id) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM teams WHERE manager_id = :manager_id");
            $stmt->execute([':manager_id' => $manager_id]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error checking manager team: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Register/Create a new team
     */
    public function create($manager_id, $team_name, $logo, $contact_number) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO teams (manager_id, team_name, logo, contact_number, status) 
                VALUES (:manager_id, :team_name, :logo, :contact_number, 'pending')
            ");
            return $stmt->execute([
                ':manager_id' => $manager_id,
                ':team_name' => $team_name,
                ':logo' => $logo,
                ':contact_number' => $contact_number
            ]);
        } catch (PDOException $e) {
            error_log("Error creating team: " . $e->getMessage());
            if ($e->getCode() == 23000) {
                throw new Exception("Nama tim tersebut sudah digunakan. Silakan cari nama lain.");
            }
            throw new Exception("Gagal mendaftarkan tim baru.");
        }
    }

    /**
     * Update team details
     */
    public function update($id, $team_name, $logo, $contact_number) {
        try {
            $stmt = $this->db->prepare("
                UPDATE teams 
                SET team_name = :team_name, logo = :logo, contact_number = :contact_number 
                WHERE id = :id
            ");
            return $stmt->execute([
                ':id' => $id,
                ':team_name' => $team_name,
                ':logo' => $logo,
                ':contact_number' => $contact_number
            ]);
        } catch (PDOException $e) {
            error_log("Error updating team: " . $e->getMessage());
            if ($e->getCode() == 23000) {
                throw new Exception("Nama tim tersebut sudah digunakan.");
            }
            throw new Exception("Gagal memperbarui data tim.");
        }
    }

    /**
     * Update team status (Admin action)
     */
    public function updateStatus($id, $status) {
        try {
            $stmt = $this->db->prepare("UPDATE teams SET status = :status WHERE id = :id");
            return $stmt->execute([
                ':id' => $id,
                ':status' => $status
            ]);
        } catch (PDOException $e) {
            error_log("Error updating team status: " . $e->getMessage());
            throw new Exception("Gagal memperbarui status verifikasi tim.");
        }
    }

    /**
     * Delete team
     */
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM teams WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting team: " . $e->getMessage());
            throw new Exception("Gagal menghapus tim.");
        }
    }
}
