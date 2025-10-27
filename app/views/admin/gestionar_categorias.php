<?php view_header(['title' => $title ?? 'Biblioteca Verde UCV']); ?>
<div class="dashboard-header">
    <div class="container">
        <h1><i class="fas fa-tags"></i> Gestionar Categorías</h1>
        <p>Administra las categorías de libros del sistema</p>
    </div>
</div>

<div class="container">
    <div class="card mb-2">
        <div class="card-header">
            <h3><i class="fas fa-plus-circle"></i> Agregar Nueva Categoría</h3>
        </div>
        <div class="card-body">
            <form action="<?php echo URLROOT; ?>admin/agregarCategoria" method="post">
                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre de la Categoría *</label>
                        <input type="text" name="nombre" class="form-control" required
                            placeholder="Ej: Tecnología, Ciencias, etc.">
                    </div>
                    <div class="form-group">
                        <label for="color" class="form-label">Color *</label>
                        <input type="color" name="color" class="form-control" value="#3498db" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="icono" class="form-label">Icono *</label>
                    <select name="icono" class="form-control" required>
                        <option value="book">Libro</option>
                        <option value="leaf">Hoja</option>
                        <option value="laptop">Laptop</option>
                        <option value="flask">Matraz</option>
                        <option value="palette">Paleta</option>
                        <option value="book-open">Libro Abierto</option>
                        <option value="code">Código</option>
                        <option value="heart">Corazón</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3"
                        placeholder="Descripción de la categoría..."></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Categoría
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-list"></i> Lista de Categorías (<?php echo count($data['categorias']); ?>)</h3>
        </div>
        <div class="card-body">
            <?php if (empty($data['categorias'])) : ?>
            <div class="text-center p-4">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h4>No hay categorías registradas</h4>
                <p class="text-muted">Comienza agregando la primera categoría usando el formulario superior.</p>
            </div>
            <?php else : ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Color</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Icono</th>
                            <th>Total Libros</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['categorias'] as $categoria) : ?>
                        <tr>
                            <td>
                                <div
                                    style="width: 30px; height: 30px; background-color: <?php echo $categoria['color']; ?>; border-radius: 50%;">
                                </div>
                            </td>
                            <td>
                                <strong><?php echo $categoria['nombre']; ?></strong>
                            </td>
                            <td>
                                <?php echo $categoria['descripcion'] ?: 'Sin descripción'; ?>
                            </td>
                            <td>
                                <i class="fas fa-<?php echo $categoria['icono']; ?>"></i>
                            </td>
                            <td>
                                <?php if (($categoria['total_libros'] ?? 0) > 0): ?>
                                <span class="badge badge-warning" title="No se puede eliminar - tiene libros">
                                    <?php echo $categoria['total_libros']; ?> libros
                                </span>
                                <?php else: ?>
                                <span class="badge badge-success">
                                    <?php echo $categoria['total_libros'] ?? 0; ?> libros
                                </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-warning btn-sm"
                                        onclick="editarCategoria(<?php echo $categoria['id']; ?>)" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <?php if (($categoria['total_libros'] ?? 0) > 0): ?>
                                    <button class="btn btn-danger btn-sm" disabled
                                        title="No se puede eliminar - tiene libros asociados">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php else: ?>
                                    <a href="<?php echo URLROOT; ?>admin/eliminarCategoria/<?php echo $categoria['id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de eliminar esta categoría?')"
                                        title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <?php endif; ?>
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
function editarCategoria(id) {
    window.location.href = '<?php echo URLROOT; ?>admin/editarCategoria/' + id;
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

.badge {
    padding: 0.25rem 0.5rem;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-secondary {
    background: #6c757d;
    color: white;
}

.badge-warning {
    background: #ffc107;
    color: #212529;
}

.badge-success {
    background: #28a745;
    color: white;
}

.btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
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