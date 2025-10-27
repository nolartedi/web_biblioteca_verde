<?php
class CategoriaModel extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';

    public function find($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getWithBookCount()
    {
        $query = "SELECT c.*, COUNT(l.id) as total_libros
        FROM categorias c
        LEFT JOIN libros l ON c.id = l.id_categoria
        GROUP BY c.id
        ORDER BY c.nombre";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLibrosPorCategoria()
    {
        $query = "SELECT c.nombre, c.color, COUNT(l.id) as cantidad
        FROM categorias c
        LEFT JOIN libros l ON c.id = l.id_categoria
        GROUP BY c.id, c.nombre, c.color
        ORDER BY cantidad DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica si una categoría tiene libros asociados
     */
    public function tieneLibros($categoriaId)
    {
        $query = "SELECT COUNT(*) as total FROM libros WHERE id_categoria = :categoria_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':categoria_id', $categoriaId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    /**
     * Elimina categoría solo si no tiene libros
     */
    public function deleteIfEmpty($id)
    {
        // Verificar si la categoría tiene libros
        if ($this->tieneLibros($id)) {
            return false; // No se puede eliminar porque tiene libros
        }

        // Si no tiene libros, proceder con la eliminación
        return $this->delete($id);
    }
}