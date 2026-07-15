<?php

class Controller {
    /**
     * Render view file
     * @param string $view
     * @param array $data
     */
    protected function view($view, $data = []) {
        // Extract array keys to variables for the view
        extract($data);

        // Define view path
        $viewFile = APPROOT . "/views/" . $view . ".php";

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View file " . $viewFile . " tidak ditemukan.");
        }
    }

    /**
     * Redirect to another URL within the application
     * @param string $url
     */
    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit();
    }
}
