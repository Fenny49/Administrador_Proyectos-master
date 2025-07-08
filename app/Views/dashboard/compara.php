<body class="<?= ($settings['default_theme'] ?? 'dark') === 'dark' ? 'theme-dark' : 'theme-light' ?>">

<!-- ... (Sidebar y Offcanvas se quedan igual) ... -->
<div class="main-container">
    <div class="sidebar d-none d-lg-block">
        <h5 class="text-center text my-3">AdminProject</h5>
        <nav class="sidebar-nav mt-4">
            <a href="<?= site_url('dashboard') ?>" class="active"><i class="fas fa-home"></i> INICIO</a>
         
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </div>

    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas"><i class="fas fa-bars"></i></button>
            <h4 class="text-center py-3 m-0 flex-grow-1"><?= ($userData['rol'] === 'administrador') ? 'PANEL DE ADMINISTRADOR' : 'MIS PROYECTOS' ?></h4>
        </div>

        <div class="main-panel">
            <div class="panel-header flex-column flex-md-row mb-4">
                <div class="input-group w-100 w-md-auto mb-3 mb-md-0">
                    <input type="text" id="customSearchInput" class="form-control search-bar" placeholder="Buscar proyecto">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
                </div>
                <div class="user-profile">
                    <br>
                    <img src="https://i.pravatar.cc/40?u=<?= esc($userData['id']) ?>" alt="User Avatar">
                    <div class="user-info">
                        <strong><?= esc($userData['nombre']) ?></strong><br>
                        <small><?= esc(ucfirst($userData['rol'])) ?></small>
                    </div>
                    <a href="<?= site_url('logout') ?>" title="Cerrar Sesión" class="ms-3 text-danger"><i class="fas fa-sign-out-alt fa-lg"></i></a>
                </div>
            </div>

            <!-- CAMBIO 2: Ajustamos el contenedor de la barra de acciones para que siempre sea una fila -->
            <div class="d-flex align-items-center justify-content-between flex-wrap mb-4 w-100">
                <div class="actions-bar mb-2 mb-md-0">
                    <button class="btn btn-secondary btn-custom" onclick="alert('Simulando descarga...')"><i class="fas fa-download me-2"></i>Download CSV</button>
                    <?php if ($userData['rol'] === 'administrador'): ?>
                        <button class="btn btn-secondary btn-custom" onclick="alert('Simulando exportación...')"><i class="fas fa-upload me-2"></i>Export</button>
                        <button class="btn btn-secondary btn-custom" onclick="alert('Simulando importación...')"><i class="fas fa-download me-2"></i>Import</button>
                                  <a href="<?= base_url('/proyectos/nuevo') ?>" class="btn btn-add btn-custom"><i class="fas fa-plus me-2"></i>Añadir Proyecto</a>
                    <?php endif; ?>
                </div>
                <div class="d-flex align-items-center">
                    <label for="periodoSelect" class="form-label me-2 mb-0"><strong>Periodo:</strong></label>
                    <select class="form-select" id="periodoSelect" style="width: 120px; background-color: var(--panel-light-bg); color: var(--text-light); border-color: #555;">
                        <?php for ($i = date('Y'); $i >= 2020; $i--): ?>
                            <option value="<?= $i ?>" <?= ($i == $selectedYear) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            
            <h5 class="mb-3"><?= ($userData['rol'] === 'administrador') ? 'Todos los Proyectos' : 'Proyectos Asignados' ?></h5>
            <div class="table-responsive">
                <table id="projectsTable" class="table project-table">
                    <thead>
                        <tr>
                            <th>No.</th><th>Nombre</th><th>Prioridad</th><th>Descripción</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Status</th><th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proyectos as $project): ?>
                            <tr>
                                <td><?= esc($project['id_proyecto']) ?></td>
                                <td><?= esc($project['nombre']) ?></td>
                                <td><span class="badge-priority badge-<?= strtolower(esc($project['prioridad'])) ?>"><?= esc($project['prioridad']) ?></span></td>
                                <td><?= esc($project['descripcion']) ?></td>
                                <td data-order='<?=$project["fecha_inicio"]?>'><?= date('d/m/Y', strtotime($project['fecha_inicio'])) ?></td>
                                <td data-order='<?=$project["fecha_fin"]?>'><?= date('d/m/Y', strtotime($project['fecha_fin'])) ?></td>
                                <td><span class="badge-priority badge-<?= strtolower(esc($project['status'])) ?>"><?= esc($project['status']) ?></span></td>
                                <td class="table-actions">
                                <!-- Sección de acciones-->
                                 <!-- Ver detalles de proyecto-->
                                <a href="<?= site_url('proyectos/detalles/' . $project['id_proyecto']) ?>"title="Ver Detalles"><i class="fas fa-list-alt"></i></a>
                                
                                <!-- Añadir Tareas -->
                                <a href="#" onclick="alert('Añadiendo tareas al proyecto <?= $project['id_proyecto'] ?>')" title="Añadir Tareas">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                                
                                <!-- Añadir Usuarios -->
                                <a href="<?= site_url('proyectos/' . $project['id_proyecto'] . '/gestion') ?>" title="Gestionar Usuarios y Grupos del Proyecto">
                                    <i class="fas fa-user-plus"></i>
                                </a>
                                
                                <!-- Editar proyecto (solo administradores) -->
                                <?php if ($userData['rol'] === 'administrador'): ?>
                                    <a href="#" onclick="..." title="Editar Proyecto"><i class="fas fa-pencil-alt"></i></a>
                                <?php endif; ?>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <nav id="customPaginationContainer"><ul class="pagination"></ul></nav>
        </div>
    </div>
</div>

<!-- ... (Offcanvas se queda igual) ... -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header"><h5 class="offcanvas-title" id="sidebarOffcanvasLabel">AdminProject</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
    <div class="offcanvas-body"><nav class="sidebar-nav"><a href="<?= site_url('dashboard') ?>" class="active"><i class="fas fa-home"></i> INICIO</a><a href="#"><i class="fas fa-star"></i> RECURSOS</a><a href="#"><i class="fas fa-tasks"></i> TAREAS</a><a href="#"><i class="fas fa-calendar-alt"></i> CALENDARIO</a><a href="<?= site_url('settings') ?>"><i class="fas fa-cog"></i> AJUSTES</a></nav></div>
</div>


<!-- JS Assets -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // El JavaScript no necesita cambios, ya que las modificaciones son de CSS y HTML.
    // Se pega el mismo script de la respuesta anterior.
    document.addEventListener('DOMContentLoaded', function () {
        const table = $('#projectsTable').DataTable({
            "dom": 't', "paging": true, "pageLength": 4, "language": { "emptyTable": "No hay proyectos para mostrar." }, "columnDefs": [{ "orderable": false, "targets": 7 }]
        });
        $('#customSearchInput').on('keyup', function () { table.search(this.value).draw(); });
        function renderCustomPagination() {
            const paginationContainer = $('#customPaginationContainer .pagination'); paginationContainer.empty();
            const info = table.page.info(); const totalPages = info.pages; const currentPage = info.page;
            if (totalPages <= 1) return;
            paginationContainer.append(`<li class="page-item ${currentPage === 0 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="previous">‹</a></li>`);
            for (let i = 0; i < totalPages; i++) { paginationContainer.append(`<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i + 1}</a></li>`); }
            paginationContainer.append(`<li class="page-item ${currentPage === totalPages - 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="next">›</a></li>`);
        }
        $('#customPaginationContainer').on('click', 'a', function(e) {
            e.preventDefault(); const page = $(this).data('page');
            if (page === 'previous') { table.page('previous').draw('page'); } else if (page === 'next') { table.page('next').draw('page'); } else { table.page(parseInt(page)).draw('page'); }
        });
        table.on('draw', renderCustomPagination);
        renderCustomPagination();
        $('#periodoSelect').on('change', function() { window.location.href = '<?= site_url('dashboard') ?>?anio=' + this.value; });
    });
</script>
</body>