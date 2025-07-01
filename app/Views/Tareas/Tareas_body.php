<body>

<div class="container my-5">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0" id="titulo-pagina">Crear Tarea</h1>
        <!-- Mensaje de estado para el usuario -->
        <span id="estado-guardado" class="text-success fw-bold"></span>
    </div>

    <!-- El form agrupa los campos para FormData, onsubmit="return false;" previene el envío tradicional -->
    <form id="form-tarea" onsubmit="return false;">
        <!-- Campo oculto para guardar el ID de la tarea una vez creada. Es crucial para el flujo. -->
        <input type="hidden" name="tarea_id" id="tarea_id" value="">
    
        <div class="row">

            <!-- Columna Izquierda: Información de la Tarea -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-primary">Información de la Tarea</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="tar_nom" class="form-label">Nombre de la Historia / Tarea</label>
                            <input type="text" name="tar_nom" class="form-control" id="tar_nom" placeholder="Ej: Como usuario, quiero poder..." required>
                        </div>
                        <div class="mb-3">
                            <label for="tar_desc" class="form-label">Descripción Detallada</label>
                            <textarea class="form-control" name="tar_desc" id="tar_desc" rows="5" placeholder="Describe los criterios de aceptación y detalles funcionales."></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="solicitado_por_usuario_id" class="form-label">Solicitado por</label>
                                <select class="form-select" name="solicitado_por_usuario_id" id="solicitado_por_usuario_id" required>
                                    <option value="" selected disabled>-- Seleccionar un usuario --</option>
                                    <!-- Aquí se deberían cargar los usuarios desde la base de datos -->
                                    <option value="1">Ricardo Chab Pool</option>
                                    <option value="2">Ana Pérez</option>
                                </select>
                            </div>
                             <div class="col-md-6 mb-3">
                                <label for="fecha_creacion" class="form-label">Fecha de Registro</label>
                                <input type="date" class="form-control" name="fecha_creacion" id="fecha_creacion" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Agregar Criterios -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-primary">Criterios de Aceptación</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="criterio_desc" class="form-label">Descripción del Criterio</label>
                            <textarea class="form-control" id="criterio_desc" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="criterio_puntos" class="form-label">Puntos de Esfuerzo</label>
                            <input type="number" class="form-control" id="criterio_puntos" step="1" min="0" required>
                        </div>
                        <div class="d-grid">
                            <button type="button" id="btn-agregar-criterio" class="btn btn-info text-white">
                                <i class="fas fa-plus me-2"></i>
                                <span id="btn-texto-agregar">Agregar Criterio</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Criterios Agregados -->
        <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Lista de Criterios Agregados</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Descripción del Criterio (Haz clic para editar)</th>
                                <th style="width: 100px;" class="text-center">Puntos</th>
                                <th style="width: 100px;" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="lista-criterios-body">
                            <!-- Los criterios se agregarán aquí dinámicamente con JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
    
    <div class="text-center mt-4">
        <a href="<?= site_url('dashboard') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Regresar
        </a>
    </div>
</div>

<!-- =============================================================== -->
<!-- SCRIPT PARA LA LÓGICA AJAX CON EL BACKEND -->
<!-- =============================================================== -->
<script>
    // Definir la URL base de tu sitio para construir las URLs de AJAX de forma segura.
    // Esto es crucial para que funcione en cualquier entorno (local, producción, etc.).
    const BASE_URL = "<?= site_url() ?>";

    document.addEventListener('DOMContentLoaded', function() {

        // --- VARIABLES DE ESTADO ---
        // La variable 'tareaId' es el cerebro del front-end. Si es null, la tarea no se ha creado.
        let tareaId = document.getElementById('tarea_id').value || null;

        // --- REFERENCIAS A ELEMENTOS DEL DOM ---
        const btnAgregarCriterio = document.getElementById('btn-agregar-criterio');
        const tablaCriteriosBody = document.getElementById('lista-criterios-body');
        const estadoGuardado = document.getElementById('estado-guardado');
        const tituloPagina = document.getElementById('titulo-pagina');
        const btnTextoAgregar = document.getElementById('btn-texto-agregar');

        // --- FUNCIONES AUXILIARES ---
        
        // Muestra un mensaje temporal al usuario
        const mostrarEstado = (mensaje, tipo = 'success') => {
            estadoGuardado.textContent = mensaje;
            estadoGuardado.className = `text-${tipo} fw-bold`;
            setTimeout(() => { 
                estadoGuardado.style.opacity = '0';
                setTimeout(() => { 
                    estadoGuardado.textContent = '';
                    estadoGuardado.style.opacity = '1';
                }, 500);
            }, 3000);
        };

        // Crea y añade una nueva fila <tr> a la tabla de criterios
        const agregarFilaCriterio = (descripcion, puntos, criterioId) => {
            const nuevaFila = document.createElement('tr');
            // Usamos un 'data-attribute' para guardar el ID real del criterio.
            // Es la forma correcta de vincular el elemento HTML con su registro en la BD.
            nuevaFila.setAttribute('data-criterio-id', criterioId);
            
            nuevaFila.innerHTML = `
                <td class="editable align-middle">${descripcion}</td>
                <td class="text-center align-middle">${puntos}</td>
                <td class="text-center align-middle">
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-criterio" title="Eliminar Criterio">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tablaCriteriosBody.appendChild(nuevaFila);
        };

        // Actualiza la UI una vez que una tarea es creada
        const actualizarUiModoEdicion = (idTarea) => {
            tareaId = idTarea;
            document.getElementById('tarea_id').value = idTarea;
            tituloPagina.textContent = 'Editar Tarea';
            btnTextoAgregar.textContent = 'Agregar Otro Criterio';

            // Opcional: Deshabilitar campos principales para evitar cambios
            // document.getElementById('tar_nom').disabled = true;
            // document.getElementById('solicitado_por_usuario_id').disabled = true;
        };


        // --- FUNCIÓN PRINCIPAL: PROCESAR EL FORMULARIO (CREAR/AGREGAR) ---
        const procesarNuevoCriterio = async () => {
            const criterioDescInput = document.getElementById('criterio_desc');
            const criterioPuntosInput = document.getElementById('criterio_puntos');
            const nombreTareaInput = document.getElementById('tar_nom');

            // Validación en el front-end para una respuesta inmediata
            if (nombreTareaInput.value.trim() === '' || criterioDescInput.value.trim() === '' || criterioPuntosInput.value.trim() === '') {
                alert('El Nombre de la Tarea, la Descripción del Criterio y los Puntos son obligatorios.');
                return;
            }

            // Usamos FormData para recolectar todos los campos del formulario de forma sencilla.
            const form = document.getElementById('form-tarea');
            const formData = new FormData(form);
            
            // Agregamos los campos del criterio que están fuera del formulario principal.
            formData.append('criterio_desc', criterioDescInput.value);
            formData.append('criterio_puntos', criterioPuntosInput.value);

            try {
                // Deshabilitar el botón para evitar clics múltiples mientras se procesa la petición
                btnAgregarCriterio.disabled = true;

                // Llamamos a nuestro único endpoint en el backend.
                // El backend (con el SP) se encargará de saber si debe crear una tarea nueva o solo agregar un criterio.
                const response = await fetch(`${BASE_URL}tareas/ajax_gestionar_tarea_criterio`, {
                    method: 'POST',
                    body: formData
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
                // Volver a habilitar el botón
                btnAgregarCriterio.disabled = false;
            }
        };

        // --- DELEGACIÓN DE EVENTOS PARA EDICIÓN Y ELIMINACIÓN ---
        // Escuchamos los clics en el cuerpo de la tabla para manejar dinámicamente los botones de las filas.
        tablaCriteriosBody.addEventListener('click', function(event) {
            const target = event.target;
            
            // --- Lógica para Editar ---
            const celdaEditable = target.closest('.editable');
            if (celdaEditable && !celdaEditable.querySelector('input')) {
                const fila = celdaEditable.closest('tr');
                const criterioId = fila.dataset.criterioId;
                const currentText = celdaEditable.textContent;
                
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
                                body: formData
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
            
            // --- Lógica para Eliminar ---
            const btnEliminar = target.closest('.btn-eliminar-criterio');
            if (btnEliminar) {
                if (confirm('¿Estás seguro de que quieres eliminar este criterio?')) {
                    const fila = btnEliminar.closest('tr');
                    const criterioId = fila.dataset.criterioId;

                    fetch(`${BASE_URL}tareas/ajax_eliminar_criterio`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ criterio_id: criterioId })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === 'success') {
                            fila.remove();
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

        // Asignar el evento principal al botón
        btnAgregarCriterio.addEventListener('click', procesarNuevoCriterio);
    });
</script>

</body>