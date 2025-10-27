<?php view_header(['title' => $title ?? 'Biblioteca Verde UCV']); ?>

<section class="hero">
    <div class="container">
        <h1>Biblioteca Verde UCV</h1>
        <p class="hero-description">
            Accede a una amplia colección de libros digitales, reduce tu huella de carbono
            y contribuye al medio ambiente mediante préstamos sostenibles.
        </p>

        <?php if (!isset($_SESSION['user_id'])) : ?>
        <div class="hero-actions">
            <a href="<?php echo URLROOT; ?>auth/register" class="btn btn-primary btn-large">
                <i class="fas fa-user-plus"></i> Comenzar Ahora
            </a>
            <a href="<?php echo URLROOT; ?>auth/login" class="btn btn-secondary btn-large">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>
        </div>
        <?php else : ?>
        <div class="hero-actions">
            <a href="<?php echo URLROOT; ?>libro/catalogo" class="btn btn-primary btn-large">
                <i class="fas fa-book"></i> Explorar Catálogo
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="features">
    <div class="container">
        <h2 class="section-title">¿Por qué elegirnos?</h2>
        <div class="grid grid-3">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3>Sostenibilidad</h3>
                <p>Reduce tu huella de carbono con préstamos digitales. Cada libro digital ahorra 2.5kg de CO2.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-laptop"></i>
                </div>
                <h3>Acceso ilimitado</h3>
                <p>Disponible 24/7 desde cualquier dispositivo. Tu biblioteca siempre contigo.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <h3>Asistente IA</h3>
                <p>Nuestro chatbot inteligente te ayuda a encontrar lo que necesitas rápidamente.</p>
            </div>
        </div>
    </div>
</section>

<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $data['total_libros']; ?></div>
                <div class="stat-label">Libros digitales</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">1000+</div>
                <div class="stat-label">Estudiantes activos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">2.5kg</div>
                <div class="stat-label">CO2 Ahorrado por préstamo</div>
            </div>
        </div>
    </div>
</section>

<section class="featured-books">
    <div class="container">
        <h2 class="section-title">Libros destacados</h2>
        <div class="books-grid">
            <?php foreach ($data['libros_destacados'] as $libro) : ?>
            <div class="book-card">
                <div class="book-cover-placeholder">
                    <i class="fas fa-book"></i>
                </div>
                <div class="book-info">
                    <h3 class="book-title"><?php echo $libro['titulo']; ?></h3>
                    <p class="book-author"><?php echo $libro['autor']; ?></p>

                    <div class="book-footer">
                        <span class="book-category" style="background-color: <?php echo $libro['categoria_color']; ?>">
                            <?php echo $libro['categoria_nombre']; ?>
                        </span>
                        <?php if (isset($_SESSION['user_id'])) : ?>
                        <a href="<?php echo URLROOT; ?>libro/detalle/<?php echo $libro['id']; ?>"
                            class="btn btn-primary">
                            Ver Detalles
                        </a>
                        <?php else : ?>
                        <a href="<?php echo URLROOT; ?>auth/login" class="btn btn-secondary btn-small">
                            Iniciar Sesión para Acceder
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.hero {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 1rem 0;
    text-align: center;
}

.hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.hero-description {
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto 2rem;
    opacity: 0.8;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-large {
    padding: 0.75rem 2rem;
    font-size: 1rem;
}

.features {
    padding: 2rem 0;
    background: var(--light-color);
}

.section-title {
    text-align: center;
    margin-bottom: 3rem;
    font-size: 2rem;
    color: var(--secondary-color);
}

.feature-card {
    background: white;
    padding: 1rem;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.feature-icon {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.feature-card h3 {
    margin-bottom: 1rem;
    color: var(--secondary-color);
}

.stats-section {
    padding: 1.5rem 0;
}

.featured-books {
    padding: 2rem 0;
    background: var(--light-color);
}

/* Grid para libros destacados - 3 por fila en desktop */
.books-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.book-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.book-card:hover {
    transform: translateY(-5px);
}

.book-cover-placeholder {
    width: 100%;
    height: 200px;
    background: var(--accent-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 3rem;
}

.book-info {
    padding: 1.5rem;
}

.book-title {
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
    color: var(--secondary-color);
}

.book-author {
    color: #666;
    margin-bottom: 1rem;
}

.book-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.book-category {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    color: white;
    font-size: 0.8rem;
    font-weight: bold;
}

.btn-small {
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
}

/* Responsive para pantallas pequeñas */
@media (max-width: 768px) {
    .hero h1 {
        font-size: 2rem;
    }

    .features,
    .featured-books {
        padding: 0.75rem 0;
    }

    /* En móvil, una columna */
    .books-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .book-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
    }

    .book-footer .btn {
        text-align: center;
    }
}

/* Para tablets medianas */
@media (max-width: 1024px) and (min-width: 769px) {
    .books-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
}
</style>

<?php view_footer(); ?>