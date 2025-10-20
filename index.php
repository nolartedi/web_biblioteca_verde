<?php
/**
 * index - Front Controller principal de la aplicación
 * 
 * Punto de entrada único para todas las solicitudes de la aplicación.
 * Implementa el patrón Front Controller, encargándose del enrutamiento,
 * carga de dependencias y despacho de solicitudes a los controladores
 * y métodos correspondientes.
 * 
 * @package Main
 * @author Grupo 11
 * @version 1.0
 */

/**
 * Carga las configuraciones globales de la aplicación
 * - Config.php: Define constantes de configuración (BASE_URL, base de datos, etc.)
 * - Helpers.php: Funciones auxiliares globales (base_url, encabezado, pie)
 */
require_once("Config/Config.php");
require_once("Config/Helpers.php");

/**
 * Procesa la URL solicitada para determinar el routing
 * 
 * Obtiene el parámetro 'url' de la query string o usa "Home/home" como valor por defecto.
 * Esto permite URLs amigables como: dominio.com/controlador/metodo/parametros
 * 
 * @example 
 * - dominio.com/Usuario/perfil/123 → $url = "Usuario/perfil/123"
 * - dominio.com/ → $url = "Home/home" (valor por defecto)
 */
$url = isset($_GET['url']) ? $_GET['url'] : "Home/home";

/**
 * Divide la URL en partes usando "/" como delimitador
 * Convierte la URL en un array para extraer controlador, método y parámetros
 * 
 * @example 
 * - "Usuario/perfil/123" → ["Usuario", "perfil", "123"]
 * - "Home/home" → ["Home", "home"]
 */
$arrUrl = explode("/", $url);

/**
 * Extrae el nombre del controlador desde la URL
 * Por defecto, el primer segmento de la URL representa el controlador
 * 
 * @var string $controller Nombre del controlador a instanciar
 */
$controller = $arrUrl[0];

/**
 * Inicializa el método con el mismo nombre del controlador como valor por defecto
 * Esto será sobrescrito si la URL contiene un método específico
 * 
 * @var string $methop Nombre del método a ejecutar (NOTA: posible typo, debería ser $method)
 */
$methop = $arrUrl[0];

/**
 * Inicializa la variable de parámetros como string vacío
 * Se llenará si la URL contiene parámetros adicionales
 */
$params = "";

/**
 * Verifica si existe un segundo segmento en la URL (método)
 * Si existe y no está vacío, lo asigna como el método a ejecutar
 */
if (isset($arrUrl[1])) {
    if ($arrUrl[1] != "") {
        $methop = $arrUrl[1];
    }
}

/**
 * Procesa los parámetros de la URL a partir del tercer segmento
 * Convierte los segmentos adicionales en una cadena de parámetros separados por comas
 */
if (isset($arrUrl[2])) {
    if ($arrUrl[2] != "") {
        /**
         * Recorre todos los segmentos a partir de la posición 2 (parámetros)
         * y los concatena en una cadena separada por comas
         * 
         * @example 
         * - URL: Usuario/editar/123/juan → $params = "123,juan"
         */
        for ($i=2; $i < count($arrUrl); $i++) { 
            $params .= $arrUrl[$i]. ',';
        }
        /**
         * Elimina la última coma sobrante de la cadena de parámetros
         */
        $params = trim($params, ',');
    }
}

/**
 * Carga el sistema de autocarga de clases (Autoload)
 * Permite cargar automáticamente las clases sin requires manuales
 */
require_once("Libraries/Core/Autoload.php");

/**
 * Carga el sistema de routing (Load.php)
 * Este archivo se encargará de:
 * - Verificar la existencia del controlador solicitado
 * - Instanciar el controlador
 * - Verificar la existencia del método
 * - Ejecutar el método con los parámetros
 * - Manejar errores si el controlador o método no existen
 */
require_once("Libraries/Core/Load.php");
?>