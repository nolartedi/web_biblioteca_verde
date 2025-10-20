<?php
/**
 * Load - Router dinámico para carga de controladores y métodos
 * 
 * Este script implementa el enrutamiento dinámico de la aplicación.
 * Se encarga de cargar controladores, verificar la existencia de métodos
 * y ejecutar las acciones solicitadas con sus parámetros.
 * 
 * @package Libraries\Core
 * @author Grupo 11
 * @version 1.0
 */

/**
 * Construye la ruta del archivo del controlador solicitado
 * Asume que todos los controladores están en el directorio "Controller/"
 * y siguen la convención de nombres [NombreController].php
 * 
 * @var string $controllerFile Ruta completa al archivo del controlador
 */
$controllerFile = "Controller/" . $controller . ".php";

/**
 * Verifica si el archivo del controlador existe en el sistema
 * Esto previene intentos de cargar controladores inexistentes
 */
if (file_exists($controllerFile)) {
    /**
     * Carga el archivo del controlador solicitado
     * Require_once asegura que el archivo solo se cargue una vez
     */
    require_once($controllerFile);
    
    /**
     * Crea una instancia del controlador
     * Asume que la variable $controller contiene el nombre de la clase
     * Ejemplo: Si $controller = "Home", instanciará new Home()
     */
    $controller = new $controller();
    
    /**
     * Verifica si el método solicitado existe en el controlador
     * Esto proporciona un nivel de seguridad al prevenir llamadas a métodos arbitrarios
     */
    if (method_exists($controller, $methop)) {
        /**
         * Ejecuta el método del controlador con los parámetros proporcionados
         * Usa sintaxis dinámica para llamar al método: $controller->{$methop}($params)
         * 
         * @param mixed $params Parámetros que se pasan al método del controlador
         * Pueden ser un array, string, o cualquier tipo según lo que espere el método
         */
        $controller->{$methop}($params);
    } else {
        /**
         * Si el método no existe en el controlador, carga el controlador de errores
         * Esto maneja casos donde la acción solicitada no está disponible
         * Ejemplo: http://dominio/Controlador/MetodoInexistente
         */
        require_once("Controller/Error.php");
    }
} else {
    /**
     * Si el controlador no existe, carga el controlador de errores
     * Esto maneja rutas no definidas en la aplicación
     * Ejemplo: http://dominio/ControladorInexistente/Metodo
     */
    require_once("Controller/Error.php");
}

?>