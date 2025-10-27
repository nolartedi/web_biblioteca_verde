<?php
class AdminController extends Controller
{
    private $usuarioModel;
    private $libroModel;
    private $prestamoModel;
    private $categoriaModel;
    private $huellaCarbonoModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireAdmin();

        $this->usuarioModel = $this->model('UsuarioModel');
        $this->libroModel = $this->model('LibroModel');
        $this->prestamoModel = $this->model('PrestamoModel');
        $this->categoriaModel = $this->model('CategoriaModel');
        $this->huellaCarbonoModel = $this->model('HuellaCarbonoModel');
    }

    public function panel()
    {
        $totalUsuarios = count($this->usuarioModel->getAll());
        $totalLibros = count($this->libroModel->getAll());
        $prestamosActivos = count($this->prestamoModel->getActivos());
        $prestamosVencidos = count($this->prestamoModel->getVencidos());
        $ahorroTotal = $this->huellaCarbonoModel->getAhorroTotal();
        $estadisticasHuella = $this->huellaCarbonoModel->getEstadisticasHuella();
        $librosPorCategoria = $this->categoriaModel->getLibrosPorCategoria();

        $data = [
            'total_usuarios' => $totalUsuarios,
            'total_libros' => $totalLibros,
            'prestamos_activos' => $prestamosActivos,
            'prestamos_vencidos' => $prestamosVencidos,
            'ahorro_total' => $ahorroTotal,
            'estadisticas_huella' => $estadisticasHuella,
            'libros_por_categoria' => $librosPorCategoria
        ];

        $this->view('admin/panel', $data);
    }

    public function gestionarCategorias()
    {
        $categorias = $this->categoriaModel->getWithBookCount();
        $data = [
            'categorias' => $categorias,
            'title' => 'Gestionar Categorías - Biblioteca Verde UCV'
        ];

        $this->view('admin/gestionar_categorias', $data); // Corregido: nombre del archivo
    }

    public function agregarCategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion']),
                'color' => $_POST['color'],
                'icono' => $_POST['icono']
            ];

            if ($this->categoriaModel->create($data)) {
                $_SESSION['success'] = 'Categoría agregada correctamente';
            } else {
                $_SESSION['error'] = 'Error al agregar la categoría';
            }

            $this->redirect('admin/gestionarCategorias');
        }
    }

    public function editarCategoria($id)
    {
        // Si es una solicitud POST, procesar la actualización
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion']),
                'color' => $_POST['color'],
                'icono' => $_POST['icono']
            ];

            if ($this->categoriaModel->update($id, $data)) {
                $_SESSION['success'] = 'Categoría actualizada correctamente';
            } else {
                $_SESSION['error'] = 'Error al actualizar la categoría';
            }
            $this->redirect('admin/gestionarCategorias');
        } else {
            // Si es GET, mostrar el formulario de edición
            $categoria = $this->categoriaModel->find($id);

            if (!$categoria) {
                $_SESSION['error'] = 'Categoría no encontrada';
                $this->redirect('admin/gestionarCategorias');
            }

            $data = [
                'categoria' => $categoria,
                'title' => 'Editar Categoría - Biblioteca Verde UCV'
            ];

            $this->view('admin/editar_categoria', $data);
        }
    }

    public function eliminarCategoria($id)
    {
        if ($this->categoriaModel->tieneLibros($id)) {
            $_SESSION['error'] = 'No se puede eliminar la categoría porque tiene libros asociados. ' .
                'Primero mueve o elimina los libros de esta categoría.';
        } else {
            if ($this->categoriaModel->delete($id)) {
                $_SESSION['success'] = 'Categoría eliminada correctamente';
            } else {
                $_SESSION['error'] = 'Error al eliminar la categoría';
            }
        }

        $this->redirect('admin/gestionarCategorias');
    }

    public function reporteHuellaCarbono()
    {
        $ahorroMensual = $this->huellaCarbonoModel->getAhorroMensual();
        $estadisticas = $this->huellaCarbonoModel->getEstadisticasHuella();
        $topUsuarios = $this->huellaCarbonoModel->getTopUsuariosEco(5);

        // Calcular equivalencias
        $totalAhorrado = $estadisticas['total_ahorrado'] ?? 0;
        $estadisticas['arboles_equivalentes'] = $totalAhorrado > 0 ? $totalAhorrado / 21.77 : 0;

        $data = [
            'ahorro_mensual' => $ahorroMensual,
            'estadisticas' => $estadisticas,
            'top_usuarios' => $topUsuarios,
            'title' => 'Reporte de Huella de Carbono - Biblioteca Verde UCV'
        ];

        $this->view('admin/reporte_huella', $data);
    }
}