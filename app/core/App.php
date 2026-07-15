<?php

class App {
    protected $controller = 'DashboardController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Short URL aliases routing (e.g. /login -> /auth/login)
        if (isset($url[0])) {
            $alias = strtolower($url[0]);
            if ($alias === 'login' || $alias === 'register' || $alias === 'logout') {
                $url[0] = 'auth';
                array_splice($url, 1, 0, $alias);
            }
        }

        // 1. Check if controller exists
        if (isset($url[0])) {
            $routeMap = [
                'teams' => 'Team',
                'players' => 'Player',
                'matches' => 'Match',
                'dashboard' => 'Dashboard',
                'auth' => 'Auth'
            ];

            $routeKey = strtolower($url[0]);
            $controllerName = $routeMap[$routeKey] ?? ucfirst($url[0]);

            if (!isset($routeMap[$routeKey]) && substr($controllerName, -1) == 's') {
                $singularControllerName = substr($controllerName, 0, -1) . 'Controller';
                if (file_exists(APPROOT . '/controllers/' . $singularControllerName . '.php')) {
                    $controllerName = substr($controllerName, 0, -1);
                }
            }
            
            $controllerClass = $controllerName . 'Controller';
            
            if (file_exists(APPROOT . '/controllers/' . $controllerClass . '.php')) {
                $this->controller = $controllerClass;
                unset($url[0]);
            } else {
                $this->show404();
                return;
            }
        }

        // Require the controller file
        require_once APPROOT . '/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Check if method exists in controller
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                $this->show404();
                return;
            }
        }

        // 3. Get parameters if any
        $this->params = $url ? array_values($url) : [];

        // Run the controller action method
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Parse clean URL
     */
    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

        if ($basePath !== '/' && strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }

        $path = trim($path, '/');
        if ($path === '' || $path === 'index.php') {
            return [];
        }

        if (strpos($path, 'index.php/') === 0) {
            $path = substr($path, strlen('index.php/'));
        }

        return explode('/', filter_var(rtrim($path, '/'), FILTER_SANITIZE_URL));
    }

    /**
     * Display a 404 page
     */
    private function show404() {
        http_response_code(404);
        echo "<div style='font-family: Arial, sans-serif; padding: 50px; text-align: center; background-color: #f8f9fa; min-height: 100vh;'>
                <h1 style='color: #dc3545; font-size: 72px; margin: 0 0 10px 0;'>404</h1>
                <h3 style='color: #343a40; font-size: 24px; margin-bottom: 20px;'>Halaman Tidak Ditemukan</h3>
                <p style='color: #6c757d; margin-bottom: 30px;'>Maaf, URL / Halaman yang Anda cari tidak tersedia atau salah penulisan.</p>
                <a href='" . BASE_URL . "/dashboard' style='display: inline-block; padding: 10px 25px; background-color: #0d6efd; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;'>Kembali ke Dashboard</a>
              </div>";
        exit();
    }
}
