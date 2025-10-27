<?php view_header(['title' => $title ?? 'Mi Perfil - Biblioteca Verde UCV']); ?>

<div class="dashboard-header">
    <div class="container">
        <h1><i class="fas fa-user"></i> Mi Perfil</h1>
        <p>Gestiona tu información personal y contraseña</p>
    </div>
</div>

<div class="container">
    <div class="grid grid-2">
        <!-- Información del Perfil -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-edit"></i> Editar Información Personal</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo URLROOT; ?>usuario/actualizar" method="post">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre Completo *</label>
                        <input type="text" name="nombre" class="form-control" required
                            value="<?php echo $data['usuario']['nombre']; ?>">
                        <?php if (isset($_SESSION['form_errors']['nombre'])) : ?>
                        <span class="error-text"><?php echo $_SESSION['form_errors']['nombre']; ?></span>
                        <?php unset($_SESSION['form_errors']['nombre']); ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?php echo $data['usuario']['email']; ?>"
                            disabled>
                        <small class="text-muted">El email no se puede cambiar</small>
                    </div>

                    <div class="grid grid-2">
                        <div class="form-group">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control"
                                value="<?php echo $data['usuario']['telefono'] ?? ''; ?>" placeholder="Ej: 123456789">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Cambiar Contraseña -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-key"></i> Cambiar Contraseña</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo URLROOT; ?>usuario/cambiarPassword" method="post">
                    <div class="form-group">
                        <label for="current_password" class="form-label">Contraseña Actual *</label>
                        <input type="password" name="current_password" class="form-control" required>
                        <?php if (isset($_SESSION['password_errors']['current_password'])) : ?>
                        <span class="error-text"><?php echo $_SESSION['password_errors']['current_password']; ?></span>
                        <?php unset($_SESSION['password_errors']['current_password']); ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="new_password" class="form-label">Nueva Contraseña *</label>
                        <input type="password" name="new_password" class="form-control" required>
                        <?php if (isset($_SESSION['password_errors']['new_password'])) : ?>
                        <span class="error-text"><?php echo $_SESSION['password_errors']['new_password']; ?></span>
                        <?php unset($_SESSION['password_errors']['new_password']); ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña *</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                        <?php if (isset($_SESSION['password_errors']['confirm_password'])) : ?>
                        <span class="error-text"><?php echo $_SESSION['password_errors']['confirm_password']; ?></span>
                        <?php unset($_SESSION['password_errors']['confirm_password']); ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Cambiar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Información de la Cuenta -->
    <div class="card mt-4">
        <div class="card-header">
            <h3><i class="fas fa-info-circle"></i> Información de la Cuenta</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-3">
                <div class="info-item">
                    <label>Rol:</label>
                    <span
                        class="badge <?php echo $data['usuario']['rol'] == 'admin' ? 'badge-danger' : 'badge-primary'; ?>">
                        <?php echo $data['usuario']['rol'] == 'admin' ? 'Administrador' : 'Estudiante'; ?>
                    </span>
                </div>
                <div class="info-item">
                    <label>Fecha de Registro:</label>
                    <span><?php echo date('d/m/Y', strtotime($data['usuario']['fecha_registro'])); ?></span>
                </div>
                <div class="info-item">
                    <label>Estado:</label>
                    <span class="badge badge-success">Activo</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-item label {
    font-weight: 600;
    color: var(--secondary-color);
    margin: 0;
}

.info-item span {
    color: var(--text-color);
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-primary {
    background: var(--primary-color);
    color: white;
}

.badge-danger {
    background: #dc3545;
    color: white;
}

.badge-success {
    background: var(--success-color);
    color: white;
}

.error-text {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}

.text-muted {
    color: #6c757d;
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .grid.grid-2 {
        grid-template-columns: 1fr;
    }

    .grid.grid-3 {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}
</style>

<?php view_footer(); ?>