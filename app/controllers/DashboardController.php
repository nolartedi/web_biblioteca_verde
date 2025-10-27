<?php
class DashboardController extends Controller
{

    private $prestamoModel;
    private $huellaCarbonoModel;
    private $libroModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireLogin();
        $this->prestamoModel = $this->model('PrestamoModel');
        $this->huellaCarbonoModel = $this->model('HuellaCarbonoModel');
        $this->libroModel = $this->model('LibroModel');
    }

    public function index()
    {
        $userId = $_SESSION['user_id'];

        // Obtener estadísticas del usuario
        $prestamos = $this->prestamoModel->getByUsuario($userId);
        $prestamosActivos = array_filter($prestamos, function ($p) {
            return $p['estado'] == 'activo' || $p['estado'] == 'pendiente';
        });

        $prestamosVencidos = array_filter($prestamos, function ($p) {
            return $p['estado'] == 'vencido';
        });

        $ahorroTotal = $this->huellaCarbonoModel->getAhorroPorUsuario($userId);

        // Libros recientemente agregados para sugerir
        $librosRecientes = $this->libroModel->getRecientes(5);

        $data = [
            'prestamos_activos' => count($prestamosActivos),
            'prestamos_vencidos' => count($prestamosVencidos),
            'prestamos_totales' => count($prestamos),
            'ahorro_total' => $ahorroTotal,
            'libros_recientes' => $librosRecientes,
            'title' => 'Dashboard - Biblioteca Verde UCV'
        ];

        $this->view('estudiante/dashboard', $data);
    }
}
