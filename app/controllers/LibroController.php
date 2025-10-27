<?php
class LibroController extends Controller
{
    private $libroModel;
    private $categoriaModel;

    public function __construct()
    {
        $this->libroModel = $this->model('LibroModel');
        $this->categoriaModel = $this->model('CategoriaModel');
    }

    public function catalogo()
    {
        $this->requireLogin();

        $categoria_id = isset($_GET['categoria']) ? $_GET['categoria'] : null;
        $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : null;

        if ($busqueda) {
            $libros = $this->libroModel->search($busqueda);
        } elseif ($categoria_id) {
            $libros = $this->libroModel->getByCategory($categoria_id);
        } else {
            $libros = $this->libroModel->getWithCategory();
        }

        $categorias = $this->categoriaModel->getAll();

        $data = [
            'libros' => $libros,
            'categorias' => $categorias,
            'categoria_actual' => $categoria_id,
            'busqueda_actual' => $busqueda,
            'title' => 'Catálogo - Biblioteca Verde UCV'
        ];

        $this->view('estudiante/catalogo', $data);
    }

    public function detalle($id)
    {
        $this->requireLogin();

        $libro = $this->libroModel->find($id);
        if (!$libro) {
            $this->redirect('libro/catalogo');
        }

        $categoria = $this->categoriaModel->find($libro['id_categoria']);
        $libro['categoria_nombre'] = $categoria['nombre'];
        $libro['categoria_color'] = $categoria['color'];

        $data = [
            'libro' => $libro,
            'title' => $libro['titulo'] . ' - Biblioteca Verde UCV'
        ];

        $this->view('estudiante/detalle_libro', $data);
    }

    // Métodos de administración
    public function gestionar()
    {
        $this->requireAdmin();

        $libros = $this->libroModel->getWithCategory();
        $categorias = $this->categoriaModel->getAll();

        $data = [
            'libros' => $libros,
            'categorias' => $categorias,
            'title' => 'Gestionar Libros - Biblioteca Verde UCV'
        ];

        $this->view('admin/gestionar_libros', $data);
    }

    public function agregar()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // VALIDAR CAMPOS OBLIGATORIOS
            $camposObligatorios = ['titulo', 'autor', 'isbn', 'id_categoria', 'estado'];
            $errores = [];

            foreach ($camposObligatorios as $campo) {
                if (empty(trim($_POST[$campo] ?? ''))) {
                    $errores[] = "El campo " . ucfirst($campo) . " es obligatorio";
                }
            }

            $isbn = trim($_POST['isbn']);
            if (!empty($isbn)) {
                $libroExistente = $this->libroModel->findByIsbn($isbn);
                if ($libroExistente) {
                    $errores[] = "El ISBN ya está registrado en el sistema";
                }
            }

            if (!empty($errores)) {
                $_SESSION['error'] = implode('<br>', $errores);
                $this->redirect('libro/gestionar');
            }

            $data = [
                'titulo' => trim($_POST['titulo']),
                'autor' => trim($_POST['autor']),
                'isbn' => $isbn,
                'id_categoria' => (int)$_POST['id_categoria'],
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'fecha_publicacion' => !empty($_POST['fecha_publicacion']) ? $_POST['fecha_publicacion'] : null,
                'editorial' => trim($_POST['editorial'] ?? ''),
                'paginas' => !empty($_POST['paginas']) ? (int)$_POST['paginas'] : null,
                'estado' => $_POST['estado'],
                'fecha_agregado' => date('Y-m-d H:i:s')
            ];

            if ($this->libroModel->create($data)) {
                $_SESSION['success'] = 'Libro agregado correctamente';
                $this->redirect('libro/gestionar');
            } else {
                $_SESSION['error'] = 'Error al agregar el libro';
                $this->redirect('libro/gestionar');
            }
        }
    }

    public function editar($id)
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Procesar actualización
            $data = [
                'titulo' => trim($_POST['titulo']),
                'autor' => trim($_POST['autor']),
                'isbn' => trim($_POST['isbn']),
                'id_categoria' => $_POST['id_categoria'],
                'descripcion' => trim($_POST['descripcion']),
                'fecha_publicacion' => $_POST['fecha_publicacion'],
                'editorial' => trim($_POST['editorial']),
                'paginas' => $_POST['paginas'],
                'estado' => $_POST['estado']
            ];

            if ($this->libroModel->update($id, $data)) {
                $_SESSION['success'] = 'Libro actualizado correctamente';
                $this->redirect('libro/gestionar');
            } else {
                $_SESSION['error'] = 'Error al actualizar el libro';
                $this->redirect('libro/gestionar');
            }
        } else {
            // Mostrar formulario de edición
            $libro = $this->libroModel->find($id);
            if (!$libro) {
                $_SESSION['error'] = 'Libro no encontrado';
                $this->redirect('libro/gestionar');
            }

            $categorias = $this->categoriaModel->getAll();

            $data = [
                'libro' => $libro,
                'categorias' => $categorias,
                'title' => 'Editar Libro - Biblioteca Verde UCV'
            ];

            $this->view('admin/editar_libro', $data);
        }
    }

    public function eliminar($id)
    {
        $this->requireAdmin();

        if ($this->libroModel->delete($id)) {
            $_SESSION['success'] = 'Libro eliminado correctamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el libro';
        }

        $this->redirect('libro/gestionar');
    }
}
