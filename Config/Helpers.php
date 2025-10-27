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
 * Genera la URL completa para un recurso
 * 
 * Útil para construir enlaces absolutos consistentes en toda la aplicación.
 * Evita problemas con rutas relativas en diferentes entornos de despliegue.
 * 
 * @param string $path Ruta relativa del recurso
 * @return string URL completa del recurso
 */
function url($path = '')
{
    return URLROOT . $path;
}

/**
 * Carga y muestra la plantilla del encabezado
 * 
 * Centraliza la carga del header para mantener consistencia visual
 * en todas las páginas. Permite pasar datos dinámicos si es necesario.
 * 
 * @param array $data Datos opcionales para pasar a la plantilla (ej: título, meta tags)
 */
function view_header($data = [])
{
    $view_path = APPROOT . '/app/views/layouts/header.php';
    if (file_exists($view_path)) {
        extract($data);
        require_once $view_path;
    } else {
        die('Error: No se pudo cargar el header');
    }
}

/**
 * Carga y muestra la plantilla del pie de página
 * 
 * Garantiza que todas las páginas utilicen el mismo footer.
 * Ideal para incluir scripts comunes o información de cierre.
 * 
 * @param array $data Datos opcionales para pasar a la plantilla (ej: scripts adicionales)
 */
function view_footer($data = [])
{
    $view_path = APPROOT . '/app/views/layouts/footer.php';
    if (file_exists($view_path)) {
        extract($data);
        require_once $view_path;
    } else {
        die('Error: No se pudo cargar el footer');
    }
}

/**
 * Carga una vista específica
 * 
 * Simplifica la carga de vistas desde cualquier parte de la aplicación.
 * 
 * @param string $view Nombre de la vista (sin extensión .php)
 * @param array $data Datos para pasar a la vista
 */
function view($view, $data = [])
{
    $view_path = APPROOT . '/app/views/' . $view . '.php';
    if (file_exists($view_path)) {
        extract($data);
        require_once $view_path;
    } else {
        die('Error: No se pudo cargar la vista: ' . $view);
    }
}

/**
 * Redirige a una URL específica
 * 
 * @param string $url Ruta relativa a la que redirigir
 */
function redirect($url)
{
    header('Location: ' . URLROOT . $url);
    exit();
}

/**
 * Muestra un mensaje flash de éxito
 * 
 * @param string $message Mensaje a mostrar
 */
function set_success_message($message)
{
    $_SESSION['success'] = $message;
}

/**
 * Muestra un mensaje flash de error
 * 
 * @param string $message Mensaje a mostrar
 */
function set_error_message($message)
{
    $_SESSION['error'] = $message;
}

/**
 * Verifica si el usuario está logueado
 * 
 * @return bool
 */
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

/**
 * Verifica si el usuario es administrador
 * 
 * @return bool
 */
function is_admin()
{
    return isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'administrador';
}

/**
 * Requiere que el usuario esté logueado
 */
function require_login()
{
    if (!is_logged_in()) {
        redirect('auth/login');
    }
}

/**
 * Requiere que el usuario sea administrador
 */
function require_admin()
{
    require_login();
    if (!is_admin()) {
        redirect('home');
    }
}

/**
 * Formatea una fecha en español
 * 
 * @param string $date_string Fecha en formato válido
 * @return string Fecha formateada
 */
function format_date($date_string)
{
    $months = [
        'January' => 'enero',
        'February' => 'febrero',
        'March' => 'marzo',
        'April' => 'abril',
        'May' => 'mayo',
        'June' => 'junio',
        'July' => 'julio',
        'August' => 'agosto',
        'September' => 'septiembre',
        'October' => 'octubre',
        'November' => 'noviembre',
        'December' => 'diciembre'
    ];

    $english_date = date('F d, Y', strtotime($date_string));
    return str_replace(
        array_keys($months),
        array_values($months),
        $english_date
    );
}

/**
 * Sanitiza datos de entrada
 * 
 * @param string $data Dato a sanitizar
 * @return string Dato sanitizado
 */
function sanitize($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Debug function para desarrollo
 * 
 * @param mixed $data Dato a imprimir
 * @param bool $die Terminar ejecución después de imprimir
 */
function debug($data, $die = false)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($die) die();
}