<?php
class HuellaCarbonoModel extends Model
{
    protected $table = 'huella_carbono';
    protected $primaryKey = 'id';

    public function getAhorroTotal()
    {
        $query = "SELECT SUM(ahorro_co2_kg) as total_ahorro FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_ahorro'] ?? 0;
    }

    public function getAhorroPorUsuario($userId)
    {
        $query = "SELECT SUM(h.ahorro_co2_kg) as total_ahorro
                  FROM huella_carbono h
                  JOIN prestamos p ON h.id_prestamo = p.id
                  WHERE p.id_usuario = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_ahorro'] ?? 0;
    }

    public function getAhorroMensual()
    {
        $query = "SELECT 
                YEAR(h.fecha_calculo) as anio,
                MONTH(h.fecha_calculo) as mes,
                COUNT(h.id) as total_libros,
                SUM(h.ahorro_co2_kg) as total_ahorrado
              FROM huella_carbono h
              INNER JOIN prestamos p ON h.id_prestamo = p.id
              GROUP BY YEAR(h.fecha_calculo), MONTH(h.fecha_calculo)
              ORDER BY anio DESC, mes DESC
              LIMIT 12";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Procesar los resultados para asegurar que todas las claves existan
        foreach ($resultados as &$fila) {
            $fila['anio'] = $fila['anio'] ?? 0;
            $fila['mes'] = $fila['mes'] ?? 0;
            $fila['total_libros'] = $fila['total_libros'] ?? 0;
            $fila['total_ahorrado'] = $fila['total_ahorrado'] ?? 0;
        }

        return $resultados;
    }

    public function calcularHuellaPrestamo($prestamoId)
    {
        // Factor de ahorro: 2.5 kg de CO2 por préstamo digital vs libro físico
        $ahorro = 2.5;

        $data = [
            'id_prestamo' => $prestamoId,
            'ahorro_co2_kg' => $ahorro
        ];

        return $this->create($data);
    }

    public function getEstadisticasHuella()
    {
        $query = "SELECT 
                COUNT(*) as total_prestamos,
                COALESCE(SUM(h.ahorro_co2_kg), 0) as total_co2_ahorrado,
                COALESCE(AVG(h.ahorro_co2_kg), 0) as promedio_por_prestamo,
                COALESCE(MAX(h.ahorro_co2_kg), 0) as maximo_ahorro,
                COUNT(DISTINCT p.id_usuario) as total_usuarios_activos
              FROM huella_carbono h
              INNER JOIN prestamos p ON h.id_prestamo = p.id";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Asegurar que todas las claves existan
        return [
            'total_prestamos' => $resultado['total_prestamos'] ?? 0,
            'total_co2_ahorrado' => $resultado['total_co2_ahorrado'] ?? 0,
            'promedio_por_prestamo' => $resultado['promedio_por_prestamo'] ?? 0,
            'maximo_ahorro' => $resultado['maximo_ahorro'] ?? 0,
            'total_usuarios_activos' => $resultado['total_usuarios_activos'] ?? 0,
            'total_ahorrado' => $resultado['total_co2_ahorrado'] ?? 0, // alias para compatibilidad
            'total_libros_digitales' => $resultado['total_prestamos'] ?? 0 // alias para compatibilidad
        ];
    }

    public function getTopUsuariosEco($limit = 5)
    {
        $query = "SELECT u.nombre, 
                     COUNT(p.id) as total_libros,
                     COALESCE(SUM(h.ahorro_co2_kg), 0) as co2_ahorrado
              FROM usuarios u
              LEFT JOIN prestamos p ON u.id = p.id_usuario
              LEFT JOIN huella_carbono h ON p.id = h.id_prestamo
              WHERE u.rol = 'estudiante'
              GROUP BY u.id
              ORDER BY co2_ahorrado DESC
              LIMIT :limit";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Procesar resultados para asegurar claves
        foreach ($resultados as &$usuario) {
            $usuario['nombre'] = $usuario['nombre'] ?? 'Usuario';
            $usuario['total_libros'] = $usuario['total_libros'] ?? 0;
            $usuario['co2_ahorrado'] = $usuario['co2_ahorrado'] ?? 0;
        }

        return $resultados;
    }
}
