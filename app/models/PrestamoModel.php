<?php
class PrestamoModel extends Model
{
    protected $table = 'prestamos';
    protected $primaryKey = 'id';

    public function getByUsuario($userId)
    {
        $query = "SELECT p.*, l.titulo, l.autor, l.portada, 
                         c.nombre as categoria_nombre, c.color as categoria_color
                  FROM prestamos p
                  INNER JOIN libros l ON p.id_libro = l.id
                  LEFT JOIN categorias c ON l.id_categoria = c.id
                  WHERE p.id_usuario = :user_id
                  ORDER BY p.fecha_prestamo DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActivos()
    {
        $query = "SELECT p.*, u.nombre as usuario_nombre, u.email, 
                         l.titulo, l.autor, l.portada
                  FROM prestamos p
                  INNER JOIN usuarios u ON p.id_usuario = u.id
                  INNER JOIN libros l ON p.id_libro = l.id
                  WHERE p.estado = 'activo'
                  ORDER BY p.fecha_prestamo DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVencidos()
    {
        $query = "SELECT p.*, u.nombre as usuario_nombre, u.email, 
                         l.titulo, l.autor, l.portada
                  FROM prestamos p
                  INNER JOIN usuarios u ON p.id_usuario = u.id
                  INNER JOIN libros l ON p.id_libro = l.id
                  WHERE p.estado = 'vencido' OR 
                        (p.estado = 'activo' AND p.fecha_limite < CURDATE())
                  ORDER BY p.fecha_limite ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendientes()
    {
        $query = "SELECT p.*, u.nombre as usuario_nombre, u.email, 
                         l.titulo, l.autor, l.portada
                  FROM prestamos p
                  INNER JOIN usuarios u ON p.id_usuario = u.id
                  INNER JOIN libros l ON p.id_libro = l.id
                  WHERE p.estado = 'activo' AND p.fecha_limite >= CURDATE()
                  ORDER BY p.fecha_limite ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // AGREGAR ESTOS MÉTODOS NUEVOS:
    public function getWithDetails()
    {
        $query = "SELECT p.*, 
                         u.nombre as usuario_nombre, u.email as usuario_email,
                         l.titulo as libro_titulo, l.autor as libro_autor, l.portada,
                         c.nombre as categoria_nombre, c.color as categoria_color
                  FROM prestamos p
                  INNER JOIN usuarios u ON p.id_usuario = u.id
                  INNER JOIN libros l ON p.id_libro = l.id
                  LEFT JOIN categorias c ON l.id_categoria = c.id
                  ORDER BY p.fecha_prestamo DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function realizarDevolucion($prestamoId)
    {
        $query = "UPDATE prestamos 
                  SET estado = 'devuelto', fecha_devolucion = NOW() 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $prestamoId);
        return $stmt->execute();
    }

    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function solicitarPrestamo($usuarioId, $libroId)
    {
        // Calcular fecha límite (14 días desde hoy)
        $fechaLimite = date('Y-m-d', strtotime('+14 days'));

        $data = [
            'id_usuario' => $usuarioId,
            'id_libro' => $libroId,
            'fecha_limite' => $fechaLimite,
            'estado' => 'activo'
        ];

        return $this->create($data);
    }

    public function extenderPrestamo($prestamoId)
    {
        // Extender por 7 días más
        $query = "UPDATE prestamos 
                  SET fecha_limite = DATE_ADD(fecha_limite, INTERVAL 7 DAY),
                      extensiones = extensiones + 1
                  WHERE id = :id AND extensiones < 2"; // Máximo 2 extensiones
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $prestamoId);
        return $stmt->execute();
    }

    public function marcarComoVencido($prestamoId)
    {
        $query = "UPDATE prestamos SET estado = 'vencido' WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $prestamoId);
        return $stmt->execute();
    }

    public function getEstadisticas()
    {
        $query = "SELECT 
                    COUNT(*) as total_prestamos,
                    SUM(CASE WHEN estado = 'activo' THEN 1 ELSE 0 END) as prestamos_activos,
                    SUM(CASE WHEN estado = 'vencido' THEN 1 ELSE 0 END) as prestamos_vencidos,
                    SUM(CASE WHEN estado = 'devuelto' THEN 1 ELSE 0 END) as prestamos_devueltos
                  FROM prestamos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}