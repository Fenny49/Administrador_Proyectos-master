<body class="<?= ($settings['default_theme'] ?? 'light') === 'dark' ? 'theme-dark' : 'theme-light' ?>">

<div class="main-container">
    <aside class="sidebar d-none d-lg-block">
        <h5 class="text-center my-3" style="color: var(--sidebar-header-text);">AdminProject</h5>
        <nav class="sidebar-nav mt-4">
            <a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </aside>

    <div class="content-wrapper">
        <h4 class="text-center py-3 m-0 flex-grow-1">Gestión de Usuarios y Grupos</h4>

        <div class="main-panel">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="view_type" id="show-users" value="users" checked>
                    <label class="btn btn-outline-secondary" for="show-users">Usuarios</label>
                    <input type="radio" class="btn-check" name="view_type" id="show-groups" value="groups">
                    <label class="btn btn-outline-secondary" for="show-groups">Grupos</label>
                </div>
                <div class="actions-bar">
                    <button class="btn btn-secondary btn-custom"><i class="fas fa-download me-2"></i>Download CSV</button>
                    <button class="btn btn-secondary btn-custom"><i class="fas fa-upload me-2"></i>Export</button>
                    <button class="btn btn-secondary btn-custom"><i class="fas fa-download me-2"></i>Import</button>
                    
                    <button id="btn-add-user" class="btn btn-add btn-custom" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fas fa-plus me-2"></i>Añadir Usuario</button>
                    <button id="btn-add-group" class="btn btn-add btn-custom" data-bs-toggle="modal" data-bs-target="#addGroupModal" style="display: none;"><i class="fas fa-plus me-2"></i>Añadir Grupo</button>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <div id="user-table">
                <h5 class="mb-3">Todos los Usuarios</h5>
                <div class="table-responsive">
                    <table class="table project-table">
                        <thead><tr><th>ID</th><th>Nombre Completo</th><th>Correo</th><th>Rol</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
                        <tbody>
                            <?php if (!empty($usuarios)): foreach ($usuarios as $user): ?>
                            <tr>
                                <td><?= esc($user['Id_usuario']) ?></td>
                                <td><?= esc($user['Nombre'] . ' ' . $user['Apellido_Paterno']) ?></td>
                                <td><?= esc($user['Correo']) ?></td>
                                <td><?= esc($user['Rol']) ?></td>
                                <td><span class="badge <?= $user['Estado'] ? 'bg-success' : 'bg-secondary' ?>"><?= $user['Estado'] ? 'Activo' : 'Inactivo' ?></span></td>
                                <td class="text-end table-actions">...</td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="6" class="text-center">No hay usuarios en la base de datos.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="text-center mt-4">
                    <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Regresar al Panel de Administrador
                    </a>
                </div>

            </div>

            <div id="group-table" style="display: none;">
                <h5 class="mb-3">Todos los Grupos</h5>
                <div class="table-responsive">
                    <table class="table project-table">
                        <thead><tr><th>ID</th><th>Nombre del Grupo</th><th>Descripción</th><th class="text-end">Acciones</th></tr></thead>
                        <tbody>
                            <?php if (!empty($grupos)): foreach ($grupos as $group): ?>
                            <tr>
                                <td><?= esc($group['GPO_ID']) ?></td>
                                <td><?= esc($group['GPO_NOM']) ?></td>
                                <td><?= esc($group['GPO_DESC']) ?></td>
                                <td class="text-end table-actions">...</td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="4" class="text-center">No hay grupos en la base de datos.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Regresar al Panel de Administrador
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?= form_open('/gestion/usuarios/crear') ?>
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 mb-3"><label>Nombre</label><input type="text" name="Nombre" class="form-control" required></div>
                        <div class="col-md-4 mb-3"><label>Apellido Paterno</label><input type="text" name="Apellido_Paterno" class="form-control" required></div>
                        <div class="col-md-4 mb-3"><label>Apellido Materno</label><input type="text" name="Apellido_Materno" class="form-control" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Email</label><input type="email" name="Correo" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Código de Usuario</label><input type="number" name="Codigo_User" class="form-control" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Contraseña</label><input type="password" name="Password" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Rol</label><select name="Rol" class="form-select"><option value="administrador">Administrador</option><option value="capturista">Capturista</option></select></div>
                    </div>
                     <div class="form-group mb-3"><label>Estado</label><select name="Estado" class="form-select"><option value="1">Activo</option><option value="0">Inactivo</option></select></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="addGroupModal" tabindex="-1">
     <div class="modal-dialog">
        <div class="modal-content">
              <?= form_open('/gestion/grupos/crear') ?>
                <div class="modal-header"><h5 class="modal-title">Añadir Nuevo Grupo</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Nombre del Grupo</label><input type="text" name="GPO_NOM" class="form-control" required></div>
                    <div class="mb-3"><label>Descripción</label><textarea name="GPO_DESC" class="form-control" rows="3"></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Grupo</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>


<script>
    // ===== SCRIPT ACTUALIZADO =====
    document.addEventListener('DOMContentLoaded', function() {
        const userTable = document.getElementById('user-table');
        const groupTable = document.getElementById('group-table');
        const showUsersBtn = document.getElementById('show-users');
        const showGroupsBtn = document.getElementById('show-groups');
        // Seleccionamos los nuevos botones de añadir por su ID
        const addUserBtn = document.getElementById('btn-add-user');
        const addGroupBtn = document.getElementById('btn-add-group');

        function toggleElements() {
            const isUsersView = showUsersBtn.checked;

            userTable.style.display = isUsersView ? 'block' : 'none';
            groupTable.style.display = isUsersView ? 'none' : 'block';

            // Mostramos u ocultamos el botón de añadir correspondiente
            addUserBtn.style.display = isUsersView ? 'inline-block' : 'none';
            addGroupBtn.style.display = isUsersView ? 'none' : 'inline-block';
        }

        showUsersBtn.addEventListener('change', toggleElements);
        showGroupsBtn.addEventListener('change', toggleElements);

        // Llamamos a la función al cargar la página para establecer el estado inicial correcto
        toggleElements();
    });
</script>

</body>