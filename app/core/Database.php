<?php

class Database {
    private static $host = 'localhost';
    private static $db_name = 'futsalkit';
    private static $username = 'root';
    private static $password = '';
    private static $conn = null;

    /**
     * Get PDO Database Connection (Singleton pattern)
     * @return PDO
     */
    public static function connect() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4",
                    self::$username,
                    self::$password
                );
                // Enable exceptions and return associative arrays by default
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Prevent raw credential leak by logging or custom error display
                error_log("Database connection error: " . $e->getMessage());
                die("<div style='font-family: Arial, sans-serif; padding: 20px; text-align: center;'>
                        <h2 style='color: #dc3545;'>Koneksi Database Gagal</h2>
                        <p>Silakan pastikan MySQL di Laragon Anda sudah aktif dan database <strong>futsalkit</strong> sudah di-import.</p>
                        <p style='color: #6c757d; font-size: 12px;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>
                     </div>");
            }
        }
        return self::$conn;
    }
}
