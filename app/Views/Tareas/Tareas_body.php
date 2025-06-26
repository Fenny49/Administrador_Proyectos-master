<body>

<div class="main-container">
    
    <aside class="sidebar d-none d-lg-block">
        <div class="sidebar-header">AdminProject</div>
        <nav class="sidebar-nav mt-3">
            <a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('recursos') ?>"><i class="fas fa-star"></i> RECURSOS</a>
            <a href="<?= site_url('tareas') ?>" class="active"><i class="fas fa-tasks"></i> TAREAS</a>
            <a href="<?= site_url('tiempos') ?>"><i class="fas fa-clock"></i> TIEMPO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </aside>

    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas"></button>
            <h4 class="text-center py-3 m-0 flex-grow-1">Gestión de Tareas</h4>
        </div>

        <div class="main-panel">
            <div class="panel-header mb-4">
                <div class="flex-grow-1"><h5 class="m-0">Proyecto: <?= esc($nombreProyecto) ?></h5></div>
                <div class="user-profile">
                    <i class="fas fa-bell"></i><i class="fas fa-envelope"></i>
                    <img src="https://i.pravatar.cc/40?u=ricardo" alt="User Avatar">
                    <div class="user-info">
                        <strong>Ricardo Chab</strong><br><small>Administrador</small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="fas fa-plus me-2"></i>Añadir Nueva Tarea
                </button>
            </div>

            <table class="table task-table">
                <thead>
                    <tr><th>Tarea</th><th>Asignado a</th><th>Fecha Límite</th><th>Estado</th><th class="text-end">Acciones</th></tr>
                </thead>
                <tbody>
                    <?php if (!empty($tasks)): ?>
                        <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?= esc($task['nombre']) ?></td>
                            <td><?= esc($task['asignado_a']) ?></td>
                            <td><?= date('d/m/Y', strtotime($task['fecha_limite'])) ?></td>
                            <td><span class="status-badge status-<?= strtolower(str_replace(' ', '-', esc($task['estado']))) ?>"><?= esc($task['estado']) ?></span></td>
                            <td class="text-end">
                                <a href="#" class="text-secondary" title="Editar"><i class="fas fa-edit"></i></a> 
                                <a href="#" class="text-danger ms-2" title="Eliminar"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-3 text-muted">No hay tareas para mostrar.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas">
    </div>

<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Nueva Historia / Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('tareas/crear') ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <h6 class="text-primary">Detalles de la Tarea</h6>
                            <hr class="mt-0">
                            <div class="form-group mb-3">
                                <label>Nombre de la Historia / Tarea</label>
                                <input type="text" class="form-control" name="nombre_tarea" placeholder="Ej: Como usuario, quiero poder..." required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Descripción Detallada</label>
                                <textarea class="form-control" name="descripcion" rows="5" placeholder="Criterios de aceptación y detalles."></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Puesto de quien solicita</label>
                                    <select class="form-control" name="puesto_solicitante">
                                        <option>Gerente de Producto</option>
                                        <option>Líder de Proyecto</option>
                                        <option>Stakeholder</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Fecha de Registro</label>
                                    <input type="date" class="form-control" name="fecha_registro" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nivel de Urgencia</label>
                                    <select class="form-control" name="nivel_urgencia">
                                        <option>Baja</option>
                                        <option>Normal</option>
                                        <option>Alta</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Nivel de Complejidad</label>
                                    <select class="form-control" name="nivel_complejidad">
                                        <option>Baja (2)</option>
                                        <option>Media (3)</option>
                                        <option>Alta (5)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <h6 class="text-primary">Seguimiento y Pruebas</h6>
                            <hr class="mt-0">
                            <div class="form-group mb-3">
                                <label>Datos sobre el seguimiento / Notas</label>
                                <textarea class="form-control" name="notas_seguimiento" rows="7" placeholder="Avances, bloqueos, etc."></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label>Bitácora de Pruebas Unitarias</label>
                                <textarea class="form-control" name="bitacora_pruebas" rows="7" placeholder="Resultados de pruebas."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Tarea</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">AdminProject</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="sidebar-nav">
            <a href="<?= site_url('dashboard') ?>" class="active"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('recursos') ?>"><i class="fas fa-star"></i> RECURSOS</a>
            <a href="<?= site_url('tareas') ?>"><i class="fas fa-tasks"></i> TAREAS</a>
            <a href="#"><i class="fas fa-clock"></i> TIEMPO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>