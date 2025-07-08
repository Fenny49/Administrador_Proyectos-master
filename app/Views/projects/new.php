<div class="main-panel"> 
    
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('/dashboard') ?>" class="btn btn-light me-3" title="Volver al Dashboard"><i class="fas fa-arrow-left"></i></a>
        <h1 class="panel-title mb-0">AÑADIR UN PROYECTO</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?= form_open(base_url('/projects/create')) ?>
                
                <?php if (session()->has('errors')) : ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                        <?php foreach (session('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <fieldset class="mb-4">
                    <legend class="form-legend">Datos Generales del Proyecto</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre_proyecto" class="form-label">Nombre del Proyecto</label>
                            <input type="text" class="form-control" name="nombre_proyecto" id="nombre_proyecto" value="<?= old('nombre_proyecto') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prioridad" class="form-label">Prioridad</label>
                            <select class="form-select" name="prioridad" id="prioridad">
                                <option value="Normal" <?= old('prioridad') == 'Normal' ? 'selected' : '' ?>>Normal</option>
                                <option value="Media" <?= old('prioridad') == 'Media' ? 'selected' : '' ?>>Media</option>
                                <option value="Alta" <?= old('prioridad') == 'Alta' ? 'selected' : '' ?>>Alta</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="responsable" class="form-label">Responsable del Proyecto</label>
                            <select class="form-select" name="responsable_id" id="responsable" required>
                                <option value="">Seleccione un responsable...</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= $usuario['Id_usuario'] ?>" <?= old('responsable_id') == $usuario['Id_usuario'] ? 'selected' : '' ?>><?= esc($usuario['Nombre'] . ' ' . $usuario['Apellido_Paterno']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?= old('fecha_inicio') ?>" min="<?= $anio_trabajo ?>-01-01" max="<?= $anio_trabajo ?>-12-31" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?= old('fecha_fin') ?>" min="<?= $anio_trabajo ?>-01-01" max="<?= $anio_trabajo ?>-12-31" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="3"><?= old('descripcion') ?></textarea>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mb-4">
                    <legend class="form-legend">Asignación del Personal</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="asignar_usuarios" class="form-label">Añadir Usuarios al Equipo</label>
                            <select class="form-select" name="usuarios[]" id="asignar_usuarios" multiple size="5">
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= $usuario['Id_usuario'] ?>" <?= in_array($usuario['Id_usuario'], old('usuarios', [])) ? 'selected' : '' ?>><?= esc($usuario['Nombre'] . ' ' . $usuario['Apellido_Paterno']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">Mantén presionada la tecla Ctrl (o Cmd en Mac) para seleccionar varios usuarios.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="asignar_grupos" class="form-label">Añadir Grupos al Equipo</label>
                            <select class="form-select" name="grupos[]" id="asignar_grupos" multiple size="5">
                                <?php foreach ($grupos as $grupo): ?>
                                    <option value="<?= $grupo['GPO_ID'] ?>" <?= in_array($grupo['GPO_ID'], old('grupos', [])) ? 'selected' : '' ?>><?= esc($grupo['GPO_NOM']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">Mantén presionada la tecla Ctrl (o Cmd en Mac) para seleccionar varios grupos.</small>
                        </div>
                    </div>
                </fieldset>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-5">Añadir Proyecto</button>
                </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- OBTENER ELEMENTOS DEL FORMULARIO ---
    const form = document.querySelector('form[action$="/projects/create"]');
    const nombreProyectoInput = document.getElementById('nombre_proyecto');
    const fechaInicioInput = document.getElementById('fecha_inicio');
    const fechaFinInput = document.getElementById('fecha_fin');
    const usuariosSelect = document.getElementById('asignar_usuarios');
    const responsableSelect = document.getElementById('responsable');

    // --- VALIDACIÓN 1: NOMBRE DE PROYECTO ÚNICO (AJAX) ---
    nombreProyectoInput.addEventListener('blur', function() {
        const nombreProyecto = this.value.trim();
        if (nombreProyecto === '') return;

        // Pequeño feedback visual
        this.classList.remove('is-invalid', 'is-valid');

        fetch('<?= base_url('/projects/check_name') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest' // Importante para que CodeIgniter lo reconozca como AJAX
            },
            body: JSON.stringify({ nombre_proyecto: nombreProyecto })
        })
        .then(response => response.json())
        .then(data => {
            if (data.existe) {
                alert('Error: Ya existe un proyecto con este nombre.');
                nombreProyectoInput.classList.add('is-invalid');
            } else {
                nombreProyectoInput.classList.add('is-valid');
            }
        });
    });

    // --- VALIDACIÓN GENERAL ANTES DE ENVIAR ---
    form.addEventListener('submit', function(event) {
        let esValido = true;
        let mensajesError = [];

        // --- VALIDACIÓN 2: FECHA DE INICIO vs FECHA DE FIN ---
        if (fechaInicioInput.value && fechaFinInput.value) {
            const fechaInicio = new Date(fechaInicioInput.value);
            const fechaFin = new Date(fechaFinInput.value);

            if (fechaInicio > fechaFin) {
                esValido = false;
                mensajesError.push('La fecha de inicio no puede ser posterior a la fecha de fin.');
                fechaInicioInput.classList.add('is-invalid');
                fechaFinInput.classList.add('is-invalid');
            } else {
                fechaInicioInput.classList.remove('is-invalid');
                fechaFinInput.classList.remove('is-invalid');
            }
        }
        
        // --- VALIDACIÓN 3: AL MENOS UN USUARIO ASIGNADO ---
        const usuariosSeleccionados = Array.from(usuariosSelect.selectedOptions).length;
        
        if (usuariosSeleccionados === 0) {
             esValido = false;
             mensajesError.push('Debes añadir al menos un Usuario al equipo.');
             usuariosSelect.classList.add('is-invalid');
        } else {
            usuariosSelect.classList.remove('is-invalid');
        }

        // --- Si algo no es válido, se detiene el envío y se muestra un error ---
        if (!esValido) {
            event.preventDefault(); // Detiene el envío del formulario
            alert('Por favor, corrige los siguientes errores:\n\n- ' + mensajesError.join('\n- '));
        }
    });
});
</script>