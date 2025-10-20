<?php
/**
 * Helpers - Archivo de funciones auxiliares globales
 * 
 * Contiene funciones reutilizables para la capa de presentación y
 * gestión de rutas base de la aplicación. Su propósito principal es
 * simplificar tareas recurrentes en los controladores y vistas.
 * 
 * @package Config
 * @author Grupo 11
 * @version 1.0
 */

/**
 * Genera la URL base de la aplicación
 * 
 * Útil para construir enlaces absolutos consistentes en toda la aplicación.
 * Evita problemas con rutas relativas en diferentes entornos de despliegue.
 * 
 * @return string URL base definida en la constante BASE_URL
 */
function base_url()
{
    return BASE_URL;
}

/**
 * Carga y muestra la plantilla del encabezado
 * 
 * Centraliza la carga del header para mantener consistencia visual
 * en todas las páginas. Permite pasar datos dinámicos si es necesario.
 * 
 * @param mixed $data Datos opcionales para pasar a la plantilla (ej: título, meta tags)
 */
function encabezado($data="")
{
    $VistaH = "Views/Template/header.php";
    require_once($VistaH);
}

/**
 * Carga y muestra la plantilla del pie de página
 * 
 * Garantiza que todas las páginas utilicen el mismo footer.
 * Ideal para incluir scripts comunes o información de cierre.
 * 
 * @param mixed $data Datos opcionales para pasar a la plantilla (ej: scripts adicionales)
 */
function pie($data="")
{
    $VistaP = "Views/Template/footer.php";
    require_once($VistaP);
}
?>