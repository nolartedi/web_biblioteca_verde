<?php
class LibroModel extends Model
{
    protected $table = 'libros';
    protected $primaryKey = 'id';


    public function getWithCategory()
    {
        $query = "SELECT l.*, c.nombre as categoria_nombre, c.color as categoria_color 
                  FROM libros l 
                  LEFT JOIN categorias c ON l.id_categoria = c.id 
                  ORDER BY l.titulo";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCategory($categoryId)
    {
        $query = "SELECT l.*, c.nombre as categoria_nombre, c.color as categoria_color 
                  FROM libros l 
                  LEFT JOIN categorias c ON l.id_categoria = c.id 
                  WHERE l.id_categoria = :category_id 
                  ORDER BY l.titulo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($term)
    {
        $query = "SELECT l.*, c.nombre as categoria_nombre, c.color as categoria_color 
                  FROM libros l 
                  LEFT JOIN categorias c ON l.id_categoria = c.id 
                  WHERE l.titulo LIKE :term OR l.autor LIKE :term OR l.descripcion LIKE :term 
                  ORDER BY l.titulo";
        $stmt = $this->db->prepare($query);
        $searchTerm = '%' . $term . '%';
        $stmt->bindParam(':term', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        // Validar datos requeridos
        $camposRequeridos = ['titulo', 'autor', 'isbn', 'id_categoria', 'estado'];
        foreach ($camposRequeridos as $campo) {
            if (empty($data[$campo])) {
                throw new Exception("El campo $campo es requerido");
            }
        }

        $sql = "INSERT INTO libros (titulo, autor, isbn, id_categoria, descripcion, fecha_publicacion, editorial, paginas, estado, fecha_agregado) 
            VALUES (:titulo, :autor, :isbn, :id_categoria, :descripcion, :fecha_publicacion, :editorial, :paginas, :estado, :fecha_agregado)";

        $stmt = $this->db->prepare($sql);

        try {
            return $stmt->execute($data);
        } catch (PDOException $e) {
            // Si es error de duplicado de ISBN
            if (strpos($e->getMessage(), 'Duplicate entry') !== false && strpos($e->getMessage(), 'isbn') !== false) {
                throw new Exception("El ISBN ya existe en el sistema");
            }
            throw $e;
        }
    }

    public function update($id, $data)
    {
        // Validar datos requeridos
        $camposRequeridos = ['titulo', 'autor', 'isbn', 'id_categoria', 'estado'];
        foreach ($camposRequeridos as $campo) {
            if (empty($data[$campo])) {
                throw new Exception("El campo $campo es requerido");
            }
        }

        $sql = "UPDATE libros SET 
            titulo = :titulo,
            autor = :autor,
            isbn = :isbn,
            id_categoria = :id_categoria,
            descripcion = :descripcion,
            fecha_publicacion = :fecha_publicacion,
            editorial = :editorial,
            paginas = :paginas,
            estado = :estado
            WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;

        try {
            return $stmt->execute($data);
        } catch (PDOException $e) {
            // Si es error de duplicado de ISBN
            if (strpos($e->getMessage(), 'Duplicate entry') !== false && strpos($e->getMessage(), 'isbn') !== false) {
                throw new Exception("El ISBN ya existe en el sistema");
            }
            throw $e;
        }
    }

    public function updateEstado($id, $estado)
    {
        $query = "UPDATE " . $this->table . " SET estado = :estado WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function findByIsbn($isbn)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE isbn = :isbn";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':isbn', $isbn);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRecientes($limit = 5)
    {
        $query = "SELECT l.*, c.nombre as categoria_nombre, c.color as categoria_color 
              FROM libros l 
              LEFT JOIN categorias c ON l.id_categoria = c.id 
              WHERE l.estado = 'disponible'
              ORDER BY l.fecha_agregado DESC 
              LIMIT :limit";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDestacados($limit = 6)
    {
        $query = "SELECT l.*, c.nombre as categoria_nombre, c.color as categoria_color,
                     COUNT(p.id) as total_prestamos
              FROM libros l 
              LEFT JOIN categorias c ON l.id_categoria = c.id 
              LEFT JOIN prestamos p ON l.id = p.id_libro
              WHERE l.estado = 'disponible'
              GROUP BY l.id
              ORDER BY total_prestamos DESC, l.fecha_agregado DESC
              LIMIT :limit";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
