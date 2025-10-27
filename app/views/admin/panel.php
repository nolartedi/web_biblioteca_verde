<?php view_header(['title' => $title ?? 'Biblioteca Verde UCV']); ?>

<div class="dashboard-header">
    <div class="container">
        <h1><i class="fas fa-tachometer-alt"></i> Panel de Administración</h1>
        <p>Gestión completa de la Biblioteca Verde UCV</p>
    </div>
</div>

<div class="container">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?php echo $data['total_usuarios']; ?></div>
                <div class="stat-label">Usuarios Registrados</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?php echo $data['total_libros']; ?></div>
                <div class="stat-label">Libros en Catálogo</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?php echo $data['prestamos_activos']; ?></div>
                <div class="stat-label">Préstamos Activos</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?php echo $data['prestamos_vencidos']; ?></div>
                <div class="stat-label">Préstamos Vencidos</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-leaf"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?php echo number_format($data['ahorro_total'], 2); ?> kg</div>
                <div class="stat-label">CO2 Ahorrado</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?php echo $data['estadisticas_huella']['total_prestamos'] ?? 0; ?></div>
                <div class="stat-label">Total Préstamos</div>
            </div>
        </div>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie"></i> Libros por Categoría</h3>
            </div>
            <div class="card-body">
                <div class="category-stats">
                    <?php foreach ($data['libros_por_categoria'] as $categoria) : ?>
                        <div class="category-stat-item">
                            <div class="category-info">
                                <span class="category-color"
                                    style="background-color: <?php echo $categoria['color']; ?>"></span>
                                <span class="category-name"><?php echo $categoria['nombre']; ?></span>
                            </div>
                            <div class="category-count">
                                <span class="count"><?php echo $categoria['cantidad']; ?></span>
                                <span class="percentage">
                                    <?php
                                    $porcentaje = $data['total_libros'] > 0 ?
                                        round(($categoria['cantidad'] / $data['total_libros']) * 100, 1) : 0;
                                    echo $porcentaje . '%';
                                    ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-leaf"></i> Huella de Carbono</h3>
            </div>
            <div class="card-body">
                <div class="huella-stats">
                    <div class="huella-stat">
                        <div class="huella-value">
                            <?php echo number_format($data['estadisticas_huella']['total_co2_ahorrado'] ?? 0, 2); ?> kg
                        </div>
                        <div class="huella-label">Total CO2 Ahorrado</div>
                    </div>
                    <div class="huella-stat">
                        <div class="huella-value">
                            <?php echo number_format($data['estadisticas_huella']['promedio_por_prestamo'] ?? 0, 2); ?>
                            kg</div>
                        <div class="huella-label">Promedio por Préstamo</div>
                    </div>
                    <div class="huella-stat">
                        <div class="huella-value"><?php echo $data['estadisticas_huella']['total_prestamos'] ?? 0; ?>
                        </div>
                        <div class="huella-label">Total de Préstamos</div>
                    </div>
                </div>
                <div class="huella-equivalente">
                    <h4>Equivalente a:</h4>
                    <ul>
                        <li>🌳
                            <?php echo round(($data['estadisticas_huella']['total_co2_ahorrado'] ?? 0) / 21.77, 1); ?>
                            árboles plantados</li>
                        <li>🚗 <?php echo round(($data['estadisticas_huella']['total_co2_ahorrado'] ?? 0) * 4.8, 1); ?>
                            km no recorridos</li>
                        <li>💡 <?php echo round(($data['estadisticas_huella']['total_co2_ahorrado'] ?? 0) * 6, 1); ?>
                            días de energía en casa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-2 mt-2">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-clock"></i> Acciones Rápidas</h3>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="<?php echo URLROOT; ?>prestamo/gestionar" class="quick-action">
                        <div class="action-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="action-content">
                            <h4>Gestionar Préstamos</h4>
                            <p>Ver y administrar todos los préstamos</p>
                        </div>
                    </a>
                    <a href="<?php echo URLROOT; ?>libro/gestionar" class="quick-action">
                        <div class="action-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="action-content">
                            <h4>Gestionar Libros</h4>
                            <p>Agregar, editar o eliminar libros del catálogo</p>
                        </div>
                    </a>
                    <a href="<?php echo URLROOT; ?>admin/gestionarCategorias" class="quick-action">
                        <div class="action-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="action-content">
                            <h4>Gestionar Categorías</h4>
                            <p>Administrar categorías de libros</p>
                        </div>
                    </a>
                    <a href="<?php echo URLROOT; ?>admin/reporteHuellaCarbono" class="quick-action">
                        <div class="action-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="action-content">
                            <h4>Reportes</h4>
                            <p>Ver reportes detallados de huella de carbono</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-bell"></i> Alertas del Sistema</h3>
            </div>
            <div class="card-body">
                <div class="alerts-list">
                    <?php if ($data['prestamos_vencidos'] > 0) : ?>
                        <div class="alert-item alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div class="alert-content">
                                <h4>Préstamos Vencidos</h4>
                                <p>Tienes <?php echo $data['prestamos_vencidos']; ?> préstamos vencidos que requieren
                                    atención.</p>
                            </div>
                            <a href="<?php echo URLROOT; ?>prestamo/gestionar" class="btn btn-sm btn-warning">Revisar</a>
                        </div>
                    <?php endif; ?>

                    <?php if ($data['total_libros'] == 0) : ?>
                        <div class="alert-item alert-info">
                            <i class="fas fa-info-circle"></i>
                            <div class="alert-content">
                                <h4>Catálogo Vacío</h4>
                                <p>No hay libros en el catálogo. Agrega algunos libros para comenzar.</p>
                            </div>
                            <a href="<?php echo URLROOT; ?>libro/gestionar" class="btn btn-sm btn-primary">Agregar
                                Libros</a>
                        </div>
                    <?php endif; ?>

                    <div class="alert-item alert-success">
                        <i class="fas fa-check-circle"></i>
                        <div class="alert-content">
                            <h4>Sistema Operativo</h4>
                            <p>Todos los módulos del sistema están funcionando correctamente.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .category-stats {
        space-y: 1rem;
    }

    .category-stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: var(--light-color);
        border-radius: 8px;
    }

    .category-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .category-color {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        display: inline-block;
    }

    .category-name {
        font-weight: 500;
        color: var(--secondary-color);
    }

    .category-count {
        text-align: right;
    }

    .count {
        font-weight: bold;
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .percentage {
        display: block;
        font-size: 0.8rem;
        color: #666;
    }

    .huella-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .huella-stat {
        text-align: center;
        padding: 1rem;
        background: var(--light-color);
        border-radius: 8px;
    }

    .huella-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .huella-label {
        font-size: 0.8rem;
        color: var(--dark-color);
    }

    .huella-equivalente ul {
        list-style: none;
        padding: 0;
    }

    .huella-equivalente li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .quick-action {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--light-color);
        border-radius: 8px;
        text-decoration: none;
        color: inherit;
        transition: transform 0.3s ease;
    }

    .quick-action:hover {
        transform: translateY(-2px);
        background: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .action-icon {
        width: 50px;
        height: 50px;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .action-content h4 {
        margin-bottom: 0.25rem;
        color: var(--secondary-color);
    }

    .action-content p {
        color: #666;
        font-size: 0.9rem;
        margin: 0;
    }

    .alerts-list {
        space-y: 1rem;
    }

    .alert-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid;
    }

    .alert-warning {
        background: #fff3cd;
        border-left-color: #ffc107;
        color: #856404;
    }

    .alert-info {
        background: #d1ecf1;
        border-left-color: #17a2b8;
        color: #0c5460;
    }

    .alert-success {
        background: #d4edda;
        border-left-color: #28a745;
        color: #155724;
    }

    .alert-item i {
        font-size: 1.5rem;
    }

    .alert-content {
        flex: 1;
    }

    .alert-content h4 {
        margin-bottom: 0.25rem;
    }

    .alert-content p {
        margin: 0;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .huella-stats {
            grid-template-columns: 1fr;
        }

        .quick-action {
            flex-direction: column;
            text-align: center;
        }

        .alert-item {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<?php view_footer(); ?>