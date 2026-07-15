<?php

class Session {
    /**
     * Initialize session
     */
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set session variable
     */
    public static function set($key, $value) {
        self::init();
        $_SESSION[$key] = $value;
    }

    /**
     * Get session variable
     */
    public static function get($key, $default = null) {
        self::init();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * Check if a session variable exists
     */
    public static function has($key) {
        self::init();
        return isset($_SESSION[$key]);
    }

    /**
     * Remove session variable
     */
    public static function remove($key) {
        self::init();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destroy session
     */
    public static function destroy() {
        self::init();
        session_destroy();
        $_SESSION = [];
    }

    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        return self::has('user_id');
    }

    /**
     * Check if current user is Admin
     */
    public static function isAdmin() {
        return self::get('user_role') === 'admin';
    }

    /**
     * Check if current user is Manager
     */
    public static function isManager() {
        return self::get('user_role') === 'manager';
    }

    /**
     * Restrict access to logged in users
     */
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            self::setFlash('danger', 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.');
            header("Location: " . BASE_URL . "/login");
            exit();
        }
    }

    /**
     * Restrict access to guests only (e.g. login/register)
     */
    public static function requireGuest() {
        if (self::isLoggedIn()) {
            header("Location: " . BASE_URL . "/dashboard");
            exit();
        }
    }

    /**
     * Restrict access by role (RBAC URL Protection)
     */
    public static function requireRole($role) {
        self::requireLogin();
        if (self::get('user_role') !== $role) {
            self::setFlash('danger', 'Anda tidak memiliki hak akses (otorisasi) untuk membuka halaman tersebut.');
            header("Location: " . BASE_URL . "/dashboard");
            exit();
        }
    }

    /**
     * Set a flash message
     */
    public static function setFlash($type, $message) {
        self::init();
        $_SESSION['flash'][$type] = $message;
    }

    /**
     * Check if a specific flash message exists
     */
    public static function hasFlash($type) {
        self::init();
        return isset($_SESSION['flash'][$type]);
    }

    /**
     * Get and clear a flash message
     */
    public static function getFlash($type) {
        self::init();
        if (self::hasFlash($type)) {
            $message = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $message;
        }
        return null;
    }
}
