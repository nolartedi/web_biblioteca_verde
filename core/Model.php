<?php
class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct()
    {
        // Incluir y conectar a la base de datos
        require_once '../config/Database.php';
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE " . $this->primaryKey . " = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO " . $this->table . " (" . $columns . ") VALUES (" . $placeholders . ")";
        $stmt = $this->db->prepare($query);

        return $stmt->execute($data);
    }

    public function update($id, $data)
    {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= $key . " = :" . $key . ", ";
        }
        $set = rtrim($set, ', ');

        $query = "UPDATE " . $this->table . " SET " . $set . " WHERE " . $this->primaryKey . " = :id";
        $stmt = $this->db->prepare($query);

        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE " . $this->primaryKey . " = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function where($conditions, $params = [])
    {
        $where = '';
        foreach ($conditions as $key => $value) {
            $where .= $key . " = :" . $key . " AND ";
        }
        $where = rtrim($where, ' AND ');

        $query = "SELECT * FROM " . $this->table . " WHERE " . $where;
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener el último ID insertado
    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }
}