<?php
class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // Verificar si es la raíz y está logueado para redirección automática
        if (empty($url[0]) && $this->isLoggedIn()) {
            if ($this->isAdmin()) {
                $this->redirect('admin/panel');
            } else {
                $this->redirect('dashboard');
            }
        }

        // Verificar si el controlador existe
        if (isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . 'Controller.php')) {
            $this->controller = ucwords($url[0]);
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . 'Controller.php';

        $controllerClass = $this->controller . 'Controller';
        $this->controller = new $controllerClass;

        // Verificar si el método existe
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Obtener parámetros
        $this->params = $url ? array_values($url) : [];

        // Llamar al método del controlador con parámetros
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }

    /**
     * Verifica si el usuario está logueado
     */
    private function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Verifica si el usuario es administrador
     */
    private function isAdmin()
    {
        return isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'administrador';
    }

    /**
     * Redirige a una URL específica
     */
    private function redirect($url)
    {
        header('Location: ' . URLROOT . $url);
        exit();
    }
}