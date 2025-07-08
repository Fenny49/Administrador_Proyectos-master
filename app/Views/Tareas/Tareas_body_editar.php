<body class="<?= ($settings['default_theme'] ?? 'dark') === 'dark' ? 'theme-dark' : 'theme-ligth' ?>">


<!-- CSS de DataTables y Modal -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    
    /* Estilos Esenciales para el Modal de Bootstrap 5.3 */
    .modal{position:fixed;top:0;left:0;z-index:1055;display:none;width:100%;height:100%;overflow-x:hidden;overflow-y:auto;outline:0}.modal-dialog{position:relative;width:auto;margin:.5rem;pointer-events:none}.modal.fade .modal-dialog{transition:transform .3s ease-out;transform:translate(0,-50px)}.modal.show .modal-dialog{transform:none}@media (min-width:576px){.modal-dialog{max-width:500px;margin:1.75rem auto}}.modal-content{position:relative;display:flex;flex-direction:column;width:100%;color:var(--bs-modal-color);pointer-events:auto;background-color:var(--bs-modal-bg,#fff);background-clip:padding-box;border:1px solid var(--bs-modal-border-color,rgba(0,0,0,.2));border-radius:.5rem;outline:0}.modal-backdrop{position:fixed;top:0;left:0;z-index:1050;width:100vw;height:100vh;background-color:#000}.modal-backdrop.fade{opacity:0}.modal-backdrop.show{opacity:.5}.modal-header{display:flex;flex-shrink:0;align-items:center;justify-content:space-between;padding:1rem 1rem;border-bottom:1px solid var(--bs-modal-header-border-color,#dee2e6);border-top-left-radius:calc(.5rem - 1px);border-top-right-radius:calc(.5rem - 1px)}.modal-title{margin-bottom:0;line-height:1.5}.modal-body{position:relative;flex:1 1 auto;padding:1rem}.modal-footer{display:flex;flex-wrap:wrap;flex-shrink:0;align-items:center;justify-content:flex-end;padding:.75rem;border-top:1px solid var(--bs-modal-footer-border-color,#dee2e6);border-bottom-right-radius:calc(.5rem - 1px);border-bottom-left-radius:calc(.5rem - 1px)}.modal-footer>*{margin:.25rem}.fade{transition:opacity .15s linear}.fade:not(.show){opacity:0}.btn-close{box-sizing:content-box;width:1em;height:1em;padding:.25em .25em;color:#000;background:transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;border:0;border-radius:.375rem;opacity:.5}.btn-close:hover{opacity:.75}.btn-close:focus{outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25);opacity:1}
</style>

<div class="main-container">
    <!-- BARRA LATERAL (Sidebar) -->
    <div class="sidebar d-none d-lg-block">
        <h5 class="sidebar-header text-center my-3">AdminProject</h5>
        <nav class="sidebar-nav mt-4">
            <a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('tareas/listar/' . $id_proyecto) ?>">
                <i class="fas fa-tasks"></i> Ir a la lista
            </a>
            <a href="#" class="active">
                <i class="fas fa-tasks"></i> Gestión de Tareas
            </a>
        </nav>
    </div>

    <!-- ENVOLTORIO PRINCIPAL DEL CONTENIDO -->
    <div class="content-wrapper">
        <div class="main-panel">
            
            <!-- Encabezado de la página -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0" id="titulo-pagina">
                        <?= ($modo === 'editar') ? 'Editar Tarea' : 'Crear Tarea' ?>
                    </h1>
                    <small class="fs-5 fw-bold text-primary">
                        <?= esc($proyecto['nombre'] ?? 'Proyecto Desconocido') ?>
                    </small>
                </div>
                <span id="estado-guardado" class="text-success fw-bold" style="transition: opacity 0.5s;"></span>
            </div>
            
            <!-- FORMULARIO PRINCIPAL -->
            <form id="form-tarea" onsubmit="return false;">
                <!-- CAMPOS OCULTOS ESENCIALES -->
                <input type="hidden" name="tarea_id" id="tarea_id" value="<?= esc($tarea['TAR_ID'] ?? '') ?>">
                <input type="hidden" name="proy_id" value="<?= esc($id_proyecto) ?>">
                <input type="hidden" name="stat_id" value="<?= esc($tarea['STAT_ID'] ?? '1') ?>">
                <input type="hidden" name="prio_id" value="<?= esc($tarea['PRIO_ID'] ?? '2') ?>">
                <input type="hidden" name="gpo_id" value="<?= esc($tarea['GPO_ID'] ?? '3') ?>">
            
                <div class="row">
                    <!-- Columna Izquierda: Información de la Tarea -->
                    <div class="col-lg-8 mb-4">
                        <div class="data-panel h-100 p-4" data-panel="info"> 
                            <h6 class="mb-3 fw-bold text-primary">1. Información de la Tarea</h6>
                            <div class="mb-3">
                                <label for="tar_nom" class="form-label">Nombre de la Tarea / Historia</label>
                                <input type="text" name="tar_nom" class="form-control" id="tar_nom" placeholder="Ej: Como usuario, quiero poder..." value="<?= esc($tarea['TAR_NOM'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="tar_desc" class="form-label">Descripción Detallada</label>
                                <textarea class="form-control" name="tar_desc" id="tar_desc" rows="5" placeholder="Describe los criterios de aceptación y detalles funcionales."><?= esc($tarea['TAR_DESC'] ?? '') ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="stat_id_select" class="form-label">Estado de la Tarea</label>
                                    <select class="form-select" name="stat_id" id="stat_id_select">
                                        <?php foreach ($listaEstatus as $estatus): ?>
                                            <option value="<?= esc($estatus['STAT_ID']) ?>"
                                                    <?= (isset($tarea['STAT_ID']) && $tarea['STAT_ID'] == $estatus['STAT_ID']) ? 'selected' : '' ?>>
                                                <?= esc($estatus['STAT_NOM']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tar_fechafin" class="form-label">Fecha de Finalización (Opcional)</label>
                                    <input type="date" class="form-control" name="tar_fechafin" id="tar_fechafin" 
                                           value="<?= esc($tarea['TAR_FECHAFIN'] ?? '') ?>">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="solicitado_por_usuario_id" class="form-label">Solicitado por</label>
                                    <select class="form-select" name="solicitado_por_usuario_id" id="solicitado_por_usuario_id" required>
                                        <option value="" disabled>-- Seleccione un usuario --</option>
                                        <?php if (!empty($listaUsuarios)): ?>
                                            <?php foreach ($listaUsuarios as $usuario): ?>
                                                <option value="<?= esc($usuario['Id_usuario']) ?>" 
                                                        <?= (isset($tarea['solicitado_por_usuario_id']) && $tarea['solicitado_por_usuario_id'] == $usuario['Id_usuario']) ? 'selected' : '' ?>>
                                                    <?= esc($usuario['NombreCompleto']) ?> (<?= esc(ucfirst($usuario['Rol'])) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha: Agregar Criterios -->
                    <div class="col-lg-4 mb-4">
                        <div class="data-panel h-100 p-4" data-panel="agregar">
                            <h6 class="mb-3 fw-bold text-primary">2. Agregar Criterios</h6>
                            <div class="mb-3">
                                <label for="criterio_desc" class="form-label">Descripción del Criterio</label>
                                <textarea class="form-control" id="criterio_desc" rows="4" placeholder="Ej: El botón debe ser azul."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="criterio_puntos" class="form-label">Puntos de Esfuerzo</label>
                                <select class="form-select" id="criterio_puntos">
                                    <option value="" selected disabled>-- Seleccionar puntos --</option>
                                    <?php foreach ($puntosScrum as $puntos): ?>
                                        <option value="<?= $puntos ?>"><?= $puntos ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción globales -->
                <div class="d-flex justify-content-end gap-2 mb-4">
                    <button type="button" id="btn-cancelar-edicion" class="btn btn-secondary" style="display: none;">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="button" id="btn-agregar-criterio" class="btn btn-info text-white">
                        <i class="fas fa-save me-2"></i>
                        <span id="btn-texto-agregar">Guardar Tarea y Agregar Criterio</span>
                    </button>
                </div>

                <!-- Lista de Criterios Agregados -->
                <div class="data-panel mt-2 p-4" data-panel="lista">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="m-0 fw-bold text-primary">3. Lista de Criterios Agregados</h6>
                        <span class="badge bg-primary rounded-pill" id="contador-criterios">0</span>
                    </div>
                    <div class="table-responsive">
                        <table id="tabla-criterios" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">Cumplido</th>
                                    <th>Descripción</th>
                                    <th style="width: 120px;" class="text-right">Puntos</th>
                                    <th style="width: 150px;">Fecha Creación</th>
                                    <th style="width: 100px;" class="text-center no-sort">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($criteriosExistentes)): ?>
                                    <?php foreach ($criteriosExistentes as $criterio): ?>
                                        <tr data-criterio-id="<?= esc($criterio['CRITERIO_ID']) ?>">
                                            <td class="text-center align-middle">
                                                <input class="form-check-input criterio-cumplido-check" type="checkbox" 
                                                       data-criterio-id="<?= esc($criterio['CRITERIO_ID']) ?>"
                                                       <?= $criterio['CUMPLIDO'] ? 'checked' : '' ?>>
                                            </td>
                                            <td class="align-middle"><?= esc($criterio['CRITERIO_DESCRIPCION']) ?></td>
                                            <td class="text-center align-middle"><?= esc($criterio['PUNTOS_ESTIMADOS']) ?></td>
                                            <td class="align-middle">
                                                <?= esc(date('d/m/Y H:i', strtotime($criterio['FECHA_CREACION']))) ?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-sm btn-warning btn-editar-criterio" title="Editar Criterio"><i class="fas fa-pencil-alt"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm btn-eliminar-criterio" title="Eliminar Criterio"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                                      <a href="<?= site_url('dashboard') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver al Dashboard</a>

            </form>
        </div>
    </div>
    
</div>

<!-- Modal para la edición de criterios -->
<div class="modal fade" id="modal-editar-criterio" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Editar Criterio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-editar-criterio">
                    <input type="hidden" id="edit-criterio-id">
                    <div class="mb-3">
                        <label for="edit-criterio-desc" class="form-label">Descripción</label>
                        <textarea class="form-control" id="edit-criterio-desc" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-criterio-puntos" class="form-label">Puntos de Esfuerzo</label>
                        <select class="form-select" id="edit-criterio-puntos" required>
                            <option value="" disabled>-- Seleccionar --</option>
                            <?php foreach ($puntosScrum as $puntos): ?>
                                <option value="<?= $puntos ?>"><?= $puntos ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn-guardar-cambios-criterio">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>


<style>
    .panel-locked { opacity: 0.5; pointer-events: none; transition: opacity 0.3s ease; }
    .criterio-cumplido-check { transform: scale(1.5); cursor: pointer; }
</style>

<!-- JS de jQuery, Bootstrap y DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    const BASE_URL = "<?= site_url() ?>";
    
    document.addEventListener('DOMContentLoaded', function() {
        const modo = '<?= $modo ?>';
        let tareaId = document.getElementById('tarea_id').value || null;

        // --- REFERENCIAS A ELEMENTOS DEL DOM ---
        const btnAgregarCriterio = document.getElementById('btn-agregar-criterio');
        const btnCancelarEdicion = document.getElementById('btn-cancelar-edicion');
        const estadoGuardado = document.getElementById('estado-guardado');
        const btnTextoAgregar = document.getElementById('btn-texto-agregar');
        const contadorCriteriosBadge = document.getElementById('contador-criterios');
        const criterioDescInput = document.getElementById('criterio_desc');
        const criterioPuntosInput = document.getElementById('criterio_puntos');
        const allPanels = document.querySelectorAll('.data-panel');
        
        const editModal = new bootstrap.Modal(document.getElementById('modal-editar-criterio'));
        let activeEditingRow = null;

        // --- Inicialización de DataTables ---
        let criteriosTable = $('#tabla-criterios').DataTable({
            "paging": false,
            "info": false,
            "searching": false,
            "language": { "emptyTable": "Aún no se han agregado criterios a esta tarea." },
            "columnDefs": [
                { "orderable": false, "targets": [0, 4] }
            ],
            "order": [[ 3, "desc" ]]
        });

        // --- LÓGICA DE BLOQUEO/DESBLOQUEO PERSISTENTE ---
        function setPanelFocus(focusedPanel) {
            allPanels.forEach(panel => {
                if (panel !== focusedPanel) {
                    panel.classList.add('panel-locked');
                } else {
                    panel.classList.remove('panel-locked');
                }
            });
            btnCancelarEdicion.style.display = 'inline-block';
        }

        function unlockAllPanelsAndReset() {
            allPanels.forEach(panel => panel.classList.remove('panel-locked'));
            btnCancelarEdicion.style.display = 'none';
            criterioDescInput.value = '';
            criterioPuntosInput.value = '';
        }

        allPanels.forEach(panel => {
            panel.addEventListener('focusin', () => setPanelFocus(panel));
        });

        btnCancelarEdicion.addEventListener('click', unlockAllPanelsAndReset);

        // --- FUNCIONES AUXILIARES ---
        const actualizarUIContador = () => {
            const numeroDeFilas = criteriosTable.rows().count();
            contadorCriteriosBadge.textContent = numeroDeFilas;
        };

        const mostrarEstado = (mensaje, tipo = 'success') => {
            estadoGuardado.textContent = mensaje;
            estadoGuardado.className = `text-${tipo} fw-bold`;
            estadoGuardado.style.opacity = '1';
            setTimeout(() => { 
                estadoGuardado.style.opacity = '0';
                setTimeout(() => { estadoGuardado.textContent = ''; }, 500);
            }, 3000);
        };
        
        const agregarFilaCriterio = (descripcion, puntos, criterioId) => {
            const checkboxHtml = `<input class="form-check-input criterio-cumplido-check" type="checkbox" data-criterio-id="${criterioId}">`;
            const accionesHtml = `<button type="button" class="btn btn-sm btn-warning btn-editar-criterio" title="Editar Criterio"><i class="fas fa-pencil-alt"></i></button> <button type="button" class="btn btn-danger btn-sm btn-eliminar-criterio" title="Eliminar Criterio"><i class="fas fa-trash"></i></button>`;
            
            const nuevaFila = criteriosTable.row.add([
                checkboxHtml,
                descripcion,
                puntos,
                'Recién creado',
                accionesHtml
            ]).draw(false).node();

            $(nuevaFila).attr('data-criterio-id', criterioId);
            actualizarUIContador();
        };
        
        const actualizarUiModoEdicion = (idTarea) => {
            tareaId = idTarea;
            document.getElementById('tarea_id').value = idTarea;
            document.getElementById('titulo-pagina').textContent = 'Editar Tarea';
            btnTextoAgregar.textContent = 'Guardar Cambios y Agregar Criterio';
        };

        async function procesarFormulario() {
            const nombreTareaInput = document.getElementById('tar_nom');
            if (nombreTareaInput.value.trim() === '') {
                alert('El Nombre de la Tarea es obligatorio.'); return;
            }
            if (criterioDescInput.value.trim() !== '' && criterioPuntosInput.value === '') {
                alert('Si agregas una descripción de criterio, debes seleccionar los puntos.'); return;
            }

            const form = document.getElementById('form-tarea');
            const formDataConTodo = new FormData(form);
            formDataConTodo.append('criterio_desc', criterioDescInput.value);
            formDataConTodo.append('criterio_puntos', criterioPuntosInput.value);

            try {
                btnAgregarCriterio.disabled = true;
                const response = await fetch(`${BASE_URL}tareas/ajax_gestionar_tarea_criterio`, {
                    method: 'POST', body: formDataConTodo, headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
                const result = await response.json();

                if (result.status === 'success') {
                    if (!tareaId) {
                        actualizarUiModoEdicion(result.tarea_id);
                        mostrarEstado('¡Tarea guardada exitosamente!');
                    } else {
                        mostrarEstado('Cambios guardados.');
                    }
                    
                    if (result.criterio_id) {
                         agregarFilaCriterio(formDataConTodo.get('criterio_desc'), formDataConTodo.get('criterio_puntos'), result.criterio_id);
                    }
                    
                } else {
                    mostrarEstado('Error: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error en la petición AJAX:', error);
                mostrarEstado('Ocurrió un error de comunicación con el servidor.', 'danger');
            } finally {
                btnAgregarCriterio.disabled = false;
            }
        };

        // --- LÓGICA DE BOTONES Y EVENTOS ---

        btnAgregarCriterio.addEventListener('click', async function() {
            await procesarFormulario(); 
            unlockAllPanelsAndReset(); 
        });

        $('#tabla-criterios tbody').on('click', 'button', async function(event) {
            const button = $(this);
            const fila = button.closest('tr');
            const criterioId = fila.data('criterio-id');

            if (button.hasClass('btn-editar-criterio')) {
                activeEditingRow = fila;
                const data = criteriosTable.row(fila).data();
                $('#edit-criterio-id').val(criterioId);
                $('#edit-criterio-desc').val(data[1]);
                $('#edit-criterio-puntos').val(data[2]);
                editModal.show();
            }

            if (button.hasClass('btn-eliminar-criterio')) {
                if (confirm('¿Estás seguro de que quieres eliminar este criterio?')) {
                    try {
                        const response = await fetch(`${BASE_URL}tareas/ajax_eliminar_criterio`, {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
                            body: JSON.stringify({ criterio_id: criterioId })
                        });
                        const result = await response.json();
                        if (result.status === 'success') {
                            criteriosTable.row(fila).remove().draw();
                            mostrarEstado('Criterio eliminado.');
                            actualizarUIContador();
                        } else {
                            mostrarEstado(result.message || 'Error al eliminar', 'danger');
                        }
                    } catch (error) {
                        mostrarEstado('Error de comunicación.', 'danger');
                    }
                }
            }
        });

        $('#btn-guardar-cambios-criterio').on('click', async function() {
            const id = $('#edit-criterio-id').val();
            const desc = $('#edit-criterio-desc').val();
            const puntos = $('#edit-criterio-puntos').val();

            if (!desc.trim() || !puntos) {
                alert('La descripción y los puntos son obligatorios.');
                return;
            }

            const formData = new FormData();
            formData.append('criterio_id', id);
            formData.append('descripcion', desc);
            formData.append('puntos', puntos);

            try {
                const response = await fetch(`${BASE_URL}tareas/ajax_actualizar_criterio`, {
                    method: 'POST', body: formData, headers: {'X-Requested-With': 'XMLHttpRequest'}
                });
                const result = await response.json();

                if (result.status === 'success') {
                    const rowData = criteriosTable.row(activeEditingRow).data();
                    rowData[1] = desc;
                    rowData[2] = puntos;
                    criteriosTable.row(activeEditingRow).data(rowData).draw();
                    editModal.hide();
                    mostrarEstado('Criterio actualizado exitosamente.');
                } else {
                    alert('Error: ' + (result.message || 'No se pudo actualizar.'));
                }
            } catch (error) {
                alert('Error de comunicación con el servidor.');
            }
        });

        $('#modal-editar-criterio').on('hidden.bs.modal', unlockAllPanelsAndReset);

        $('#tabla-criterios tbody').on('change', '.criterio-cumplido-check', async function() {
            const checkbox = this;
            const criterioId = $(checkbox).data('criterio-id');
            const cumplido = checkbox.checked ? 1 : 0;

            try {
                const response = await fetch(`${BASE_URL}tareas/ajax_actualizar_estado_criterio`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
                    body: JSON.stringify({ criterio_id: criterioId, cumplido: cumplido })
                });
                const result = await response.json();
                if (result.status === 'success') {
                    mostrarEstado('Estado del criterio actualizado.');
                } else {
                    mostrarEstado(result.message || 'Error al actualizar', 'danger');
                    checkbox.checked = !checkbox.checked;
                }
            } catch (error) {
                mostrarEstado('Error de comunicación.', 'danger');
                checkbox.checked = !checkbox.checked;
            }
        });
        
        // --- LÓGICA DE INICIALIZACIÓN ---
        if (modo === 'editar') {
            btnTextoAgregar.textContent = 'Guardar Cambios y Agregar Criterio';
        } else {
            btnTextoAgregar.textContent = 'Guardar Tarea y Agregar Criterio';
        }
        
        actualizarUIContador();
    });
</script>

</body>