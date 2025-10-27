<?php view_header(['title' => $title ?? 'Dashboard - Biblioteca Verde UCV']); ?>

<div class="dashboard-header">
    <div class="container">
        <h1><i class="fas fa-tachometer-alt"></i> Mi Dashboard</h1>
        <p>Bienvenido a tu panel de control de la Biblioteca Verde UCV</p>
    </div>
</div>

<div class="container">
    <!-- Estadísticas Rápidas -->
    <div class="grid grid-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-book-open text-primary"></i>
                </div>
                <h3><?php echo $data['prestamos_activos']; ?></h3>
                <p>Préstamos Activos</p>
            </div>
        </div>

        <div class="card text-center">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-history text-warning"></i>
                </div>
                <h3><?php echo $data['prestamos_totales']; ?></h3>
                <p>Total de Préstamos</p>
            </div>
        </div>

        <div class="card text-center">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-leaf text-success"></i>
                </div>
                <h3><?php echo number_format($data['ahorro_total'], 2); ?> kg</h3>
                <p>CO₂ Ahorrado</p>
            </div>
        </div>

        <div class="card text-center">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                </div>
                <h3><?php echo $data['prestamos_vencidos']; ?></h3>
                <p>Préstamos Vencidos</p>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="grid grid-2 mt-4">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-rocket"></i> Acciones Rápidas</h3>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="<?php echo URLROOT; ?>libro/catalogo" class="quick-action-item">
                        <div class="quick-action-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="quick-action-content">
                            <h4>Explorar Catálogo</h4>
                            <p>Descubre nuevos libros disponibles</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>

                    <a href="<?php echo URLROOT; ?>prestamo/misPrestamos" class="quick-action-item">
                        <div class="quick-action-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="quick-action-content">
                            <h4>Mis Préstamos</h4>
                            <p>Gestiona tus préstamos actuales</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>

                    <a href="<?php echo URLROOT; ?>usuario/perfil" class="quick-action-item">
                        <div class="quick-action-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="quick-action-content">
                            <h4>Mi Perfil</h4>
                            <p>Actualizar información personal</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Libros Recientes -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-star"></i> Libros Recientes</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($data['libros_recientes'])) : ?>
                    <div class="recent-books">
                        <?php foreach ($data['libros_recientes'] as $libro) : ?>
                            <div class="recent-book-item">
                                <div class="book-cover">
                                    <?php if ($libro['portada']) : ?>
                                        <img src="<?php echo URLROOT . 'uploads/' . $libro['portada']; ?>"
                                            alt="<?php echo $libro['titulo']; ?>">
                                    <?php else : ?>
                                        <div class="book-cover-placeholder">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="book-info">
                                    <h5><?php echo $libro['titulo']; ?></h5>
                                    <p class="text-muted"><?php echo $libro['autor']; ?></p>
                                    <span class="badge" style="background-color: <?php echo $libro['categoria_color']; ?>">
                                        <?php echo $libro['categoria_nombre']; ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="text-center p-3">
                        <i class="fas fa-book-open fa-2x text-muted mb-2"></i>
                        <p class="text-muted">No hay libros recientes</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Mensaje de Bienvenida/Noticias -->
    <div class="card mt-4">
        <div class="card-header">
            <h3><i class="fas fa-info-circle"></i> Bienvenido a la Biblioteca Verde UCV</h3>
        </div>
        <div class="card-body">
            <div class="welcome-message">
                <p>¡Hola! Estás contribuyendo al medio ambiente mediante el uso de libros digitales.
                    Cada préstamo que realizas ayuda a reducir la huella de carbono.</p>

                <div class="eco-tips">
                    <h5><i class="fas fa-lightbulb"></i> ¿Sabías que?</h5>
                    <ul>
                        <li>Al leer digitalmente, ahorras aproximadamente 2.5 kg de CO₂ por libro</li>
                        <li>Estás ayudando a reducir la tala de árboles</li>
                        <li>Contribuyes a disminuir el consumo de agua y energía en la producción de libros físicos</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }

    .dashboard-header h1 {
        margin: 0;
        font-size: 2.5rem;
    }

    .dashboard-header p {
        margin: 0;
        opacity: 0.9;
    }

    /* Tarjetas de estadísticas */
    .card.text-center {
        text-align: center;
        transition: transform 0.2s;
    }

    .card.text-center:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .card.text-center h3 {
        font-size: 2.5rem;
        margin: 0.5rem 0;
        color: var(--primary-color);
    }

    .card.text-center p {
        margin: 0;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Acciones rápidas */
    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .quick-action-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border: 1px solid #eee;
        border-radius: 8px;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s;
    }

    .quick-action-item:hover {
        background: #f8f9fa;
        border-color: var(--primary-color);
        transform: translateX(5px);
    }

    .quick-action-icon {
        width: 50px;
        height: 50px;
        background: var(--light-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
        color: var(--primary-color);
    }

    .quick-action-content {
        flex: 1;
    }

    .quick-action-content h4 {
        margin: 0 0 0.25rem 0;
        color: var(--secondary-color);
    }

    .quick-action-content p {
        margin: 0;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    /* Libros recientes */
    .recent-books {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .recent-book-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border: 1px solid #eee;
        border-radius: 8px;
    }

    .book-cover {
        width: 40px;
        height: 50px;
        margin-right: 1rem;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
    }

    .book-cover-placeholder {
        width: 100%;
        height: 100%;
        background: var(--accent-color);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .book-info h5 {
        margin: 0 0 0.25rem 0;
        font-size: 0.9rem;
    }

    .book-info p {
        margin: 0;
        font-size: 0.8rem;
    }

    /* Mensaje de bienvenida */
    .welcome-message {
        line-height: 1.6;
    }

    .eco-tips {
        margin-top: 1.5rem;
        padding: 1rem;
        background: #e8f5e8;
        border-radius: 8px;
        border-left: 4px solid var(--success-color);
    }

    .eco-tips h5 {
        color: var(--success-color);
        margin-bottom: 0.5rem;
    }

    .eco-tips ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    .eco-tips li {
        margin-bottom: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .grid.grid-4 {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid.grid-2 {
            grid-template-columns: 1fr;
        }

        .quick-action-item {
            padding: 0.75rem;
        }

        .quick-action-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }
</style>

<?php view_footer(); ?>