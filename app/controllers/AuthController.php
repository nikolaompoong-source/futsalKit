<?php

require_once APPROOT . '/models/User.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * Display Login Page or Handle Login Post
     */
    public function login() {
        Session::requireGuest();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve and sanitize inputs
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            // Server-Side Validation
            if (empty($email) || empty($password)) {
                Session::setFlash('danger', 'Email dan password wajib diisi.');
                $this->view('auth/login', ['email' => $email]);
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Session::setFlash('danger', 'Format email tidak valid.');
                $this->view('auth/login', ['email' => $email]);
                return;
            }

            try {
                // Check user in database
                $user = $this->userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    // Password matches, write session
                    Session::set('user_id', $user['id']);
                    Session::set('user_name', $user['name']);
                    Session::set('user_email', $user['email']);
                    Session::set('user_role', $user['role']);

                    Session::setFlash('success', 'Selamat datang kembali, ' . htmlspecialchars($user['name']) . '!');
                    $this->redirect('/dashboard');
                } else {
                    Session::setFlash('danger', 'Email atau password salah.');
                    $this->view('auth/login', ['email' => $email]);
                }
            } catch (Exception $e) {
                Session::setFlash('danger', $e->getMessage());
                $this->view('auth/login', ['email' => $email]);
            }
        } else {
            // Render clean login form
            $this->view('auth/login');
        }
    }

    /**
     * Display Register Page or Handle Register Post
     */
    public function register() {
        Session::requireGuest();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve and sanitize inputs
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

            // Server-Side Validation
            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                Session::setFlash('danger', 'Semua kolom pendaftaran wajib diisi.');
                $this->view('auth/register', ['name' => $name, 'email' => $email]);
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Session::setFlash('danger', 'Format email tidak valid.');
                $this->view('auth/register', ['name' => $name, 'email' => $email]);
                return;
            }

            if (strlen($password) < 6) {
                Session::setFlash('danger', 'Password minimal harus 6 karakter.');
                $this->view('auth/register', ['name' => $name, 'email' => $email]);
                return;
            }

            if ($password !== $confirm_password) {
                Session::setFlash('danger', 'Konfirmasi password tidak cocok.');
                $this->view('auth/register', ['name' => $name, 'email' => $email]);
                return;
            }

            try {
                // Register user
                $this->userModel->register($name, $email, $password, 'manager');
                
                Session::setFlash('success', 'Pendaftaran akun berhasil! Silakan login.');
                $this->redirect('/login');
            } catch (Exception $e) {
                Session::setFlash('danger', $e->getMessage());
                $this->view('auth/register', ['name' => $name, 'email' => $email]);
            }
        } else {
            // Render register form
            $this->view('auth/register');
        }
    }

    /**
     * Handle User Logout
     */
    public function logout() {
        Session::destroy();
        // Set message and redirect
        // We initialize session again to set flash message after destroying
        Session::init();
        Session::setFlash('success', 'Anda telah berhasil logout.');
        header("Location: " . BASE_URL . "/login");
        exit();
    }
}
