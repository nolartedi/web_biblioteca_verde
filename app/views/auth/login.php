<?php view_header(['title' => $title ?? 'Biblioteca Verde UCV']); ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo URLROOT; ?>auth/login" method="post">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email"
                            class="form-control <?php echo (!empty($data['email_error'])) ? 'error' : ''; ?>"
                            value="<?php echo $data['email']; ?>" placeholder="tu@email.ucv.edu">
                        <?php if (!empty($data['email_error'])) : ?>
                        <span class="error-message"><?php echo $data['email_error']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password"
                            class="form-control <?php echo (!empty($data['password_error'])) ? 'error' : ''; ?>"
                            placeholder="Tu contraseña">
                        <?php if (!empty($data['password_error'])) : ?>
                        <span class="error-message"><?php echo $data['password_error']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                    </div>

                    <div class="text-center">
                        <p>¿No tienes una cuenta? <a href="<?php echo URLROOT; ?>auth/register">Regístrate aquí</a></p>
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
    min-height: 70vh;
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
</style>

<?php view_footer(); ?>