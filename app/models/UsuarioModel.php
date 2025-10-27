<?php
class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    public function getByEmail($email)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $data)
    {
        $allowedFields = ['nombre', 'telefono'];
        $filteredData = array_intersect_key($data, array_flip($allowedFields));

        return $this->update($id, $filteredData);
    }

    public function changePassword($id, $newPasswordHash)
    {
        $query = "UPDATE " . $this->table . " SET password_hash = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':password', $newPasswordHash);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getEstadisticasUsuario($userId)
    {
        $query = "SELECT 
                    COUNT(*) as total_prestamos,
                    SUM(CASE WHEN estado = 'activo' THEN 1 ELSE 0 END) as prestamos_activos,
                    SUM(CASE WHEN estado = 'vencido' THEN 1 ELSE 0 END) as prestamos_vencidos
                  FROM prestamos 
                  WHERE id_usuario = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}