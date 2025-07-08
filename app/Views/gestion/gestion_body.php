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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="<?= site_url('dashboard') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
                </a>
            </div>
            <h4 class="text-center py-3 m-0">Gestión de Usuarios y Grupos</h4>
            <div></div>
        </div>

        <div class="main-panel">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="view_type" id="show-users" value="users" checked>
                    <label class="btn btn-outline-secondary" for="show-users">Usuarios</label>
                    <input type="radio" class="btn-check" name="view_type" id="show-groups" value="groups">
                    <label class="btn btn-outline-secondary" for="show-groups">Grupos</label>
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
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lógica para alternar vistas (Usuarios/Grupos)
    const userTable = document.getElementById('user-table');
    const groupTable = document.getElementById('group-table');
    const showUsersBtn = document.getElementById('show-users');
    const showGroupsBtn = document.getElementById('show-groups');
    const addUserBtn = document.getElementById('btn-add-user');
    const addGroupBtn = document.getElementById('btn-add-group');

    function toggleElements() {
        if (showUsersBtn.checked) {
            userTable.style.display = 'block';
            groupTable.style.display = 'none';
            addUserBtn.style.display = 'inline-block';
            addGroupBtn.style.display = 'none';
        } else {
            userTable.style.display = 'none';
            groupTable.style.display = 'block';
            addUserBtn.style.display = 'none';
            addGroupBtn.style.display = 'inline-block';
        }
    }

    showUsersBtn.addEventListener('change', toggleElements);
    showGroupsBtn.addEventListener('change', toggleElements);
    toggleElements();

 
});
</script>

</body>