<?php
class Controller
{

    public function __construct()
    {
        // Constructor vacío o con lógica común si es necesario
    }

    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = [])
    {
        // Usar la función helper view
        view($view, $data);
    }

    protected function redirect($url)
    {
        header('Location: ' . URLROOT . $url);
        exit();
    }

    protected function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    protected function isAdmin()
    {
        return isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'administrador';
    }

    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
    }

    protected function requireAdmin()
    {
        $this->requireLogin();
        if (!$this->isAdmin()) {
            $this->redirect('home');
        }
    }
}
