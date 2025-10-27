<?php view_header(['title' => 'Reporte de Huella de Carbono - Biblioteca Verde UCV']); ?>

<div class="dashboard-header">
    <div class="container">
        <h1><i class="fas fa-leaf"></i> Reporte de Huella de Carbono</h1>
        <p>Estadísticas de impacto ambiental positivo de la biblioteca digital</p>
    </div>
</div>

<div class="container">
    <!-- Resumen de Impacto -->
    <div class="grid grid-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-tree text-success"></i>
                </div>
                <p>Equivale a <?php echo number_format(($data['estadisticas']['total_ahorrado'] ?? 0) * 8.5, 0); ?> km
                    en automóvil</p>
                <p>CO₂ Ahorrado Total</p>
            </div>
        </div>

        <div class="card text-center">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-book text-primary"></i>
                </div>
                <h3><?php echo $data['estadisticas']['total_libros_digitales'] ?? 0; ?></h3>
                <p>Libros Digitales Prestados</p>
            </div>
        </div>

        <div class="card text-center">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-users text-info"></i>
                </div>
                <h3><?php echo $data['estadisticas']['total_usuarios_activos'] ?? 0; ?></h3>
                <p>Usuarios Participando</p>
            </div>
        </div>

        <div class="card text-center">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-recycle text-warning"></i>
                </div>
                <h3><?php echo number_format($data['estadisticas']['arboles_equivalentes'] ?? 0, 1); ?></h3>
                <p>Árboles Equivalente</p>
            </div>
        </div>
    </div>

    <!-- Gráfico de Ahorro Mensual -->
    <!-- Gráfico de Ahorro Mensual -->
    <div class="card mt-4">
        <div class="card-header">
            <h3><i class="fas fa-chart-line"></i> Evolución del Ahorro de CO₂</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($data['ahorro_mensual'])) : ?>
            <div class="chart-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Año</th>
                            <th>Libros Digitales</th>
                            <th>CO₂ Ahorrado (kg)</th>
                            <th>Equivalente en Árboles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $meses = [
                                1 => 'Enero',
                                2 => 'Febrero',
                                3 => 'Marzo',
                                4 => 'Abril',
                                5 => 'Mayo',
                                6 => 'Junio',
                                7 => 'Julio',
                                8 => 'Agosto',
                                9 => 'Septiembre',
                                10 => 'Octubre',
                                11 => 'Noviembre',
                                12 => 'Diciembre'
                            ];

                            foreach ($data['ahorro_mensual'] as $mes) :
                                $nombreMes = $meses[$mes['mes']] ?? 'Desconocido';
                                $anio = $mes['anio'] ?? 0;
                                $totalLibros = $mes['total_libros'] ?? 0;
                                $totalAhorrado = $mes['total_ahorrado'] ?? 0;
                                $arbolesEquivalentes = $totalAhorrado > 0 ? $totalAhorrado / 21.77 : 0;
                            ?>
                        <tr>
                            <td><?php echo $nombreMes; ?></td>
                            <td><?php echo $anio; ?></td>
                            <td><?php echo $totalLibros; ?></td>
                            <td class="text-success"><?php echo number_format($totalAhorrado, 2); ?> kg</td>
                            <td><?php echo number_format($arbolesEquivalentes, 2); ?> árboles</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else : ?>
            <div class="text-center p-4">
                <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                <h4>No hay datos suficientes</h4>
                <p class="text-muted">Aún no hay datos de ahorro mensual para mostrar.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Estadísticas Detalladas -->
    <div class="grid grid-2 mt-4">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-trophy"></i> Top Usuarios Más Ecológicos</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($data['top_usuarios'])) : ?>
                <div class="top-users">
                    <?php foreach ($data['top_usuarios'] as $index => $usuario) : ?>
                    <div class="user-rank-item">
                        <div class="rank-number">#<?php echo $index + 1; ?></div>
                        <div class="user-info">
                            <h5><?php echo $usuario['nombre']; ?></h5>
                        </div>
                        <div class="user-stats">
                            <span class="co2-saved"><?php echo number_format($usuario['co2_ahorrado'], 2); ?> kg
                                CO₂</span>
                            <span class="books-count"><?php echo $usuario['total_libros']; ?> libros</span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else : ?>
                <div class="text-center p-3">
                    <p class="text-muted">No hay datos de usuarios disponibles.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> Equivalencias Ambientales</h3>
            </div>
            <div class="card-body">
                <div class="equivalencias">
                    <div class="equivalencia-item">
                        <div class="equivalencia-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="equivalencia-content">
                            <h5>Kilómetros no recorridos</h5>
                            <p>Equivale a
                                <?php echo number_format(($data['estadisticas']['total_ahorrado'] ?? 0) * 8.5, 0); ?> km
                                en automóvil</p>
                        </div>
                    </div>

                    <div class="equivalencia-item">
                        <div class="equivalencia-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="equivalencia-content">
                            <h5>Energía eléctrica</h5>
                            <p>Equivale a
                                <?php echo number_format(($data['estadisticas']['total_ahorrado'] ?? 0) * 42, 0); ?>
                                horas de TV encendida</p>
                        </div>
                    </div>

                    <div class="equivalencia-item">
                        <div class="equivalencia-icon">
                            <i class="fas fa-tint"></i>
                        </div>
                        <div class="equivalencia-content">
                            <h5>Agua ahorrada</h5>
                            <p>Equivale a
                                <?php echo number_format(($data['estadisticas']['total_ahorrado'] ?? 0) * 240, 0); ?>
                                litros de agua</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen de Impacto -->
    <div class="card mt-4">
        <div class="card-header">
            <h3><i class="fas fa-globe-americas"></i> Impacto Ambiental Total</h3>
        </div>
        <div class="card-body">
            <div class="impact-summary">
                <p>La Biblioteca Verde UCV ha contribuido significativamente al medio ambiente mediante el uso de libros
                    digitales:</p>

                <div class="impact-stats">
                    <div class="impact-stat">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Se ha evitado la tala de aproximadamente
                            <strong><?php echo number_format(($data['estadisticas']['total_ahorrado'] ?? 0) / 21.77, 1); ?>
                                árboles</strong></span>
                    </div>
                    <div class="impact-stat">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Se ha ahorrado el equivalente a
                            <strong><?php echo number_format(($data['estadisticas']['total_ahorrado'] ?? 0) * 8.5, 0); ?>
                                km</strong> en automóvil</span>
                    </div>
                    <div class="impact-stat">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Se ha conservado aproximadamente
                            <strong><?php echo number_format(($data['estadisticas']['total_ahorrado'] ?? 0) * 240, 0); ?>
                                litros</strong> de agua</span>
                    </div>
                </div>

                <div class="eco-message">
                    <h5><i class="fas fa-seedling"></i> ¡Sigue contribuyendo!</h5>
                    <p>Cada libro digital que prestas ayuda a construir un futuro más sostenible para nuestro planeta.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chart-container {
    max-height: 400px;
    overflow-y: auto;
}

.top-users {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.user-rank-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 1px solid #eee;
    border-radius: 8px;
    background: #f8f9fa;
}

.rank-number {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-right: 1rem;
}

.user-info {
    flex: 1;
}

.user-info h5 {
    margin: 0 0 0.25rem 0;
}

.user-info p {
    margin: 0;
    font-size: 0.8rem;
}

.user-stats {
    text-align: right;
}

.co2-saved {
    display: block;
    font-weight: bold;
    color: var(--success-color);
}

.books-count {
    display: block;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.equivalencias {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.equivalencia-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 1px solid #e9ecef;
    border-radius: 8px;
}

.equivalencia-icon {
    width: 50px;
    height: 50px;
    background: var(--light-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.2rem;
    color: var(--primary-color);
}

.equivalencia-content h5 {
    margin: 0 0 0.25rem 0;
    color: var(--secondary-color);
}

.equivalencia-content p {
    margin: 0;
    color: var(--text-muted);
}

.impact-summary {
    line-height: 1.6;
}

.impact-stats {
    margin: 1.5rem 0;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.impact-stat {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.eco-message {
    margin-top: 2rem;
    padding: 1.5rem;
    background: #e8f5e8;
    border-radius: 8px;
    border-left: 4px solid var(--success-color);
}

.eco-message h5 {
    color: var(--success-color);
    margin-bottom: 0.5rem;
}

.eco-message p {
    margin: 0;
    color: #2d5016;
}

@media (max-width: 768px) {
    .grid.grid-4 {
        grid-template-columns: repeat(2, 1fr);
    }

    .user-rank-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .rank-number {
        margin-right: 0;
    }

    .user-stats {
        text-align: center;
    }
}
</style>

<?php view_footer(); ?>