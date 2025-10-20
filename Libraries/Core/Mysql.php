<?php
/**
 * Mysql - Clase de abstracción de base de datos MySQL
 * 
 * Extiende la funcionalidad de Conexion para proporcionar una capa de abstracción
 * de base de datos con operaciones CRUD (Create, Read, Update, Delete) simplificadas.
 * Utiliza PDO para prevenir inyecciones SQL mediante prepared statements.
 * 
 * @package Libraries\Core
 * @author Grupo 11
 * @version 1.0
 */
class Mysql extends Conexion{
    private $conexion;
    private $strquery;
    private $arrvalues;
    private $id;

    /**
     * Constructor de la clase Mysql
     * 
     * Inicializa la conexión a la base de datos heredando de la clase Conexion
     * y prepara el objeto para ejecutar consultas seguras mediante PDO.
     * Establece el contexto de conexión que utilizarán todos los métodos CRUD.
     */
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

    /**
     * Inserta un nuevo registro en la base de datos
     * 
     * Ejecuta consultas INSERT de forma segura usando prepared statements.
     * Retorna el ID del último registro insertado en caso de éxito.
     * 
     * @param string $query Consulta SQL con placeholders (ej: INSERT INTO tabla VALUES (?, ?, ?))
     * @param array $arrvalues Valores que reemplazarán los placeholders en la consulta
     * @return int|string Retorna el último ID insertado o 0 en caso de error
     * 
     * @example
     * $mysql->insert("INSERT INTO usuarios (nombre, email) VALUES (?, ?)", ["Juan", "juan@email.com"]);
     */
    public function insert(string $query, array $arrvalues)
    {
        $this->strquery = $query;
        $this->arrvalues = $arrvalues;
        $insert = $this->conexion->prepare($this->strquery);
        $res = $insert->execute($this->arrvalues);
        if ($res) {
            $lastInsert = $this->conexion->lastInsertId();
        }else{
            $lastInsert = 0;
        }
        return $lastInsert;
    }

    /**
     * Selecciona un único registro de la base de datos
     * 
     * Ejecuta consultas SELECT y retorna solo el primer registro encontrado.
     * Ideal para búsquedas por ID o cuando se espera un único resultado.
     * 
     * @param string $query Consulta SQL completa (ej: SELECT * FROM usuarios WHERE id = 1)
     * @return array|bool Retorna un array asociativo con los datos o false si no encuentra resultados
     * 
     * @example
     * $usuario = $mysql->select("SELECT * FROM usuarios WHERE id = 1");
     */
    public function select(string $query){
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        $data = $result->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    /**
     * Selecciona múltiples registros de la base de datos
     * 
     * Ejecuta consultas SELECT y retorna todos los registros encontrados.
     * Útil para listados, reportes y consultas que devuelven múltiples filas.
     * 
     * @param string $query Consulta SQL completa (ej: SELECT * FROM usuarios WHERE activo = 1)
     * @return array Retorna un array de arrays asociativos con todos los registros
     * 
     * @example
     * $usuarios = $mysql->select_all("SELECT * FROM usuarios WHERE activo = 1");
     */
    public function select_all(string $query){
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        $data = $result->fetchall(PDO::FETCH_ASSOC);
        return $data;
    }

    /**
     * Actualiza registros en la base de datos
     * 
     * Ejecuta consultas UPDATE de forma segura usando prepared statements.
     * Retorna true si la actualización fue exitosa, false en caso contrario.
     * 
     * @param string $query Consulta SQL con placeholders (ej: UPDATE tabla SET campo = ? WHERE id = ?)
     * @param array $arrvalues Valores que reemplazarán los placeholders en la consulta
     * @return bool True si la actualización fue exitosa, false en caso de error
     * 
     * @example
     * $resultado = $mysql->update("UPDATE usuarios SET nombre = ? WHERE id = ?", ["Juan Pérez", 1]);
     */
    public function update(string $query, array $arrvalues){
        $this->strquery = $query;
        $this->arrvalues = $arrvalues;
        $update = $this->conexion->prepare($this->strquery);
        $res = $update->execute($this->arrvalues);
        return $res;
    }

    /**
     * Elimina registros de la base de datos
     * 
     * Ejecuta consultas DELETE. IMPORTANTE: Usar con precaución ya que los cambios son permanentes.
     * Retorna el objeto PDOStatement para permitir verificación de filas afectadas.
     * 
     * @param string $query Consulta SQL completa (ej: DELETE FROM usuarios WHERE id = 1)
     * @return PDOStatement Retorna el objeto resultante de la ejecución
     * 
     * @example
     * $resultado = $mysql->delete("DELETE FROM usuarios WHERE id = 1");
     * $filasAfectadas = $resultado->rowCount();
     */
    public function delete(string $query)
    {
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        return $result;
    }
}
?>