<?php view_header(['title' => $title ?? 'Biblioteca Verde UCV']); ?>
<div class="dashboard-header">
    <div class="container">
        <h1><i class="fas fa-edit"></i> Editar Categoría</h1>
        <p>Modifica los datos de la categoría</p>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="<?php echo URLROOT; ?>admin/editarCategoria/<?php echo $data['categoria']['id']; ?>"
                method="post">
                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre de la Categoría *</label>
                        <input type="text" name="nombre" class="form-control"
                            value="<?php echo $data['categoria']['nombre']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="color" class="form-label">Color *</label>
                        <input type="color" name="color" class="form-control"
                            value="<?php echo $data['categoria']['color']; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="icono" class="form-label">Icono *</label>
                    <select name="icono" class="form-control" required>
                        <option value="book" <?php echo $data['categoria']['icono'] == 'book' ? 'selected' : ''; ?>>
                            Libro</option>
                        <option value="leaf" <?php echo $data['categoria']['icono'] == 'leaf' ? 'selected' : ''; ?>>Hoja
                        </option>
                        <option value="laptop" <?php echo $data['categoria']['icono'] == 'laptop' ? 'selected' : ''; ?>>
                            Laptop</option>
                        <option value="flask" <?php echo $data['categoria']['icono'] == 'flask' ? 'selected' : ''; ?>>
                            Matraz</option>
                        <option value="palette"
                            <?php echo $data['categoria']['icono'] == 'palette' ? 'selected' : ''; ?>>Paleta</option>
                        <option value="book-open"
                            <?php echo $data['categoria']['icono'] == 'book-open' ? 'selected' : ''; ?>>Libro Abierto
                        </option>
                        <option value="code" <?php echo $data['categoria']['icono'] == 'code' ? 'selected' : ''; ?>>
                            Código</option>
                        <option value="heart" <?php echo $data['categoria']['icono'] == 'heart' ? 'selected' : ''; ?>>
                            Corazón</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3"
                        placeholder="Descripción de la categoría..."><?php echo $data['categoria']['descripcion']; ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="<?php echo URLROOT; ?>admin/gestionarCategorias" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php view_footer(); ?>