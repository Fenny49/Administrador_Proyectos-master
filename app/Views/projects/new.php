<div class="main-panel"> 
    
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('/dashboard') ?>" class="btn btn-light me-3" title="Volver al Dashboard"><i class="fas fa-arrow-left"></i></a>
        <h1 class="panel-title mb-0">AÑADIR UN PROYECTO</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?= form_open(base_url('/projects/create')) ?>
                
                <!-- DATOS GENERALES -->
                <fieldset class="mb-4">
                    <legend class="form-legend">Datos Generales del Proyecto</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre_proyecto" class="form-label">Nombre del Proyecto</label>
                            <input type="text" class="form-control" name="nombre_proyecto" id="nombre_proyecto" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prioridad" class="form-label">Prioridad</label>
                            <select class="form-select" name="prioridad" id="prioridad">
                                <option value="Normal">Normal</option>
                                <option value="Media">Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="responsable" class="form-label">Responsable del Proyecto</label>
                            <select class="form-select" name="responsable_id" id="responsable" required>
                                <option value="">Seleccione un responsable...</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= $usuario['Id_usuario'] ?>"><?= esc($usuario['Nombre'] . ' ' . $usuario['Apellido_Paterno']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" min="<?= $anio_trabajo ?>-01-01" max="<?= $anio_trabajo ?>-12-31" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" min="<?= $anio_trabajo ?>-01-01" max="<?= $anio_trabajo ?>-12-31" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
                        </div>
                    </div>
                </fieldset>

                <!-- ASIGNACIÓN DE PERSONAL -->
                <fieldset class="mb-4">
                    <legend class="form-legend">Asignación del Personal</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="asignar_usuarios" class="form-label">Añadir Usuarios al Equipo</label>
                            <select class="form-select" name="usuarios[]" id="asignar_usuarios" multiple size="5">
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= $usuario['Id_usuario'] ?>"><?= esc($usuario['Nombre'] . ' ' . $usuario['Apellido_Paterno']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">Mantén presionada la tecla Ctrl (o Cmd en Mac) para seleccionar varios usuarios.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="asignar_grupos" class="form-label">Añadir Grupos al Equipo</label>
                            <select class="form-select" name="grupos[]" id="asignar_grupos" multiple size="5">
                                <?php foreach ($grupos as $grupo): ?>
                                    <option value="<?= $grupo['GPO_ID'] ?>"><?= esc($grupo['GPO_NOM']) ?></option>
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

