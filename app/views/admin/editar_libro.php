<?php view_header(['title' => $title ?? 'Biblioteca Verde UCV']); ?>

<div class="dashboard-header">
    <div class="container">
        <h1><i class="fas fa-edit"></i> Editar Libro</h1>
        <p>Modifica la información del libro seleccionado</p>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-book"></i> Editar: <?php echo $data['libro']['titulo']; ?></h3>
        </div>
        <div class="card-body">
            <form action="<?php echo URLROOT; ?>libro/editar/<?php echo $data['libro']['id']; ?>" method="post">
                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="titulo" class="form-label">Título del Libro *</label>
                        <input type="text" name="titulo" class="form-control" required
                            value="<?php echo $data['libro']['titulo']; ?>" placeholder="Ingresa el título del libro">
                    </div>
                    <div class="form-group">
                        <label for="autor" class="form-label">Autor *</label>
                        <input type="text" name="autor" class="form-control" required
                            value="<?php echo $data['libro']['autor']; ?>" placeholder="Nombre del autor">
                    </div>
                </div>

                <div class="grid grid-3">
                    <div class="form-group">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" name="isbn" class="form-control"
                            value="<?php echo $data['libro']['isbn']; ?>" placeholder="ISBN del libro">
                    </div>
                    <div class="form-group">
                        <label for="id_categoria" class="form-label">Categoría *</label>
                        <select name="id_categoria" class="form-control" required>
                            <option value="">Selecciona una categoría</option>
                            <?php foreach ($data['categorias'] as $categoria) : ?>
                                <option value="<?php echo $categoria['id']; ?>"
                                    <?php echo $categoria['id'] == $data['libro']['id_categoria'] ? 'selected' : ''; ?>>
                                    <?php echo $categoria['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="estado" class="form-label">Estado *</label>
                        <select name="estado" class="form-control" required>
                            <option value="disponible"
                                <?php echo $data['libro']['estado'] == 'disponible' ? 'selected' : ''; ?>>Disponible
                            </option>
                            <option value="indisponible"
                                <?php echo $data['libro']['estado'] == 'indisponible' ? 'selected' : ''; ?>>Indisponible
                            </option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-3">
                    <div class="form-group">
                        <label for="fecha_publicacion" class="form-label">Año Publicación</label>
                        <input type="number" name="fecha_publicacion" class="form-control" min="1900"
                            max="<?php echo date('Y'); ?>" value="<?php echo $data['libro']['fecha_publicacion']; ?>"
                            placeholder="Ej: 2023">
                    </div>
                    <div class="form-group">
                        <label for="editorial" class="form-label">Editorial</label>
                        <input type="text" name="editorial" class="form-control"
                            value="<?php echo $data['libro']['editorial']; ?>" placeholder="Nombre de la editorial">
                    </div>
                    <div class="form-group">
                        <label for="paginas" class="form-label">Número de Páginas</label>
                        <input type="number" name="paginas" class="form-control" min="1"
                            value="<?php echo $data['libro']['paginas']; ?>" placeholder="Ej: 250">
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="4"
                        placeholder="Descripción detallada del libro..."><?php echo $data['libro']['descripcion']; ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Libro
                    </button>
                    <a href="<?php echo URLROOT; ?>libro/gestionar" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php view_footer(); ?>