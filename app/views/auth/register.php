<?php view_header(['title' => $title ?? 'Biblioteca Verde UCV']); ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center"><i class="fas fa-user-plus"></i> Crear Cuenta</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo URLROOT; ?>auth/register" method="post">
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre Completo *</label>
                            <input type="text" name="nombre"
                                class="form-control <?php echo (!empty($data['nombre_error'])) ? 'error' : ''; ?>"
                                value="<?php echo $data['nombre']; ?>" placeholder="Tu nombre completo">
                            <?php if (!empty($data['nombre_error'])) : ?>
                            <span class="error-message"><?php echo $data['nombre_error']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" name="email"
                                class="form-control <?php echo (!empty($data['email_error'])) ? 'error' : ''; ?>"
                                value="<?php echo $data['email']; ?>" placeholder="tu@email.ucv.edu">
                            <?php if (!empty($data['email_error'])) : ?>
                            <span class="error-message"><?php echo $data['email_error']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="grid grid-2">
                        <div class="form-group">
                            <label for="password" class="form-label">Contraseña *</label>
                            <input type="password" name="password"
                                class="form-control <?php echo (!empty($data['password_error'])) ? 'error' : ''; ?>"
                                placeholder="Mínimo 6 caracteres">
                            <?php if (!empty($data['password_error'])) : ?>
                            <span class="error-message"><?php echo $data['password_error']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password" class="form-label">Confirmar Contraseña *</label>
                            <input type="password" name="confirm_password"
                                class="form-control <?php echo (!empty($data['confirm_password_error'])) ? 'error' : ''; ?>"
                                placeholder="Repite tu contraseña">
                            <?php if (!empty($data['confirm_password_error'])) : ?>
                            <span class="error-message"><?php echo $data['confirm_password_error']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="grid grid-2">
                        <div class="form-group">
                            <label for="telefono" class="form-label">Teléfono (Opcional)</label>
                            <input type="tel" name="telefono" class="form-control"
                                value="<?php echo $data['telefono']; ?>" placeholder="+51 XXX XXX XXX">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                    </div>

                    <div class="text-center">
                        <p>¿Ya tienes una cuenta? <a href="<?php echo URLROOT; ?>auth/login">Inicia sesión aquí</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.row {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
}

.col-md-8 {
    flex: 0 0 66.666667%;
    max-width: 700px;
}

.mx-auto {
    margin-left: auto;
    margin-right: auto;
}

.error-message {
    color: var(--warning-color);
    font-size: 0.9rem;
    margin-top: 0.25rem;
    display: block;
}

.form-control.error {
    border-color: var(--warning-color);
}

@media (max-width: 768px) {
    .grid-2 {
        grid-template-columns: 1fr;
    }
}
</style>

<?php view_footer(); ?>