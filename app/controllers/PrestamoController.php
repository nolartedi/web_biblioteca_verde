<?php
class PrestamoController extends Controller
{
    private $prestamoModel;
    private $libroModel;
    private $huellaCarbonoModel;

    public function __construct()
    {
        parent::__construct();
        $this->prestamoModel = $this->model('PrestamoModel');
        $this->libroModel = $this->model('LibroModel');
        $this->huellaCarbonoModel = $this->model('HuellaCarbonoModel');
    }

    public function misPrestamos()
    {
        $this->requireLogin();

        $prestamos = $this->prestamoModel->getByUsuario($_SESSION['user_id']);

        $data = [
            'prestamos' => $prestamos,
            'title' => 'Mis Préstamos - Biblioteca Verde UCV'
        ];

        $this->view('estudiante/mis_prestamos', $data);
    }

    public function solicitar($libro_id)
    {
        $this->requireLogin();

        $libro = $this->libroModel->find($libro_id);
        if (!$libro || $libro['estado'] != 'disponible') {
            $_SESSION['error'] = 'El libro no está disponible para préstamo';
            $this->redirect('libro/catalogo');
        }

        // Calcular fecha límite (14 días)
        $fechaLimite = date('Y-m-d', strtotime('+14 days'));

        $data = [
            'id_usuario' => $_SESSION['user_id'],
            'id_libro' => $libro_id,
            'fecha_limite' => $fechaLimite,
            'estado' => 'activo'
        ];

        if ($this->prestamoModel->create($data)) {
            // Actualizar estado del libro
            $this->libroModel->updateEstado($libro_id, 'prestado');

            // Calcular huella de carbono
            $prestamoId = $this->prestamoModel->getLastInsertId();
            $this->huellaCarbonoModel->calcularHuellaPrestamo($prestamoId);

            $_SESSION['success'] = 'Préstamo solicitado correctamente';
        } else {
            $_SESSION['error'] = 'Error al solicitar el préstamo';
        }

        $this->redirect('prestamo/misPrestamos');
    }

    public function devolver($prestamo_id)
    {
        $this->requireLogin();

        $prestamo = $this->prestamoModel->find($prestamo_id);

        // Verificar que el préstamo pertenece al usuario
        if ($prestamo['id_usuario'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'No tienes permisos para esta acción';
            $this->redirect('prestamo/misPrestamos');
        }

        if ($this->prestamoModel->realizarDevolucion($prestamo_id)) {
            // Actualizar estado del libro
            $this->libroModel->updateEstado($prestamo['id_libro'], 'disponible');

            $_SESSION['success'] = 'Libro devuelto correctamente';
        } else {
            $_SESSION['error'] = 'Error al devolver el libro';
        }

        $this->redirect('prestamo/misPrestamos');
    }

    // Métodos de administración
    public function gestionar()
    {
        $this->requireAdmin();

        $prestamos = $this->prestamoModel->getWithDetails();

        $data = [
            'prestamos' => $prestamos,
            'title' => 'Gestionar Préstamos - Biblioteca Verde UCV'
        ];

        $this->view('admin/gestionar_prestamos', $data);
    }

    public function administrarDevolucion($prestamo_id)
    {
        $this->requireAdmin();

        $prestamo = $this->prestamoModel->find($prestamo_id);

        if ($this->prestamoModel->realizarDevolucion($prestamo_id)) {
            // Actualizar estado del libro
            $this->libroModel->updateEstado($prestamo['id_libro'], 'disponible');

            $_SESSION['success'] = 'Devolución registrada correctamente';
        } else {
            $_SESSION['error'] = 'Error al registrar la devolución';
        }

        $this->redirect('prestamo/gestionar');
    }
}