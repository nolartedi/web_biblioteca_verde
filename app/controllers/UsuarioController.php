<?php
class UsuarioController extends Controller
{
    private $usuarioModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireLogin();
        $this->usuarioModel = $this->model('UsuarioModel');
    }

    public function perfil()
    {
        $userId = $_SESSION['user_id'];
        $usuario = $this->usuarioModel->find($userId);

        if (!$usuario) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('dashboard');
        }

        $data = [
            'usuario' => $usuario,
            'title' => 'Mi Perfil - Biblioteca Verde UCV'
        ];

        $this->view('usuario/perfil', $data);
    }

    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];

            $data = [
                'nombre' => trim($_POST['nombre']),
                'telefono' => trim($_POST['telefono'])
            ];

            // Validaciones
            $errors = [];

            if (empty($data['nombre'])) {
                $errors['nombre'] = 'El nombre es requerido';
            }

            if (empty($errors)) {
                if ($this->usuarioModel->updateProfile($userId, $data)) {
                    // Actualizar nombre en sesión
                    $_SESSION['user_nombre'] = $data['nombre'];
                    $_SESSION['success'] = 'Perfil actualizado correctamente';
                } else {
                    $_SESSION['error'] = 'Error al actualizar el perfil';
                }
            } else {
                $_SESSION['error'] = 'Por favor corrige los errores';
                $_SESSION['form_errors'] = $errors;
            }

            $this->redirect('usuario/perfil');
        }
    }

    public function cambiarPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];

            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Validaciones
            $errors = [];

            if (empty($currentPassword)) {
                $errors['current_password'] = 'La contraseña actual es requerida';
            }

            if (empty($newPassword)) {
                $errors['new_password'] = 'La nueva contraseña es requerida';
            } elseif (strlen($newPassword) < 6) {
                $errors['new_password'] = 'La contraseña debe tener al menos 6 caracteres';
            }

            if (empty($confirmPassword)) {
                $errors['confirm_password'] = 'Confirma tu nueva contraseña';
            } elseif ($newPassword !== $confirmPassword) {
                $errors['confirm_password'] = 'Las contraseñas no coinciden';
            }

            if (empty($errors)) {
                // Verificar contraseña actual
                $usuario = $this->usuarioModel->find($userId);

                if (!password_verify($currentPassword, $usuario['password_hash'])) {
                    $_SESSION['error'] = 'La contraseña actual es incorrecta';
                } else {
                    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                    if ($this->usuarioModel->changePassword($userId, $newPasswordHash)) {
                        $_SESSION['success'] = 'Contraseña cambiada correctamente';
                    } else {
                        $_SESSION['error'] = 'Error al cambiar la contraseña';
                    }
                }
            } else {
                $_SESSION['error'] = 'Por favor corrige los errores';
                $_SESSION['password_errors'] = $errors;
            }

            $this->redirect('usuario/perfil');
        }
    }
}