<body class="<?= ($settings['default_theme'] ?? 'light') === 'dark' ? 'theme-dark' : 'theme-light' ?>">

<div class="main-container">
    <!-- BARRA LATERAL (Sidebar) para consistencia visual -->
    <div class="sidebar d-none d-lg-block">
        <h5 class="sidebar-header text-center my-3">AdminProject</h5>
        <nav class="sidebar-nav mt-4">
            <a href="<?= site_url('dashboard') ?>">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
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
                <!-- REQUERIMIENTO 1: MOSTRAR NOMBRE DEL PROYECTO -->
                <h1 class="h3 mb-0" id="titulo-pagina">Añadir Tarea al Proyecto</h1>
                <small class="text fs-5 fw-bold text-primary">
                    <?= esc($proyecto['nombre'] ?? 'Proyecto Desconocido') ?>
                </small>
            </div>
            <span id="estado-guardado" class="text-success fw-bold"></span>
        </div>

            <!-- El form agrupa los campos para FormData, onsubmit="return false;" previene el envío tradicional -->
            <form id="form-tarea" onsubmit="return false;">
                
                <!-- CAMPOS OCULTOS ESENCIALES PARA LA LÓGICA -->
                <!-- Guarda el ID de la tarea una vez creada. Crucial para agregar más criterios. -->
                <input type="hidden" name="tarea_id" id="tarea_id" value="">
                <!-- Pasa el ID del proyecto desde el controlador a la vista. -->
                <input type="hidden" name="proy_id" value="<?= esc($id_proyecto ?? 0) ?>">
                <!-- Valores por defecto para los campos NOT NULL de la BD. -->
                <input type="hidden" name="stat_id" value="1"> <!-- 1 = 'Nuevo' (Ejemplo) -->
                <input type="hidden" name="prio_id" value="2"> <!-- 2 = 'Normal' (Ejemplo) -->
                <input type="hidden" name="gpo_id" value="3">  <!-- 3 = 'Desarrollo' (Ejemplo) -->
            
                <!-- SISTEMA DE REJILLA (GRID) DE BOOTSTRAP PARA RESPONSIVIDAD -->
                <div class="row">

                    <!-- Columna Izquierda: Información de la Tarea (más ancha en pantallas grandes) -->
                    <div class="col-lg-8 mb-4">
                        <div class="data-panel h-100">
                            <h6 class="mb-3 fw-bold text-primary">1. Información de la Tarea</h6>
                            <div class="mb-3">
                                <label for="tar_nom" class="form-label">Nombre de la Historia / Tarea</label>
                                <input type="text" name="tar_nom" class="form-control" id="tar_nom" placeholder="Ej: Como usuario, quiero poder..." required>
                            </div>
                            <div class="mb-3">
                                <label for="tar_desc" class="form-label">Descripción Detallada</label>
                                <textarea class="form-control" name="tar_desc" id="tar_desc" rows="5" placeholder="Describe los criterios de aceptación y detalles funcionales." required></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="solicitado_por_usuario_id" class="form-label">Solicitado por</label>
                                    <select class="form-select" name="solicitado_por_usuario_id" id="solicitado_por_usuario_id"required >
                                        <option value="" selected disabled>-- Seleccione un usuario --</option>
                                            <?php if (!empty($listaUsuarios)): ?>
                                            <?php foreach ($listaUsuarios as $usuario): ?>
                                                <!-- CAMBIO: Usamos corchetes [] en lugar de -> -->
                                                <option value="<?= esc($usuario['Id_usuario']) ?>">
                                                    <?= esc($usuario['NombreCompleto']) ?> (<?= esc(ucfirst($usuario['Rol'])) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                 <div class="col-md-6 mb-3">
                                    <label for="tar_fechafin" class="form-label">Fecha de Finalización (Opcional)</label>
                                    <input type="date" class="form-control" name="tar_fechafin" id="tar_fechafin" 
                                           value="<?= esc($tarea['TAR_FECHAFIN'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha: Agregar Criterios (más estrecha en pantallas grandes) -->
                    <div class="col-lg-4 mb-4">
                        <div class="data-panel h-100">
                            <h6 class="mb-3 fw-bold text-primary">2. Agregar Criterios</h6>
                            <div class="mb-3">
                                <label for="criterio_desc" class="form-label">Descripción del Criterio</label>
                                <textarea class="form-control" id="criterio_desc" rows="4" required placeholder="Ej: El botón debe ser azul."></textarea>
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
                                    <i class="fas fa-plus me-2"></i>
                                    <span id="btn-texto-agregar">Agregar Criterio</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de Criterios Agregados (ocupa todo el ancho) -->
                <div class="data-panel mt-2">
                    <h6 class="mb-3 fw-bold text-primary">3. Lista de Criterios Agregados</h6>
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
                                <!-- Filas de criterios generadas por JS -->
                            </tbody>
                        </table>
                        <div id="no-criterios-msg" class="text-center text-muted p-4" style="display: none;">
                            Aún no se han agregado criterios a esta tarea.
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>


<!-- =============================================================== -->
<!-- SCRIPT AJAX (SIN CAMBIOS EN SU LÓGICA, SÓLO COPIADO) -->
<!-- =============================================================== -->
<script>
    const BASE_URL = "<?= site_url() ?>";

    document.addEventListener('DOMContentLoaded', function() {

        let tareaId = document.getElementById('tarea_id').value || null;

        const btnAgregarCriterio = document.getElementById('btn-agregar-criterio');
        const tablaCriteriosBody = document.getElementById('lista-criterios-body');
        const estadoGuardado = document.getElementById('estado-guardado');
        const tituloPagina = document.getElementById('titulo-pagina');
        const btnTextoAgregar = document.getElementById('btn-texto-agregar');
        const noCriteriosMsg = document.getElementById('no-criterios-msg');

        const checkCriteriosVisibles = () => {
            noCriteriosMsg.style.display = tablaCriteriosBody.rows.length === 0 ? 'block' : 'none';
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
            tablaCriteriosBody.appendChild(nuevaFila);
            checkCriteriosVisibles();
        };

        const actualizarUiModoEdicion = (idTarea) => {
            tareaId = idTarea;
            document.getElementById('tarea_id').value = idTarea;
            tituloPagina.textContent = 'Editar Tarea';
            btnTextoAgregar.textContent = 'Agregar Otro Criterio';
            document.querySelector('a[href="<?= site_url('dashboard') ?>"]').textContent = ' Volver al Proyecto';
        };

        const procesarNuevoCriterio = async () => {
            const criterioDescInput = document.getElementById('criterio_desc');
            const criterioPuntosInput = document.getElementById('criterio_puntos');
            const nombreTareaInput = document.getElementById('tar_nom');

            if (nombreTareaInput.value.trim() === '' || criterioDescInput.value.trim() === '' || criterioPuntosInput.value.trim() === '') {
                alert('El Nombre de la Tarea, la Descripción del Criterio y los Puntos son obligatorios.');
                return;
            }

            const form = document.getElementById('form-tarea');
            const formData = new FormData(form);
            
            formData.append('criterio_desc', criterioDescInput.value);
            formData.append('criterio_puntos', criterioPuntosInput.value);

            try {
                btnAgregarCriterio.disabled = true;

                const response = await fetch(`${BASE_URL}tareas/ajax_gestionar_tarea_criterio`, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
                
                const result = await response.json();

                if (result.status === 'success') {
                    const esPrimeraVez = !tareaId;
                    
                    if (esPrimeraVez) {
                        actualizarUiModoEdicion(result.tarea_id);
                        mostrarEstado('¡Tarea guardada exitosamente!');
                    } else {
                        mostrarEstado('Criterio agregado.');
                    }
                    
                    agregarFilaCriterio(formData.get('criterio_desc'), formData.get('criterio_puntos'), result.criterio_id);
                    
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

        tablaCriteriosBody.addEventListener('click', function(event) {
            const target = event.target;
            
            const celdaEditable = target.closest('.editable');
            if (celdaEditable && !celdaEditable.querySelector('input')) {
                const fila = celdaEditable.closest('tr');
                const criterioId = fila.dataset.criterioId;
                const currentText = celdaEditable.textContent.trim();
                
                celdaEditable.innerHTML = `<input type="text" class="form-control form-control-sm" value="${currentText}" />`;
                const input = celdaEditable.querySelector('input');
                input.focus();
                
                const guardarCambio = async () => {
                    const newText = input.value.trim();
                    if (newText && newText !== currentText) {
                        const formData = new FormData();
                        formData.append('criterio_id', criterioId);
                        formData.append('descripcion', newText);
                        
                        try {
                            const response = await fetch(`${BASE_URL}tareas/ajax_actualizar_criterio`, {
                                method: 'POST',
                                body: formData,
                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                            });
                            const result = await response.json();
                            if (result.status === 'success') {
                                celdaEditable.textContent = newText;
                                mostrarEstado('Criterio actualizado.');
                            } else {
                                mostrarEstado('Error al actualizar: ' + result.message, 'danger');
                                celdaEditable.textContent = currentText;
                            }
                        } catch (error) {
                             console.error('Error al actualizar criterio:', error);
                             mostrarEstado('Error de conexión al actualizar.', 'danger');
                             celdaEditable.textContent = currentText;
                        }
                    } else {
                        celdaEditable.textContent = currentText;
                    }
                };
                
                input.addEventListener('blur', guardarCambio);
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') input.blur();
                    if (e.key === 'Escape') celdaEditable.textContent = currentText;
                });
            }
            
            const btnEliminar = target.closest('.btn-eliminar-criterio');
            if (btnEliminar) {
                if (confirm('¿Estás seguro de que quieres eliminar este criterio?')) {
                    const fila = btnEliminar.closest('tr');
                    const criterioId = fila.dataset.criterioId;

                    fetch(`${BASE_URL}tareas/ajax_eliminar_criterio`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        body: JSON.stringify({ criterio_id: criterioId })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === 'success') {
                            fila.remove();
                            checkCriteriosVisibles();
                            mostrarEstado('Criterio eliminado.');
                        } else {
                            mostrarEstado('Error al eliminar: ' + result.message, 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error al eliminar criterio:', error);
                        mostrarEstado('Error de conexión al eliminar.', 'danger');
                    });
                }
            }
        });

        btnAgregarCriterio.addEventListener('click', procesarNuevoCriterio);
        checkCriteriosVisibles();
    });
</script>

</body>