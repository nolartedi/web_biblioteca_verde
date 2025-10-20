<?php
/**
 * Conexion - Clase gestora de conexiones a base de datos
 * 
 * Implementa el patrón Singleton implícito para gestionar conexiones PDO
 * a la base de datos MySQL. Maneja errores de conexión y configura
 * atributos importantes para el control de excepciones.
 * 
 * @package Libraries\Core
 * @author Grupo 11
 * @version 1.0
 */
class Conexion{
    /**
     * Instancia de conexión PDO
     * 
     * Almacena el objeto PDO que representa la conexión activa con la base de datos.
     * Es privado para encapsular el acceso y controlar el ciclo de vida de la conexión.
     * 
     * @var PDO|string
     */
    private $conect;

    /**
     * Constructor de la clase Conexion
     * 
     * Inicializa la conexión a la base de datos usando las constantes de configuración.
     * Utiliza PDO (PHP Data Objects) para una conexión segura y estandarizada.
     * Configura el manejo de errores para usar excepciones.
     * 
     * @throws PDOException Cuando la conexión falla, captura y muestra el error
     */
    public function __construct()
    {
      // Construye el DSN (Data Source Name) para la conexión PDO
      $conexion = "mysql:host=".HOST.";dbname=".BD.";.CHARSET.";  
      
      try {
          // Intenta establecer la conexión con las credenciales definidas
          $this->conect = new PDO($conexion, DB_USER, PASS);
          
          /**
           * Configura PDO para que lance excepciones en errores
           * Esto permite un manejo más robusto de errores de base de datos
           * en lugar de tener que verificar manualmente cada operación
           */
          $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
      } catch (PDOException $e) {
          /**
           * En caso de error, almacena un mensaje de error y lo muestra
           */
          $this->conect = "Error en la conexion";
          echo "Error: " . $e->getMessage();
      }
    }

    /**
     * Obtiene la instancia de conexión a base de datos
     * 
     * Proporciona acceso controlado a la conexión PDO establecida.
     * Permite reutilizar la misma conexión en múltiples operaciones.
     * 
     * @return PDO|string Retorna el objeto PDO de conexión o mensaje de error
     */
    public function conect()
    {
        return $this->conect;
    }
}

?>