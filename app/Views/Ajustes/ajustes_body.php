<body class="<?= ($settings['default_theme'] ?? 'dark') === 'dark' ? 'theme-dark' : 'theme-ligth' ?>">
    
<!-- Sidebar para pantallas grandes (visible en lg y superior) -->
<div class="main-container">
    <div class="sidebar d-none d-lg-block">
           <h5 class="text-center text my-3">AdminProject</h5>
        <nav class="sidebar-nav mt-4">
            <!-- El enlace de Inicio apunta al dashboard -->
            <a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </div>

    <!-- Contenido Principal -->
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                <i class="fas fa-bars"></i>
            </button>
            <!-- Título de la página de Ajustes -->
            <h4 class="text-center py-3 m-0 flex-grow-1">
                AJUSTES DEL SISTEMA
            </h4>
        </div>

        <div class="main-panel">
            <!-- Cabecera con perfil de usuario (igual que en el dashboard) -->
            <div class="panel-header flex-column flex-md-row mb-4">
                <div class="flex-grow-1">
                    <!-- Espacio vacío donde iría el buscador, para mantener la alineación -->
                </div>
               
            </div>

            <!-- CONTENIDO ESPECÍFICO DE LA PÁGINA DE AJUSTES -->
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-12 col-md-6 col-lg-6"><a href="<?= site_url('/ajustes/masterdata') ?>" class="settings-card"><i class="icon fas fa-database"></i><span class="title">Master Data</span></a></div>
                    <div class="col-12 col-md-6 col-lg-6"><a href="<?= site_url('ajustes/generales') ?>" class="settings-card"><i class="icon fas fa-sliders-h"></i><span class="title">Configuración general</span></a></div>
                    <div class="col-12 col-md-6 col-lg-6"><a href="<?= site_url('ajustes/usuarios') ?>" class="settings-card"><i class="icon fas fa-users-cog"></i><span>Usuarios</span></a></div>
                    <div class="col-12 col-md-6 col-lg-6"><a href="<?= site_url('catalogos') ?>" class="settings-card"><i class="icon fas fa-folder"></i><span class="title">Catálogos</span></a></div>
                </div>
            </div>
            <!-- FIN DEL CONTENIDO ESPECÍFICO -->

        </div>
    </div>
</div>


<!-- Offcanvas Sidebar para pantallas pequeñas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">AdminProject</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="sidebar-nav">
            <a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> INICIO</a>
           <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </div>
</div>

<!-- JS (Solo se necesita el de Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>