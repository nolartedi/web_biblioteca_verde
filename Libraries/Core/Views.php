<?php
/**
 * Views - Gestor de vistas del sistema MVC
 * 
 * Se encarga de localizar, cargar y renderizar las vistas correspondientes
 * a cada controlador y método. Implementa la lógica de resolución de rutas
 * de vistas basada en la estructura de directorios del sistema.
 * 
 * @package Libraries\Core
 * @author Grupo 11
 * @version 1.0
 */
class Views{
    /**
     * Carga y renderiza la vista solicitada
     * 
     * Resuelve la ubicación de la vista basándose en el controlador y vista solicitados,
     * permitiendo pasar múltiples tipos de datos para su uso en la vista.
     * Soporta estructura de directorios organizada para vistas de diferentes controladores.
     * 
     * @param object $controller Instancia del controlador que solicita la vista
     * @param string $view Nombre de la vista a cargar (sin extensión .php)
     * @param mixed $data Datos principales a pasar a la vista (opcional)
     * @param mixed $alert Mensajes de alerta/notificación para la vista (opcional)
     * @param mixed $config Datos de configuración para la vista (opcional)
     * @param mixed $cliente Datos específicos del cliente (opcional)
     * @return void
     * 
     * @example
     * $this->views->getView($this, "index", $data, $alert, $config, $cliente);
     */
    function getView($controller, $view, $data="", $alert="", $config = "", $cliente = "")
    {
        /**
         * Obtiene el nombre de la clase del controlador
         * Ejemplo: Si se pasa $homeController, get_class retorna "Home"
         */
        $controller = get_class($controller);
        
        /**
         * Determina la ruta de la vista basada en el controlador
         * 
         * - Si el controlador es "Home", busca las vistas en el directorio raíz Views/
         * - Para otros controladores, busca en subdirectorios Views/ControllerName/
         * 
         * Esta convención organiza las vistas por controlador:
         * Views/index.php                    → Para Home Controller
         * Views/Usuario/login.php            → Para Usuario Controller  
         * Views/Producto/listado.php         → Para Producto Controller
         */
        if ($controller == "Home") {
            // Vistas del Home Controller en directorio raíz
            $view = "Views/".$view.".php";
        }else{
            // Vistas de otros controladores en subdirectorios
            $view = "Views/" . $controller . "/" . $view . ".php";
        }
        
        /**
         * Carga e incluye el archivo de la vista
         * 
         * Al usar require_once, la vista se carga en el contexto actual,
         * lo que permite que las variables $data, $alert, $config, $cliente
         * estén disponibles dentro de la vista.
         * 
         * NOTA: Las variables pasadas como parámetros estarán disponibles
         * en la vista con los mismos nombres: $data, $alert, $config, $cliente
         */
        require_once($view);
    }
}

?>