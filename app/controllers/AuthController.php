<?php
class AuthController extends Controller
{
    private $usuarioModel;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = $this->model('UsuarioModel');
    }

    public function login()
    {
        if ($this->isLoggedIn()) {
            // Si ya está logueado, redirigir según su rol actual
            if ($_SESSION['user_rol'] == 'administrador' || $_SESSION['user_rol'] == 'admin') {
                $this->redirect('admin/panel');
            } else {
                $this->redirect('dashboard');
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'email_error' => '',
                'password_error' => '',
                'title' => 'Iniciar Sesión - Biblioteca Verde UCV'
            ];

            // Validaciones
            if (empty($data['email'])) {
                $data['email_error'] = 'Por favor ingresa tu email';
            }

            if (empty($data['password'])) {
                $data['password_error'] = 'Por favor ingresa tu contraseña';
            }

            if (empty($data['email_error']) && empty($data['password_error'])) {
                $usuario = $this->usuarioModel->getByEmail($data['email']);

                if ($usuario && password_verify($data['password'], $usuario['password_hash'])) {
                    $this->createUserSession($usuario);

                    // DEBUG: Verificar qué rol tiene el usuario
                    error_log("Usuario logueado: " . $usuario['nombre'] . " - Rol: " . $usuario['rol']);

                    // Redirigir según el rol del usuario
                    if ($usuario['rol'] == 'administrador' || $usuario['rol'] == 'admin') {
                        $this->redirect('admin/panel'); // Para administradores
                    } else {
                        $this->redirect('dashboard'); // Para estudiantes/usuarios normales
                    }
                } else {
                    $data['password_error'] = 'Email o contraseña incorrectos';
                    $this->view('auth/login', $data);
                }
            } else {
                $this->view('auth/login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => '',
                'title' => 'Iniciar Sesión - Biblioteca Verde UCV'
            ];
            $this->view('auth/login', $data);
        }
    }

    public function register()
    {
        if ($this->isLoggedIn()) {
            $this->redirect('home');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nombre' => trim($_POST['nombre']),
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'confirm_password' => $_POST['confirm_password'],
                'telefono' => trim($_POST['telefono']),
                'nombre_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
                'telefono_error' => '',
                'title' => 'Registrarse - Biblioteca Verde UCV'
            ];

            // Validaciones
            if (empty($data['nombre'])) {
                $data['nombre_error'] = 'Por favor ingresa tu nombre';
            }

            if (empty($data['email'])) {
                $data['email_error'] = 'Por favor ingresa tu email';
            } elseif ($this->usuarioModel->getByEmail($data['email'])) {
                $data['email_error'] = 'El email ya está registrado';
            }

            if (empty($data['password'])) {
                $data['password_error'] = 'Por favor ingresa una contraseña';
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = 'La contraseña debe tener al menos 6 caracteres';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_error'] = 'Por favor confirma tu contraseña';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_error'] = 'Las contraseñas no coinciden';
                }
            }

            if (
                empty($data['nombre_error']) && empty($data['email_error']) &&
                empty($data['password_error']) && empty($data['confirm_password_error'])
            ) {

                $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

                $userData = [
                    'nombre' => $data['nombre'],
                    'email' => $data['email'],
                    'password_hash' => $password_hash,
                    'telefono' => $data['telefono'],
                    'rol' => 'estudiante' // Por defecto todos son estudiantes
                ];

                if ($this->usuarioModel->create($userData)) {
                    $_SESSION['success'] = '¡Registro exitoso! Ahora puedes iniciar sesión.';
                    $this->redirect('auth/login');
                } else {
                    die('Error al registrar el usuario');
                }
            } else {
                $this->view('auth/register', $data);
            }
        } else {
            $data = [
                'nombre' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'telefono' => '',
                'nombre_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
                'telefono_error' => '',
                'title' => 'Registrarse - Biblioteca Verde UCV'
            ];
            $this->view('auth/register', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_nombre']);
        unset($_SESSION['user_rol']);
        session_destroy();
        $this->redirect('auth/login');
    }

    private function createUserSession($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_nombre'] = $user['nombre'];
        $_SESSION['user_rol'] = $user['rol'];

        // DEBUG: Verificar sesión creada
        error_log("Sesión creada - User ID: " . $user['id'] . " - Rol: " . $user['rol']);
    }
}