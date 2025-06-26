<body class="<?= ($settings['default_theme'] ?? 'light') === 'dark' ? 'theme-dark' : 'theme-light' ?>">

<div class="main-container">
    <aside class="sidebar d-none d-lg-block">
        <h5 class="text-center text my-3">AdminProject</h5>
        <nav class="sidebar-nav mt-4">
            <a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </aside>

    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="<?= site_url('dashboard') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver al Dashboard</a>
            </div>
            <h4 class="text-center py-3 m-0">Detalles del Proyecto</h4>
            <div>
                </div>
        </div>

        <div class="main-panel">
            <div class="panel-header" style="border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">
                <h2><?= esc($proyecto['nombre']) ?></h2>
                <p class="text-muted mb-0"><?= esc($proyecto['descripcion']) ?></p>
            </div>

            <div class="row text-center mt-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <h6>Estado</h6>
                        <p class="fs-4 fw-bold text-success"><?= esc($proyecto['estado']) ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h6>Progreso</h6>
                        <?php $progreso = ($stats['total_tareas'] > 0) ? round(($stats['tareas_completadas'] / $stats['total_tareas']) * 100) : 0; ?>
                        <p class="fs-4 fw-bold text-info"><?= $progreso ?>%</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h6>Usuarios Asignados</h6>
                        <p class="fs-4 fw-bold"><?= count($usuarios_asignados) ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h6>Grupos Asignados</h6>
                        <p class="fs-4 fw-bold"><?= count($grupos_asignados) ?></p>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-lg-7">
                    <h5>Tareas Recientes</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">Diseñar la interfaz de usuario <span class="badge bg-primary">En Progreso</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Desarrollar el backend <span class="badge bg-success">Completada</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Realizar pruebas <span class="badge bg-warning text-dark">Pendiente</span></li>
                    </ul>
                </div>
                <div class="col-lg-5">
                    <h5>Equipo del Proyecto</h5>
                    <h6>Grupos:</h6>
                    <ul>
                        <?php foreach($grupos_asignados as $grupo): ?>
                            <li><?= esc($grupo) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <h6 class="mt-3">Usuarios:</h6>
                    <ul>
                        <?php foreach($usuarios_asignados as $usuario): ?>
                            <li><?= esc($usuario) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

</body>