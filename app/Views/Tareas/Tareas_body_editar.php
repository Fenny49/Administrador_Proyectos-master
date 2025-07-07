<body class="<?= ($settings['default_theme'] ?? 'dark') === 'dark' ? 'theme-dark' : 'theme-light' ?>">

<div class="main-container">
    <!-- BARRA LATERAL (Sidebar) para consistencia visual -->
    <div class="sidebar d-none d-lg-block">
        <h5 class="sidebar-header text-center my-3">AdminProject</h5>
        <nav class="sidebar-nav mt-4">
            <!-- El enlace de "Volver" ahora apunta a la lista de tareas del proyecto -->
            <a href="<?= site_url('tareas/listar/' . $id_proyecto) ?>">
                <i class="fas fa-arrow-left"></i> Volver a la Lista
            </a>
            <a href="#" class="active">
                <i class="fas fa-tasks"></i> Gestión de Tareas
            </a>
        </nav>
    </div>

    <!-- ENVOLTORIO PRINCIPAL DEL CONTENIDO -->
    <div class="content-wrapper">
        <div class="main-panel">

            <!-- Encabezado de la página (Título dinámico) -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0" id="titulo-pagina">
                        <?= ($modo === 'editar') ? 'Editar Tarea' : 'Crear Tarea para el Proyecto' ?>
                    </h1>
                    <small class="fs-5 fw-bold text-primary">
                        <?= esc($proyecto['nombre'] ?? 'Proyecto Desconocido') ?>
                    </small>
                </div>
                <span id="estado-guardado" class="text-success fw-bold"></span>
            </div>
            

            <!-- FORMULARIO PRINCIPAL -->
            <form id="form-tarea" onsubmit="return false;">
                
                <!-- CAMPOS OCULTOS ESENCIALES -->
                <input type="hidden" name="tarea_id" id="tarea_id" value="<?= esc($tarea['TAR_ID'] ?? '') ?>">
                <input type="hidden" name="proy_id" value="<?= esc($id_proyecto) ?>">
                <input type="hidden" name="stat_id" value="<?= esc($tarea['STAT_ID'] ?? '1') ?>">
                <input type="hidden" name="prio_id" value="<?= esc($tarea['PRIO_ID'] ?? '2') ?>">
                <input type="hidden" name="gpo_id" value="<?= esc($tarea['GPO_ID'] ?? '3') ?>">
            
                <!-- SISTEMA DE REJILLA (GRID) DE BOOTSTRAP -->
                <div class="row">

                    <!-- Columna Izquierda: Información de la Tarea -->
                    <div class="col-lg-8 mb-4">
                        <div class="data-panel h-100 p-4">
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
                    <!-- Columna para cambiar estado -->
                    <div class="col-md-6 mb-3">
                        <label for="stat_id" class="form-label">Estado de la Tarea</label>
                        <select class="form-select" name="stat_id" id="stat_id">
                            <?php foreach ($listaEstatus as $estatus): ?>
                                <option value="<?= esc($estatus['STAT_ID']) ?>"
                                        <?= (isset($tarea['STAT_ID']) && $tarea['STAT_ID'] == $estatus['STAT_ID']) ? 'selected' : '' ?>>
                                    <?= esc($estatus['STAT_NOM']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                            <!-- ESTRUCTURA HTML CORREGIDA: Filas y columnas -->
                            <div class="row">
                                <!-- Columna para "Solicitado por" -->
                                <div class="col-md-6 mb-3">
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
                                <!-- Columna HERMANA para "Fecha de Finalización" -->
                                <div class="col-md-6 mb-3">
                                    <label for="tar_fechafin" class="form-label">Fecha de Finalización (Opcional)</label>
                                    <input type="date" class="form-control" name="tar_fechafin" id="tar_fechafin" 
                                           value="<?= esc($tarea['TAR_FECHAFIN'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha: Agregar Criterios -->
                    <div class="col-lg-4 mb-4">
                        <div class="data-panel h-100 p-4">
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
                            <div class="d-grid mt-4">
                                <button type="button" id="btn-agregar-criterio" class="btn btn-info text-white btn-lg">
                                    <i class="fas fa-save me-2"></i>
                                    <span id="btn-texto-agregar">Guardar Tarea y Agregar Criterio</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de Criterios Agregados -->
                <div class="data-panel mt-2 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="m-0 fw-bold text-primary">3. Lista de Criterios Agregados</h6>
                        <span class="badge bg-primary rounded-pill" id="contador-criterios">0</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Descripción del Criterio (Haz clic para editar)</th>
                                    <th style="width: 120px;" class="text-center">Puntos</th>
                                    <th style="width: 100px;" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="lista-criterios-body">
                                <?php if (!empty($criteriosExistentes)): ?>
                                    <?php foreach ($criteriosExistentes as $criterio): ?>
                                        <tr data-criterio-id="<?= esc($criterio['CRITERIO_ID']) ?>">
                                            <td class="editable align-middle" style="cursor:pointer;" title="Haz clic para editar"><?= esc($criterio['CRITERIO_DESCRIPCION']) ?></td>
                                            <td class="text-center align-middle"><?= esc($criterio['PUNTOS_ESTIMADOS']) ?></td>
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-danger btn-sm btn-eliminar-criterio" title="Eliminar Criterio"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div id="no-criterios-msg" class="text-center text-muted p-4">Aún no se han agregado criterios a esta tarea.</div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>

<!-- SCRIPT DE JAVASCRIPT -->
<script>
    const BASE_URL = "<?= site_url() ?>";

    document.addEventListener('DOMContentLoaded', function() {
        const modo = '<?= $modo ?>';
        let tareaId = document.getElementById('tarea_id').value || null;

        // --- REFERENCIAS A ELEMENTOS DEL DOM ---
        const btnAgregarCriterio = document.getElementById('btn-agregar-criterio');
        const tablaCriteriosBody = document.getElementById('lista-criterios-body');
        const estadoGuardado = document.getElementById('estado-guardado');
        const btnTextoAgregar = document.getElementById('btn-texto-agregar');
        const noCriteriosMsg = document.getElementById('no-criterios-msg');
        const contadorCriteriosBadge = document.getElementById('contador-criterios');

        // --- FUNCIONES AUXILIARES ---

        const actualizarUIContador = () => {
            const numeroDeFilas = tablaCriteriosBody.rows.length;
            contadorCriteriosBadge.textContent = numeroDeFilas;
            noCriteriosMsg.style.display = numeroDeFilas === 0 ? 'block' : 'none';
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
            const nuevaFila = document.createElement('tr');
            nuevaFila.setAttribute('data-criterio-id', criterioId);
            
            nuevaFila.innerHTML = `
                <td class="editable align-middle" style="cursor:pointer;" title="Haz clic para editar">${descripcion}</td>
                <td class="text-center align-middle">${puntos}</td>
                <td class="text-center align-middle">
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-criterio" title="Eliminar Criterio">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tablaCriteriosBody.appendChild(nuevaFila); // Añade la fila a la tabla
            actualizarUIContador(); // Actualiza el contador
        };
        
        const actualizarUiModoEdicion = (idTarea) => {
            tareaId = idTarea;
            document.getElementById('tarea_id').value = idTarea;
            document.getElementById('titulo-pagina').textContent = 'Editar Tarea';
            btnTextoAgregar.textContent = 'Guardar Cambios y Agregar Criterio';
        };

        const procesarFormulario = async () => {
            const nombreTareaInput = document.getElementById('tar_nom');
            const criterioDescInput = document.getElementById('criterio_desc');
            const criterioPuntosInput = document.getElementById('criterio_puntos');

            if (nombreTareaInput.value.trim() === '') {
                alert('El Nombre de la Tarea es obligatorio.');
                return;
            }

            if (criterioDescInput.value.trim() !== '' && criterioPuntosInput.value === '') {
                alert('Si agregas una descripción de criterio, debes seleccionar los puntos.');
                return;
            }

            const form = document.getElementById('form-tarea');
            const formData = new FormData(form);
            
            formData.append('criterio_desc', criterioDescInput.value);
            formData.append('criterio_puntos', criterioPuntosInput.value);

            try {
                btnAgregarCriterio.disabled = true;
                const response = await fetch(`${BASE_URL}tareas/ajax_gestionar_tarea_criterio`, {
                    method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' }
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
                    
                    // Solo agrega la fila si se creó un nuevo criterio
                    if (result.criterio_id) {
                         agregarFilaCriterio(formData.get('criterio_desc'), formData.get('criterio_puntos'), result.criterio_id);
                    }
                    
                    criterioDescInput.value = '';
                    criterioPuntosInput.value = '';
                    criterioDescInput.focus();
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

        // --- LÓGICA PARA EDITAR EN LÍNEA Y BORRAR ---
        tablaCriteriosBody.addEventListener('click', function(event) {
            const target = event.target;
            
            // Lógica para Editar
            const celdaEditable = target.closest('.editable');
            if (celdaEditable && !celdaEditable.querySelector('input')) {
                // ... (código de edición en línea) ...
            }
            
            const btnEliminar = target.closest('.btn-eliminar-criterio');

if (btnEliminar) {
    // 1. Pide confirmación al usuario para evitar borrados accidentales.
    if (confirm('¿Estás seguro de que quieres eliminar este criterio?')) {
        
        // 2. Obtiene la fila y el ID del criterio del atributo data-criterio-id.
        const fila = btnEliminar.closest('tr');
        const criterioId = fila.dataset.criterioId;

        // 3. Realiza la petición AJAX al endpoint de eliminación.
        fetch(`${BASE_URL}tareas/ajax_eliminar_criterio`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            // 4. Envía el ID del criterio en formato JSON.
            //    Esto es crucial para que request->getJSON() funcione en CodeIgniter.
            body: JSON.stringify({ criterio_id: criterioId })
        })
        .then(response => {
            if (!response.ok) {
                // Si la respuesta del servidor no es exitosa (ej. error 500), lanza un error.
                throw new Error('Error en la respuesta del servidor.');
            }
            return response.json(); // Parsea la respuesta JSON del backend.
        })
        .then(result => {
            // 5. Procesa la respuesta del backend.
            if (result.status === 'success') {
                // Si el backend confirma el borrado, actualiza la interfaz.
                fila.remove(); // Elimina la fila de la tabla.
                actualizarUIContador(); // Actualiza el contador de criterios.
                mostrarEstado('Criterio eliminado exitosamente.');
            } else {
                // Si el backend devuelve un error, muéstralo.
                mostrarEstado('Error al eliminar: ' + (result.message || 'Error desconocido'), 'danger');
            }
        })
        .catch(error => {
            // 6. Maneja errores de red o de comunicación.
            console.error('Error en la petición AJAX para eliminar:', error);
            mostrarEstado('Error de comunicación al intentar eliminar.', 'danger');
        });
    }
}
        });
        
        // --- LÓGICA DE INICIALIZACIÓN ---
        if (modo === 'editar') {
            btnTextoAgregar.textContent = 'Guardar Cambios y Agregar Criterio';
        } else {
            btnTextoAgregar.textContent = 'Guardar Tarea y Agregar Criterio';
        }
        
        actualizarUIContador(); // Llama al contador al cargar la página
        btnAgregarCriterio.addEventListener('click', procesarFormulario);
    });
    
</script>

</body>