<?php view_header(['title' => $title ?? 'Biblioteca Verde UCV']); ?>

<div class="dashboard-header">
    <div class="container">
        <h1><i class="fas fa-list"></i> Mis Préstamos</h1>
        <p>Gestiona tus libros prestados y revisa tu historial</p>
    </div>
</div>

<div class="container">
    <div class="stats-grid mb-2">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">
                    <?php
                    $activos = array_filter($data['prestamos'], function ($p) {
                        return $p['estado'] == 'activo';
                    });
                    echo count($activos);
                    ?>
                </div>
                <div class="stat-label">Préstamos Activos</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">
                    <?php
                    $devueltos = array_filter($data['prestamos'], function ($p) {
                        return $p['estado'] == 'devuelto';
                    });
                    echo count($devueltos);
                    ?>
                </div>
                <div class="stat-label">Devueltos</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">
                    <?php
                    $vencidos = array_filter($data['prestamos'], function ($p) {
                        return $p['estado'] == 'vencido';
                    });
                    echo count($vencidos);
                    ?>
                </div>
                <div class="stat-label">Vencidos</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-exchange-alt"></i> Historial de Préstamos</h3>
        </div>
        <div class="card-body">
            <?php if (empty($data['prestamos'])) : ?>
            <div class="text-center p-4">
                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                <h4>No tienes préstamos</h4>
                <p class="text-muted">Visita nuestro catálogo para solicitar tu primer libro.</p>
                <a href="<?php echo URLROOT; ?>libro/catalogo" class="btn btn-primary">
                    <i class="fas fa-book"></i> Explorar Catálogo
                </a>
            </div>
            <?php else : ?>
            <div class="prestamos-list">
                <?php foreach ($data['prestamos'] as $prestamo) : ?>
                <div class="prestamo-item <?php echo $prestamo['estado']; ?>">
                    <div class="prestamo-book">
                        <div class="book-cover-small">
                            <?php if ($prestamo['libro_portada']) : ?>
                            <img src="<?php echo URLROOT . 'uploads/' . $prestamo['libro_portada']; ?>"
                                alt="<?php echo $prestamo['libro_titulo']; ?>">
                            <?php else : ?>
                            <i class="fas fa-book"></i>
                            <?php endif; ?>
                        </div>
                        <div class="prestamo-book-info">
                            <h4><?php echo $prestamo['libro_titulo']; ?></h4>
                            <p class="book-author"><?php echo $prestamo['libro_autor']; ?></p>
                            <span class="book-category-small"
                                style="background-color: <?php echo $prestamo['categoria_color']; ?>">
                                <?php echo $prestamo['categoria_nombre']; ?>
                            </span>
                        </div>
                    </div>
                    <div class="prestamo-details">
                        <div class="prestamo-date">
                            <strong>Préstamo:</strong>
                            <?php echo date('d/m/Y', strtotime($prestamo['fecha_prestamo'])); ?>
                        </div>
                        <div class="prestamo-date">
                            <strong>Límite:</strong>
                            <?php echo date('d/m/Y', strtotime($prestamo['fecha_limite'])); ?>
                        </div>
                        <?php if ($prestamo['fecha_devolucion']) : ?>
                        <div class="prestamo-date">
                            <strong>Devolución:</strong>
                            <?php echo date('d/m/Y', strtotime($prestamo['fecha_devolucion'])); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="prestamo-status">
                        <span class="status-badge status-<?php echo $prestamo['estado']; ?>">
                            <?php
                                    $estados = [
                                        'activo' => 'Activo',
                                        'devuelto' => 'Devuelto',
                                        'vencido' => 'Vencido'
                                    ];
                                    echo $estados[$prestamo['estado']];
                                    ?>
                        </span>
                        <?php if ($prestamo['estado'] == 'activo') : ?>
                        <a href="<?php echo URLROOT; ?>prestamo/devolver/<?php echo $prestamo['id']; ?>"
                            class="btn btn-success btn-sm mt-1"
                            onclick="return confirm('¿Estás seguro de devolver este libro?')">
                            <i class="fas fa-undo"></i> Devolver
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-header">
            <h3><i class="fas fa-leaf"></i> Mi Impacto Ambiental</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-2">
                <div class="impact-stat">
                    <div class="impact-icon">
                        <i class="fas fa-tree"></i>
                    </div>
                    <div class="impact-content">
                        <div class="impact-value">
                            <?php echo count($data['prestamos']) * 2.5; ?> kg
                        </div>
                        <div class="impact-label">CO2 Ahorrado</div>
                    </div>
                </div>
                <div class="impact-stat">
                    <div class="impact-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="impact-content">
                        <div class="impact-value"><?php echo count($data['prestamos']); ?></div>
                        <div class="impact-label">Préstamos Totales</div>
                    </div>
                </div>
            </div>
            <div class="impact-equivalents mt-2">
                <h4>Tu ahorro equivale a:</h4>
                <div class="grid grid-3">
                    <div class="equivalent-item">
                        <i class="fas fa-car"></i>
                        <span><?php echo round(count($data['prestamos']) * 2.5 * 4.8, 1); ?> km</span>
                        <small>en automóvil</small>
                    </div>
                    <div class="equivalent-item">
                        <i class="fas fa-lightbulb"></i>
                        <span><?php echo count($data['prestamos']) * 15; ?> días</span>
                        <small>de energía eléctrica</small>
                    </div>
                    <div class="equivalent-item">
                        <i class="fas fa-seedling"></i>
                        <span><?php echo round(count($data['prestamos']) * 2.5 / 21.77, 1); ?></span>
                        <small>árboles plantados</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.prestamos-list {
    space-y: 1rem;
}

.prestamo-item {
    display: grid;
    grid-template-columns: 2fr 1fr auto;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--light-color);
    border-radius: 10px;
    align-items: center;
    transition: transform 0.3s ease;
}

.prestamo-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.prestamo-item.vencido {
    border-left: 4px solid var(--warning-color);
}

.prestamo-item.activo {
    border-left: 4px solid var(--success-color);
}

.prestamo-item.devuelto {
    border-left: 4px solid var(--accent-color);
}

.prestamo-book {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.book-cover-small {
    width: 60px;
    height: 80px;
    background: var(--accent-color);
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.book-cover-small img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 5px;
}

.prestamo-book-info h4 {
    margin-bottom: 0.25rem;
    color: var(--secondary-color);
}

.book-author {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.book-category-small {
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    background: var(--primary-color);
    color: white;
    border-radius: 10px;
}

.prestamo-details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.prestamo-date {
    font-size: 0.9rem;
    color: var(--dark-color);
}

.prestamo-status {
    text-align: center;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-activo {
    background: var(--success-color);
    color: white;
}

.status-devuelto {
    background: var(--accent-color);
    color: white;
}

.status-vencido {
    background: var(--warning-color);
    color: white;
}

.impact-stat {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.impact-icon {
    font-size: 2.5rem;
    color: var(--primary-color);
}

.impact-value {
    font-size: 2rem;
    font-weight: bold;
    color: var(--secondary-color);
}

.impact-label {
    color: var(--dark-color);
    font-size: 0.9rem;
}

.impact-equivalents {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.equivalent-item {
    text-align: center;
    padding: 1rem;
}

.equivalent-item i {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.equivalent-item span {
    display: block;
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--secondary-color);
    margin-bottom: 0.25rem;
}

.equivalent-item small {
    color: #666;
    font-size: 0.8rem;
}

@media (max-width: 768px) {
    .prestamo-item {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 1rem;
    }

    .prestamo-book {
        justify-content: center;
        text-align: center;
    }

    .prestamo-details {
        flex-direction: row;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .grid-3 {
        grid-template-columns: 1fr;
    }
}
</style>

<?php view_footer(); ?>