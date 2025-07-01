<body class="<?= ($settings['default_theme'] ?? 'dark') === 'dark' ? 'theme-dark' : 'theme-light' ?>">

<div class="main-container">
    <div class="sidebar d-none d-lg-block">
          <h5 class="text-center text my-3">AdminProject</h5>
        <nav class="sidebar-nav mt-4">
            <a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> INICIO</a>
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
                    <img src="https://i.pravatar.cc/40?u=<?= esc($userData['id']) ?>" alt="User Avatar">
                    <div class="user-info">
                        <strong><?= esc($userData['nombre']) ?></strong><br>
                        <small><?= esc(ucfirst($userData['rol'])) ?></small>
                    </div>
                    <a href="<?= site_url('logout') ?>" title="Cerrar Sesión" class="ms-3 text-danger"><i class="fas fa-sign-out-alt fa-lg"></i></a>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between flex-wrap mb-4 w-100">
                <div class="actions-bar mb-2 mb-md-0 d-flex gap-2">
                    <a href="<?= site_url('dashboard/export_csv?anio=' . esc($selectedYear, 'url')) ?>" class="btn btn-secondary btn-custom"><i class="fas fa-download me-2"></i>Download CSV</a>
                    <!-- Los botones de exportación de DataTables se añadirán aquí -->
                    <?php if ($userData['rol'] === 'administrador'): ?>
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
                            <tr id="project-row-<?= esc($project['id_proyecto']) ?>">
                                <td><?= esc($project['id_proyecto']) ?></td>
                                <td><?= esc($project['nombre']) ?></td>
                                <td><span class="badge-priority badge-<?= strtolower(esc($project['prioridad'])) ?>"><?= esc($project['prioridad']) ?></span></td>
                                <td><?= esc($project['descripcion']) ?></td>
                                <td data-order='<?=$project["fecha_inicio"]?>'><?= date('d/m/Y', strtotime($project['fecha_inicio'])) ?></td>
                                <td data-order='<?=$project["fecha_fin"]?>'><?= date('d/m/Y', strtotime($project['fecha_fin'])) ?></td>
                                <td><span class="badge-priority badge-<?= strtolower(esc($project['status'])) ?>"><?= esc($project['status']) ?></span></td>
                                <td class="table-actions">
                                    <a href="<?= site_url('proyectos/detalles/' . $project['id_proyecto']) ?>" title="Ver Detalles"><i class="fas fa-list-alt"></i></a>
                                    <a href="<?= site_url('tareas') ?>" title="Añadir Tareas"><i class="fas fa-plus-circle"></i></a>
                                    <a href="<?= site_url('proyectos/' . $project['id_proyecto'] . '/gestion') ?>" title="Gestionar Usuarios"><i class="fas fa-user-plus"></i></a>
                                    
                                    <?php if ($userData['rol'] === 'administrador'): ?>
                                        <a href="#" class="ms-1" title="Editar Proyecto" 
                                           data-bs-toggle="modal" 
                                           data-bs-target="#editProjectModal"
                                           data-id="<?= esc($project['id_proyecto']) ?>">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
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

<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header"><h5 class="offcanvas-title" id="sidebarOffcanvasLabel">AdminProject</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
    <div class="offcanvas-body"><nav class="sidebar-nav"><a href="<?= site_url('dashboard') ?>" class="active"><i class="fas fa-home"></i> INICIO</a><a href="<?= site_url('ajustes') ?>"> <i class="fas fa-cog"></i> AJUSTES</a></nav></div>
</div>

<!-- INICIO DEL MODAL DE EDICIÓN -->
<div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProjectModalLabel">Editar Proyecto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProjectForm" onsubmit="return false;">
                    <!-- Campo oculto para guardar el ID -->
                    <input type="hidden" id="editProjectId">

                    <!-- Nombre del Proyecto -->
                    <div class="mb-3">
                        <label for="editProjectName" class="form-label">Nombre del Proyecto</label>
                        <input type="text" class="form-control" id="editProjectName" required>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label for="editProjectDescription" class="form-label">Descripción</label>
                        <textarea class="form-control" id="editProjectDescription" rows="3"></textarea>
                    </div>

                    <!-- Fila para Prioridad y Status -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editProjectPriority" class="form-label">Prioridad</label>
                            <select class="form-select" id="editProjectPriority">
                                <option value="Normal">Normal</option>
                                <option value="Media">Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editProjectStatus" class="form-label">Status</label>
                            <select class="form-select" id="editProjectStatus">
                                <option value="Activo">Activo</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Atrasado">Atrasado</option>
                            </select>
                        </div>
                    </div>

                    <!-- Fila para Fechas -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editProjectStartDate" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" id="editProjectStartDate">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editProjectEndDate" class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" id="editProjectEndDate">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN DEL MODAL -->

<!-- JS Assets -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    
 const table = $('#projectsTable').DataTable({
        "dom": 'Bt', "paging": true, "pageLength": 4, "language": { "emptyTable": "No hay proyectos para mostrar." }, "columnDefs": [ { "orderable": false, "targets": 7 } ],
        "buttons": [ { extend: 'collection', text: '<i class="fas fa-upload me-2"></i>Exportar', className: 'btn-secondary btn-custom', buttons: [ { extend: 'excelHtml5', text: '<i class="fas fa-file-excel me-2"></i>Excel', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] } }, { extend: 'pdfHtml5', text: '<i class="fas fa-file-pdf me-2"></i>PDF', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] } }, { extend: 'print', text: '<i class="fas fa-print me-2"></i>Imprimir', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] } } ] } ]
    });
    table.buttons().container().appendTo('.actions-bar');
    // Referencias a los elementos del DOM
    const editModalEl = document.getElementById('editProjectModal');
    const saveChangesBtn = document.getElementById('saveChangesBtn');
    
    // El array de proyectos que viene desde el controlador PHP
    let projectsData = <?= json_encode($proyectos ?? []) ?>;

    // --- 1. Llenar el formulario cuando se abre el modal ---
    editModalEl.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const projectId = button.getAttribute('data-id');
        const project = projectsData.find(p => p.id_proyecto == projectId);

        if (project) {
            // Llenar formulario
            document.getElementById('editProjectId').value = project.id_proyecto;
            document.getElementById('editProjectName').value = project.nombre;
            document.getElementById('editProjectDescription').value = project.descripcion;
            document.getElementById('editProjectPriority').value = project.prioridad;
            document.getElementById('editProjectStatus').value = project.status;
            document.getElementById('editProjectStartDate').value = project.fecha_inicio;
            document.getElementById('editProjectEndDate').value = project.fecha_fin;
        }
    });

    // --- 2. Guardar los cambios al hacer clic en el botón ---
    saveChangesBtn.addEventListener('click', function() {
        const projectId = document.getElementById('editProjectId').value;
        const formData = {
            id_proyecto: projectId,
            nombre: document.getElementById('editProjectName').value,
            descripcion: document.getElementById('editProjectDescription').value,
            prioridad: document.getElementById('editProjectPriority').value,
            status: document.getElementById('editProjectStatus').value,
            fecha_inicio: document.getElementById('editProjectStartDate').value,
            fecha_fin: document.getElementById('editProjectEndDate').value,
        };

        // Bloquear el botón para evitar clics duplicados
        saveChangesBtn.disabled = true;
        saveChangesBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Guardando...';

        // Enviar los datos al controlador que llama al Procedimiento Almacenado
        fetch('<?= site_url('proyectos/update') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                // Si el servidor devuelve un error, lo lanzamos para que lo capture el .catch()
                return response.json().then(err => { throw new Error(err.message || 'Error del servidor'); });
            }
            return response.json();
        })
        .then(data => {
            // Éxito: El servidor confirmó la actualización
            updateTableRow(formData);
            bootstrap.Modal.getInstance(editModalEl).hide();
            alert('¡Proyecto actualizado con éxito!');
        })
        .catch(error => {
            console.error('Error al actualizar:', error);
            alert(`Error: ${error.message}`);
        })
        .finally(() => {
            // Restaurar el botón en cualquier caso (éxito o error)
            saveChangesBtn.disabled = false;
            saveChangesBtn.innerHTML = 'Guardar Cambios';
        });
    });

    // --- 3. Función auxiliar para actualizar la fila de la tabla visualmente ---
    function updateTableRow(data) {
        const row = document.getElementById(`project-row-${data.id_proyecto}`);
        if (!row) return;

        // Actualizar datos del array en memoria para consistencia
        const projectIndex = projectsData.findIndex(p => p.id_proyecto == data.id_proyecto);
        if (projectIndex > -1) {
            projectsData[projectIndex] = { ...projectsData[projectIndex], ...data };
        }
        
        // Formatear fechas para la vista (DD/MM/YYYY)
        const formatDate = (dateString) => {
            if (!dateString) return '';
            // El + 'T00:00:00' evita problemas de zona horaria
            return new Date(dateString + 'T00:00:00').toLocaleDateString('es-ES');
        };

        // Actualizar las celdas de la fila
        row.cells[1].textContent = data.nombre;
        row.cells[2].innerHTML = `<span class="badge-priority badge-${data.prioridad.toLowerCase()}">${data.prioridad}</span>`;
        row.cells[3].textContent = data.descripcion;
        row.cells[4].textContent = formatDate(data.fecha_inicio);
        row.cells[5].textContent = formatDate(data.fecha_fin);
        row.cells[6].innerHTML = `<span class="badge-priority badge-${data.status.toLowerCase()}">${data.status}</span>`;
    }

    // (Aquí puedes tener otro código JS, como el del cambio de año del dropdown)
    const periodoSelect = document.getElementById('periodoSelect');
    if (periodoSelect) {
        periodoSelect.addEventListener('change', function() {
            window.location.href = '<?= site_url('dashboard') ?>?anio=' + this.value;
        });
    }
});
</script>
</body>