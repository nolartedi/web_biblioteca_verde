<?php
class ChatbotController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view('chatbot/index');
    }

    public function conversar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mensaje = trim($_POST['mensaje']);

            // Respuestas predefinidas del chatbot (simulando IA)
            $respuesta = $this->generarRespuesta($mensaje);

            echo json_encode([
                'success' => true,
                'respuesta' => $respuesta
            ]);
        }
    }

    private function generarRespuesta($mensaje)
    {
        $mensaje = strtolower($mensaje);

        $respuestas = [
            'hola' => '¡Hola! Soy tu asistente virtual de la Biblioteca Verde UCV. ¿En qué puedo ayudarte?',
            'adiós' => '¡Hasta luego! Espero haberte ayudado.',
            'préstamo' => 'Puedes solicitar préstamos de libros digitales desde el catálogo. Cada préstamo tiene una duración de 14 días.',
            'devolución' => 'Puedes devolver tus libros desde la sección "Mis Préstamos". Los libros se devuelven automáticamente al vencer el plazo.',
            'huella de carbono' => 'Cada préstamo digital ahorra aproximadamente 2.5kg de CO2 comparedo con un libro físico. Puedes ver tu impacto en el dashboard.',
            'catálogo' => 'Tenemos una amplia variedad de libros digitales organizados por categorías. ¡Explora nuestro catálogo!',
            'contacto' => 'Puedes contactarnos a través del formulario de contacto o enviando un email a biblioteca@ucv.edu',
            'default' => 'Entiendo que quieres saber sobre "' . $mensaje . '". Te recomiendo explorar nuestro catálogo o contactar con soporte para más información específica.'
        ];

        foreach ($respuestas as $palabra => $respuesta) {
            if (strpos($mensaje, $palabra) !== false) {
                return $respuesta;
            }
        }

        return $respuestas['default'];
    }
}