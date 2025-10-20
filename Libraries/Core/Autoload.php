<?php
/**
 * Autoload - Sistema de carga automática de clases
 * 
 * Implementa el patrón PSR-4 mediante spl_autoload_register para cargar
 * automáticamente las clases sin necesidad de require/include manuales.
 * 
 * @package Libraries\Core
 * @author Grupo 11
 * @version 1.0
 */

/**
 * Registra la función de autocarga personalizada
 * 
 * PHP llamará automáticamente a esta función cada vez que se intente
 * usar una clase que no haya sido cargada aún, buscando en la estructura
 * de directorios definida.
 * 
 * @param string $class Nombre completo de la clase a cargar
 * @return void
 */
spl_autoload_register(function ($class) {
    /**
     * Construye la ruta del archivo basado en el nombre de clase
     * Busca específicamente en el directorio Libraries/Core/
     */
    if (file_exists("Libraries/" . 'Core/' . $class . '.php')) {
        // Carga el archivo de la clase si existe
        require_once("Libraries/" . 'Core/' . $class . '.php');
    }
});
?>