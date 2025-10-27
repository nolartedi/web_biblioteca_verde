<?php
class HomeController extends Controller
{
    private $libroModel;
    private $prestamoModel;
    private $huellaCarbonoModel;

    public function __construct()
    {
        $this->libroModel = $this->model('LibroModel');
        $this->prestamoModel = $this->model('PrestamoModel');
        $this->huellaCarbonoModel = $this->model('HuellaCarbonoModel');
    }

    public function index()
    {
        // Obtener libros destacados por popularidad (préstamos)
        $librosDestacados = $this->libroModel->getDestacados(6);

        // Obtener total de libros disponibles
        $libros = $this->libroModel->getWithCategory();

        $data = [
            'libros_destacados' => $librosDestacados,
            'total_libros' => count($libros),
            'title' => 'Inicio - Biblioteca Verde UCV'
        ];

        $this->view('home', $data);
    }

    public function about()
    {
        $data = ['title' => 'Acerca de Biblioteca Verde UCV'];
        $this->view('about', $data);
    }
}