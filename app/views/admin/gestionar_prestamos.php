<?php view_header(['title' => 'Gestionar Préstamos - Biblioteca Verde UCV']); ?>

<div class="dashboard-header">
    <div class="container">
        <h1><i class="fas fa-exchange-alt"></i> Gestionar Préstamos</h1>
        <p>Administra los préstamos de libros digitales</p>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-list"></i> Lista de Préstamos (<?php echo count($data['prestamos']); ?>)</h3>
        </div>
        <div class="card-body">
            <?php if (empty($data['prestamos'])) : ?>
                <div class="text-center p-4">
                    <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                    <h4>No hay préstamos registrados</h4>
                    <p class="text-muted">No se han realizado préstamos en el sistema.</p>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Libro</th>
                                <th>Fecha Préstamo</th>
                                <th>Fecha Límite</th>
                                <th>Fecha Devolución</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['prestamos'] as $prestamo) : ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $prestamo['usuario_nombre']; ?></strong>
                                        <br><small class="text-muted"><?php echo $prestamo['usuario_email']; ?></small>
                                    </td>
                                    <td>
                                        <strong><?php echo $prestamo['libro_titulo']; ?></strong>
                                        <br><small class="text-muted"><?php echo $prestamo['libro_autor']; ?></small>
                                        <?php if ($prestamo['categoria_nombre']) : ?>
                                            <br><span class="badge"
                                                style="background-color: <?php echo $prestamo['categoria_color']; ?>">
                                                <?php echo $prestamo['categoria_nombre']; ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small><?php echo date('d/m/Y', strtotime($prestamo['fecha_prestamo'])); ?></small>
                                    </td>
                                    <td>
                                        <small><?php echo date('d/m/Y', strtotime($prestamo['fecha_limite'])); ?></small>
                                    </td>
                                    <td>
                                        <?php if ($prestamo['fecha_devolucion']) : ?>
                                            <small><?php echo date('d/m/Y', strtotime($prestamo['fecha_devolucion'])); ?></small>
                                        <?php else : ?>
                                            <span class="text-muted">No devuelto</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $prestamo['estado']; ?>">
                                            <?php
                                            $estados = [
                                                'activo' => 'Activo',
                                                'devuelto' => 'Devuelto',
                                                'vencido' => 'Vencido'
                                            ];
                                            echo $estados[$prestamo['estado']] ?? $prestamo['estado'];
                                            ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <?php if ($prestamo['estado'] == 'activo') : ?>
                                                <a href="<?php echo URLROOT; ?>prestamo/administrarDevolucion/<?php echo $prestamo['id']; ?>"
                                                    class="btn btn-success btn-sm"
                                                    onclick="return confirm('¿Registrar devolución de este préstamo?')"
                                                    title="Registrar Devolución">
                                                    <i class="fas fa-check"></i>
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

    .status-activo {
        background: var(--success-color);
        color: white;
    }

    .status-devuelto {
        background: var(--info-color);
        color: white;
    }

    .status-vencido {
        background: var(--danger-color);
        color: white;
    }

    .badge {
        padding: 0.25rem 0.5rem;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
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