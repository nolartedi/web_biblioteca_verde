<?php view_header(['title' => $title ?? 'Biblioteca Verde UCV']); ?>

<div class="dashboard-header m">
    <div class="container">
        <h1><i class="fas fa-book"></i> Catálogo de Libros</h1>
        <p>Explora nuestra colección de libros digitales</p>
    </div>
</div>

<div class="container">
    <div class="card mb-2">
        <div class="card-body">
            <div class="search-filters">
                <div class="grid grid-3">
                    <div class="form-group">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Buscar por título, autor..."
                            value="<?php echo $data['busqueda_actual'] ?? ''; ?>">
                    </div>
                    <div class="form-group">
                        <select id="categoryFilter" class="form-control">
                            <option value="">Todas las categorías</option>
                            <?php foreach ($data['categorias'] as $categoria) : ?>
                                <option value="<?php echo $categoria['id']; ?>"
                                    <?php echo ($data['categoria_actual'] == $categoria['id']) ? 'selected' : ''; ?>>
                                    <?php echo $categoria['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button id="searchButton" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>
                <i class="fas fa-books"></i>
                <?php if ($data['busqueda_actual']) : ?>
                    Resultados para "<?php echo $data['busqueda_actual']; ?>"
                <?php elseif ($data['categoria_actual']) : ?>
                    <?php
                    $categoria_nombre = '';
                    foreach ($data['categorias'] as $cat) {
                        if ($cat['id'] == $data['categoria_actual']) {
                            $categoria_nombre = $cat['nombre'];
                            break;
                        }
                    }
                    ?>
                    Categoría: <?php echo $categoria_nombre; ?>
                <?php else : ?>
                    Todos los Libros
                <?php endif; ?>
                <span class="badge badge-secondary"><?php echo count($data['libros']); ?> libros</span>
            </h3>
        </div>
        <div class="card-body">
            <?php if (empty($data['libros'])) : ?>
                <div class="text-center p-4">
                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                    <h4>No se encontraron libros</h4>
                    <p class="text-muted">Intenta con otros términos de búsqueda o categorías.</p>
                </div>
            <?php else : ?>
                <div class="grid grid-3">
                    <?php foreach ($data['libros'] as $libro) : ?>
                        <div class="book-card" data-category="<?php echo $libro['id_categoria']; ?>">
                            <div class="book-cover">
                                <?php if ($libro['portada']) : ?>
                                    <img src="<?php echo URLROOT . 'uploads/' . $libro['portada']; ?>"
                                        alt="<?php echo $libro['titulo']; ?>">
                                <?php else : ?>
                                    <div class="book-cover-placeholder">
                                        <i class="fas fa-book"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="book-status <?php echo $libro['estado']; ?>">
                                    <?php
                                    $estados = [
                                        'disponible' => 'Disponible',
                                        'indisponible' => 'Indisponible'
                                    ];
                                    echo $estados[$libro['estado']];
                                    ?>
                                </div>
                            </div>
                            <div class="book-info">
                                <h3 class="book-title"><?php echo $libro['titulo']; ?></h3>
                                <p class="book-author">
                                    <i class="fas fa-user"></i> <?php echo $libro['autor']; ?>
                                </p>
                                <p class="book-description">
                                    <?php echo strlen($libro['descripcion']) > 100 ?
                                        substr($libro['descripcion'], 0, 100) . '...' :
                                        $libro['descripcion']; ?>
                                </p>
                                <div class="book-meta">
                                    <span class="book-category"
                                        style="background-color: <?php echo $libro['categoria_color']; ?>">
                                        <i class="fas fa-tag"></i> <?php echo $libro['categoria_nombre']; ?>
                                    </span>
                                    <?php if ($libro['fecha_publicacion']) : ?>
                                        <span class="book-year">
                                            <i class="fas fa-calendar"></i> <?php echo $libro['fecha_publicacion']; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="book-actions">
                                    <a href="<?php echo URLROOT; ?>libro/detalle/<?php echo $libro['id']; ?>"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Ver Detalles
                                    </a>
                                    <?php if ($libro['estado'] == 'disponible') : ?>
                                        <a href="<?php echo URLROOT; ?>prestamo/solicitar/<?php echo $libro['id']; ?>"
                                            class="btn btn-success btn-sm"
                                            onclick="return confirm('¿Estás seguro de solicitar este libro?')">
                                            <i class="fas fa-hand-holding"></i> Solicitar
                                        </a>
                                    <?php else : ?>
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-clock"></i> No Disponible
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const searchButton = document.getElementById('searchButton');

        function performSearch() {
            const searchTerm = searchInput.value;
            const categoryId = categoryFilter.value;

            let url = '<?php echo URLROOT; ?>libro/catalogo?';
            if (searchTerm) {
                url += 'busqueda=' + encodeURIComponent(searchTerm);
            }
            if (categoryId) {
                url += (searchTerm ? '&' : '') + 'categoria=' + categoryId;
            }

            window.location.href = url;
        }

        searchButton.addEventListener('click', performSearch);

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    });
</script>

<style>
    .search-filters {
        margin-bottom: 0;
    }

    .book-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #eee;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .book-cover {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .book-cover-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }

    .book-status {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .book-status.disponible {
        background: var(--success-color);
        color: white;
    }

    .book-status.indisponible {
        background: var(--warning-color);
        color: white;
    }

    .book-info {
        padding: 1.5rem;
    }

    .book-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--secondary-color);
        line-height: 1.3;
    }

    .book-author {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .book-description {
        color: #777;
        font-size: 0.85rem;
        line-height: 1.4;
        margin-bottom: 1rem;
    }

    .book-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .book-category {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        color: white;
        font-weight: 500;
    }

    .book-year {
        font-size: 0.8rem;
        color: #666;
    }

    .book-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: space-between;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        flex: 1;
        text-align: center;
    }

    @media (max-width: 768px) {
        .grid-3 {
            grid-template-columns: 1fr;
        }

        .book-meta {
            flex-direction: column;
            align-items: flex-start;
        }

        .book-actions {
            flex-direction: column;
        }
    }
</style>

<?php view_footer(); ?>