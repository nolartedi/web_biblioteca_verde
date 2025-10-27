<?php view_header(['title' => $title ?? 'Biblioteca Verde UCV']); ?>

<div class="dashboard-header">
    <div class="container">
        <h1><i class="fas fa-book"></i> Gestionar Libros</h1>
        <p>Administra el catálogo completo de libros digitales</p>
    </div>
</div>

<div class="container">
    <div class="card mb-2">
        <div class="card-header">
            <h3><i class="fas fa-plus-circle"></i> Agregar Nuevo Libro</h3>
        </div>
        <div class="card-body">
            <form action="<?php echo URLROOT; ?>libro/agregar" method="post">
                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="titulo" class="form-label">Título del Libro *</label>
                        <input type="text" name="titulo" class="form-control" required
                            placeholder="Ingresa el título del libro">
                    </div>
                    <div class="form-group">
                        <label for="autor" class="form-label">Autor *</label>
                        <input type="text" name="autor" class="form-control" required placeholder="Nombre del autor">
                    </div>
                </div>

                <div class="grid grid-3">
                    <div class="form-group">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" name="isbn" class="form-control" placeholder="ISBN del libro">
                    </div>
                    <div class="form-group">
                        <label for="id_categoria" class="form-label">Categoría *</label>
                        <select name="id_categoria" class="form-control" required>
                            <option value="">Selecciona una categoría</option>
                            <?php foreach ($data['categorias'] as $categoria) : ?>
                            <option value="<?php echo $categoria['id']; ?>">
                                <?php echo $categoria['nombre']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="estado" class="form-label">Estado *</label>
                        <select name="estado" class="form-control" required>
                            <option value="disponible">Disponible</option>
                            <option value="indisponible">Indisponible</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_publicacion" class="form-label">Año Publicación</label>
                    <input type="number" name="fecha_publicacion" class="form-control" min="1900"
                        max="<?php echo date('Y'); ?>" placeholder="Ej: 2023">
                </div>

                <!-- MOVER ESTA SECCIÓN DENTRO DEL FORMULARIO -->
                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="editorial" class="form-label">Editorial</label>
                        <input type="text" name="editorial" class="form-control" placeholder="Nombre de la editorial">
                    </div>
                    <div class="form-group">
                        <label for="paginas" class="form-label">Número de Páginas</label>
                        <input type="number" name="paginas" class="form-control" min="1" placeholder="Ej: 250">
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="4"
                        placeholder="Descripción detallada del libro..."></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Libro
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-list"></i> Lista de Libros (<?php echo count($data['libros']); ?>)</h3>
        </div>
        <div class="card-body">
            <?php if (empty($data['libros'])) : ?>
            <div class="text-center p-4">
                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                <h4>No hay libros en el catálogo</h4>
                <p class="text-muted">Comienza agregando el primer libro usando el formulario superior.</p>
            </div>
            <?php else : ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Portada</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['libros'] as $libro) : ?>
                        <tr>
                            <td>
                                <?php if ($libro['portada']) : ?>
                                <img src="<?php echo URLROOT . 'uploads/' . $libro['portada']; ?>"
                                    alt="<?php echo $libro['titulo']; ?>"
                                    style="width: 50px; height: 70px; object-fit: cover; border-radius: 5px;">
                                <?php else : ?>
                                <div style="width: 50px; height: 70px; background: var(--accent-color); 
                                                      border-radius: 5px; display: flex; align-items: center; 
                                                      justify-content: center; color: white;">
                                    <i class="fas fa-book"></i>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo $libro['titulo']; ?></strong>
                                <?php if ($libro['isbn']) : ?>
                                <br><small class="text-muted">ISBN: <?php echo $libro['isbn']; ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $libro['autor']; ?></td>
                            <td>
                                <span class="badge" style="background-color: <?php echo $libro['categoria_color']; ?>">
                                    <?php echo $libro['categoria_nombre']; ?>
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo $libro['estado']; ?>">
                                    <?php
                                            $estados = [
                                                'disponible' => 'Disponible',
                                                'indisponible' => 'Indisponible'
                                            ];
                                            echo $estados[$libro['estado']];
                                            ?>
                                </span>
                            </td>
                            <td>
                                <small><?php echo date('d/m/Y', strtotime($libro['fecha_agregado'])); ?></small>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarLibro(<?php echo $libro['id']; ?>)" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="<?php echo URLROOT; ?>libro/eliminar/<?php echo $libro['id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de eliminar este libro?')"
                                        title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function editarLibro(id) {
    window.location.href = '<?php echo URLROOT; ?>libro/editar/' + id;
}
</script>

<style>
.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 5px;
    overflow: hidden;
}

.table th,
.table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.table th {
    background: var(--light-color);
    font-weight: 600;
    color: var(--secondary-color);
}

.table tbody tr:hover {
    background: #f8f9fa;
}

.action-buttons {
    display: flex;
    gap: 0.25rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-disponible {
    background: var(--success-color);
    color: white;
}

.status-indisponible {
    background: var(--warning-color);
    color: white;
}

@media (max-width: 768px) {
    .table {
        font-size: 0.8rem;
    }

    .table th,
    .table td {
        padding: 0.5rem;
    }

    .action-buttons {
        flex-direction: column;
    }
}
</style>

<?php view_footer(); ?>