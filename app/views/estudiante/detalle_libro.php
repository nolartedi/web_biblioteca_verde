<?php view_header(['title' => $title ?? 'Biblioteca Verde UCV']); ?>

<div class="dashboard-header">
    <div class="container">
        <h1><i class="fas fa-book-open"></i> Detalle del Libro</h1>
        <p>Información completa del libro seleccionado</p>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="book-detail">
                <div class="book-detail-header">
                    <div class="book-cover-large">
                        <?php if ($data['libro']['portada']) : ?>
                        <img src="<?php echo URLROOT . 'uploads/' . $data['libro']['portada']; ?>"
                            alt="<?php echo $data['libro']['titulo']; ?>">
                        <?php else : ?>
                        <div class="book-cover-placeholder-large">
                            <i class="fas fa-book"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="book-detail-info">
                        <h1 class="book-title-large"><?php echo $data['libro']['titulo']; ?></h1>
                        <p class="book-author-large">
                            <i class="fas fa-user"></i> <?php echo $data['libro']['autor']; ?>
                        </p>

                        <div class="book-meta-large">
                            <span class="book-category-large"
                                style="background-color: <?php echo $data['libro']['categoria_color']; ?>">
                                <i class="fas fa-tag"></i> <?php echo $data['libro']['categoria_nombre']; ?>
                            </span>
                            <span class="book-status-large status-<?php echo $data['libro']['estado']; ?>">
                                <?php
                                $estados = [
                                    'disponible' => 'Disponible',
                                    'prestado' => 'Prestado',
                                    'mantenimiento' => 'En Mantenimiento'
                                ];
                                echo $estados[$data['libro']['estado']];
                                ?>
                            </span>
                        </div>

                        <div class="book-details-grid">
                            <?php if ($data['libro']['isbn']) : ?>
                            <div class="detail-item">
                                <strong>ISBN:</strong>
                                <span><?php echo $data['libro']['isbn']; ?></span>
                            </div>
                            <?php endif; ?>

                            <?php if ($data['libro']['fecha_publicacion']) : ?>
                            <div class="detail-item">
                                <strong>Año:</strong>
                                <span><?php echo $data['libro']['fecha_publicacion']; ?></span>
                            </div>
                            <?php endif; ?>

                            <?php if ($data['libro']['editorial']) : ?>
                            <div class="detail-item">
                                <strong>Editorial:</strong>
                                <span><?php echo $data['libro']['editorial']; ?></span>
                            </div>
                            <?php endif; ?>

                            <?php if ($data['libro']['paginas']) : ?>
                            <div class="detail-item">
                                <strong>Páginas:</strong>
                                <span><?php echo $data['libro']['paginas']; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="book-actions-large">
                            <?php if ($data['libro']['estado'] == 'disponible') : ?>
                            <a href="<?php echo URLROOT; ?>prestamo/solicitar/<?php echo $data['libro']['id']; ?>"
                                class="btn btn-primary btn-large"
                                onclick="return confirm('¿Estás seguro de solicitar este libro?')">
                                <i class="fas fa-hand-holding"></i> Solicitar Préstamo
                            </a>
                            <?php else : ?>
                            <button class="btn btn-secondary btn-large" disabled>
                                <i class="fas fa-clock"></i> No Disponible para Préstamo
                            </button>
                            <?php endif; ?>

                            <a href="<?php echo URLROOT; ?>libro/catalogo" class="btn btn-outline">
                                <i class="fas fa-arrow-left"></i> Volver al Catálogo
                            </a>
                        </div>
                    </div>
                </div>

                <div class="book-description-section">
                    <h3>Descripción</h3>
                    <p class="book-description-full">
                        <?php echo $data['libro']['descripcion'] ?: 'No hay descripción disponible para este libro.'; ?>
                    </p>
                </div>

                <div class="book-impact-section">
                    <h3>Impacto Ambiental</h3>
                    <div class="impact-cards">
                        <div class="impact-card">
                            <div class="impact-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <div class="impact-content">
                                <div class="impact-value">2.5 kg</div>
                                <div class="impact-label">CO2 Ahorrado</div>
                                <div class="impact-description">Por préstamo digital vs libro físico</div>
                            </div>
                        </div>
                        <div class="impact-card">
                            <div class="impact-icon">
                                <i class="fas fa-tree"></i>
                            </div>
                            <div class="impact-content">
                                <div class="impact-value">0.11</div>
                                <div class="impact-label">Árboles Salvados</div>
                                <div class="impact-description">Equivalente por préstamo</div>
                            </div>
                        </div>
                        <div class="impact-card">
                            <div class="impact-icon">
                                <i class="fas fa-tint"></i>
                            </div>
                            <div class="impact-content">
                                <div class="impact-value">240 L</div>
                                <div class="impact-label">Agua Conservada</div>
                                <div class="impact-description">En producción de papel</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.book-detail-header {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.book-cover-large {
    width: 300px;
    height: 400px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.book-cover-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.book-cover-placeholder-large {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 4rem;
}

.book-title-large {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--secondary-color);
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.book-author-large {
    font-size: 1.3rem;
    color: #666;
    margin-bottom: 1.5rem;
}

.book-meta-large {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.book-category-large {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
}

.book-status-large {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
}

.status-disponible {
    background: var(--success-color);
}

.status-prestado {
    background: var(--warning-color);
}

.status-mantenimiento {
    background: #95a5a6;
}

.book-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--light-color);
    border-radius: 10px;
}

.detail-item {
    display: flex;
    flex-direction: column;
}

.detail-item strong {
    color: var(--secondary-color);
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.detail-item span {
    color: var(--dark-color);
    font-weight: 500;
}

.book-actions-large {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-large {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
}

.btn-outline {
    background: transparent;
    border: 2px solid var(--secondary-color);
    color: var(--secondary-color);
}

.btn-outline:hover {
    background: var(--secondary-color);
    color: white;
}

.book-description-section {
    margin-bottom: 2rem;
    padding: 2rem 0;
    border-top: 1px solid #eee;
}

.book-description-section h3 {
    color: var(--secondary-color);
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.book-description-full {
    font-size: 1.1rem;
    line-height: 1.6;
    color: var(--dark-color);
}

.book-impact-section {
    padding: 2rem 0;
    border-top: 1px solid #eee;
}

.book-impact-section h3 {
    color: var(--secondary-color);
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
}

.impact-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.impact-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-left: 4px solid var(--primary-color);
}

.impact-icon {
    font-size: 2.5rem;
    color: var(--primary-color);
}

.impact-value {
    font-size: 1.8rem;
    font-weight: bold;
    color: var(--secondary-color);
    margin-bottom: 0.25rem;
}

.impact-label {
    color: var(--dark-color);
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.impact-description {
    color: #666;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .book-detail-header {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .book-cover-large {
        width: 100%;
        max-width: 250px;
        height: 350px;
        margin: 0 auto;
    }

    .book-title-large {
        font-size: 2rem;
    }

    .book-actions-large {
        flex-direction: column;
        align-items: center;
    }

    .impact-cards {
        grid-template-columns: 1fr;
    }
}
</style>

<?php view_footer(); ?>