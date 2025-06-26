<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="main-panel"> 
    
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('/dashboard') ?>" class="btn btn-light me-3" title="Volver al Dashboard"><i class="fas fa-arrow-left"></i></a>
        <h1 class="panel-title mb-0">AÑADIR UN PROYECTO</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            
            <?= form_open(base_url('/proyectos/crear')) ?>

                <fieldset class="mb-4">
                    <legend class="form-legend">Datos Generales del Proyecto</legend>
                    <div class="row">
                        <div class="col-md-4 mb-3"><label for="nombre_proyecto" class="form-label">Nombre del Proyecto</label><input type="text" class="form-control" name="nombre_proyecto" id="nombre_proyecto" required></div>
                        <div class="col-md-4 mb-3"><label for="no_referencia" class="form-label">No. Referencia</label><input type="text" class="form-control" name="no_referencia" id="no_referencia"></div>
                        <div class="col-md-4 mb-3"><label for="fecha_inicio" class="form-label">Fecha de Inicio</label><input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3"><label for="prioridad" class="form-label">Prioridad</label><select class="form-select" name="prioridad" id="prioridad"><option value="Normal">Normal</option><option value="Media">Media</option><option value="Alta">Alta</option></select></div>
                        <div class="col-md-4 mb-3"><label for="responsable" class="form-label">Responsable</label><input type="text" class="form-control" name="responsable" id="responsable"></div>
                        <div class="col-md-4 mb-3"><label for="fecha_fin" class="form-label">Fecha de Fin</label><input type="date" class="form-control" name="fecha_fin" id="fecha_fin" required></div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3"><label for="descripcion" class="form-label">Descripción</label><textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea></div>
                    </div>
                </fieldset>

                <fieldset class="mb-4">
                    <legend class="form-legend">Asignación del Personal</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Añadir Usuarios</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: var(--panel-light-bg); border-color: #555;"><i class="fas fa-bars"></i></span>
                                <input type="text" class="form-control" placeholder="Buscar Usuarios">
                                <span class="input-group-text" style="background-color: var(--panel-light-bg); border-color: #555;"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Añadir Grupos</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: var(--panel-light-bg); border-color: #555;"><i class="fas fa-bars"></i></span>
                                <input type="text" class="form-control" placeholder="Buscar Grupos">
                                <span class="input-group-text" style="background-color: var(--panel-light-bg); border-color: #555;"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mb-4">
                    <legend class="form-legend">Costos y Presupuestos</legend>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-2 row align-items-center"><label class="col-sm-5 col-form-label">Presupuesto Inicial</label><div class="col-sm-7"><input type="text" class="form-control"></div></div>
                            <div class="mb-2 row align-items-center"><label class="col-sm-5 col-form-label">Presupuesto Máximo</label><div class="col-sm-7"><input type="text" class="form-control"></div></div>
                            <div class="mb-2 row align-items-center"><label class="col-sm-5 col-form-label">Costo de Mano de O.</label><div class="col-sm-7"><input type="text" class="form-control"></div></div>
                            <div class="mb-2 row align-items-center"><label class="col-sm-5 col-form-label">Costo del Equipo</label><div class="col-sm-7"><input type="text" class="form-control"></div></div>
                        </div>
                        <div class="col-md-4">
                             <div class="input-group mb-2"><span class="input-group-text" style="min-width: 140px;">Costo de Programas</span><input type="text" class="form-control text-end" value="$100,000.00" readonly><button class="btn btn-danger btn-sm" type="button">X</button></div>
                             <div class="input-group mb-2"><span class="input-group-text" style="min-width: 140px;">Costo de Servicio</span><input type="text" class="form-control text-end" value="$250,000.00" readonly><button class="btn btn-danger btn-sm" type="button">X</button></div>
                        </div>
                        <div class="col-md-4 text-center">
                            <button type="button" class="btn mb-3" style="background-color: var(--accent-yellow); color: #333; font-weight: bold;">Añadir Costo</button>
                            <div class="mb-2 row align-items-center"><label class="col-sm-5 col-form-label text-end">Nombre del Costo</label><div class="col-sm-7"><input type="text" class="form-control"></div></div>
                            <div class="mb-2 row align-items-center"><label class="col-sm-5 col-form-label text-end">Cantidad</label><div class="col-sm-7"><input type="text" class="form-control"></div></div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mb-4">
                    <legend class="form-legend">Status</legend>
                    <div class="d-flex gap-4"><div class="form-check"><input class="form-check-input" type="radio" name="status" id="status_activo" value="Activo" checked><label class="form-check-label" for="status_activo">Activo</label></div><div class="form-check"><input class="form-check-input" type="radio" name="status" id="status_pendiente" value="Pendiente"><label class="form-check-label" for="status_pendiente">Pendiente</label></div><div class="form-check"><input class="form-check-input" type="radio" name="status" id="status_atrasado" value="Atrasado"><label class="form-check-label" for="status_atrasado">Atrasado</label></div></div>
                </fieldset>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-5">Añadir Proyecto</button>
                </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>