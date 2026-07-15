<?php

class User {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Find a user by email
     * @param string $email
     * @return array|false
     */
    public function findByEmail($email) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error finding user by email: " . $e->getMessage());
            throw new Exception("Terjadi kesalahan sistem saat memproses login.");
        }
    }

    /**
     * Find a user by ID
     * @param int $id
     * @return array|false
     */
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error finding user by id: " . $e->getMessage());
            throw new Exception("Terjadi kesalahan sistem saat mengambil data profil.");
        }
    }

    /**
     * Create a new user
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $role
     * @return bool
     */
    public function register($name, $email, $password, $role = 'manager') {
        try {
            // Hash password securely
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
            return $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => $role
            ]);
        } catch (PDOException $e) {
            error_log("Error registering user: " . $e->getMessage());
            if ($e->getCode() == 23000) { // Unique constraint violation (email)
                throw new Exception("Email tersebut sudah terdaftar di sistem kami.");
            }
            throw new Exception("Gagal mendaftarkan akun baru.");
        }
    }
}
