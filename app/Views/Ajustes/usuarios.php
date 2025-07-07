<body class="<?= ($settings['default_theme'] ?? 'dark') === 'dark' ? 'theme-dark' : '' ?>">

<div class="main-container">
    <aside class="sidebar d-none d-lg-block">
        <div class="sidebar-header">AdminProject</div>
        <nav class="sidebar-nav mt-3">
            <a href="<?= site_url('dashboard') ?>" class="<?= (uri_string() == 'dashboard' || uri_string() == '/') ? 'active' : '' ?>"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('ajustes') ?>" class="<?= (strpos(uri_string(), 'ajustes') === 0) ? 'active' : '' ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </aside>

    <div class="content-wrapper">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="panel-title mb-0">Gestión de Usuarios y Grupos</h1>
</div>

<div class="data-panel">
    <div class="card mb-4" style="background-color: var(--sidebar-bg);">
        <div class="card-body">
            <h5 class="card-title">Filtrar por Proyecto</h5>
            <form action="<?= site_url('ajustes/usuarios') ?>" method="GET" class="d-flex flex-wrap gap-2">
                <select name="proyecto_id" class="form-select form-select-sm flex-grow-1">
                    <option value="">-- Mostrar Todos --</option>
                    <?php if (!empty($proyectos)): foreach ($proyectos as $proyecto): ?>
                        <option value="<?= $proyecto['id_proyecto'] ?>" <?= ($selected_project_id == $proyecto['id_proyecto']) ? 'selected' : '' ?>>
                            <?= esc($proyecto['nombre']) ?>
                        </option>
                    <?php endforeach; endif; ?>
                </select>
                <button type="submit" class="btn btn-info btn-sm text-white">Filtrar</button>
                <a href="<?= site_url('ajustes/usuarios') ?>" class="btn btn-secondary btn-sm">Limpiar</a>
            </form>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
        <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="view_type" id="show_users" value="users" checked>
            <label class="btn btn-outline-secondary" for="show_users">Usuarios</label>
            <input type="radio" class="btn-check" name="view_type" id="show_groups" value="groups">
            <label class="btn btn-outline-secondary" for="show_groups">Grupos</label>
        </div>
        <div id="action_buttons">
            <button id="btn-add-user" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fas fa-plus me-1"></i> Añadir Usuario</button>
            <button id="btn-add-group" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addGroupModal" style="display:none;"><i class="fas fa-plus me-1"></i> Añadir Grupo</button>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <strong>¡Error de Validación!</strong>
            <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <h5 id="table_title" class="mb-3"></h5>
        <table id="main_table" class="table table-hover" style="width:100%">
            </table>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= site_url('/ajustes/crearUsuario') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header"><h5 class="modal-title">Añadir Nuevo Usuario</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 mb-3"><label class="form-label">Nombre</label><input type="text" name="Nombre" class="form-control" required></div>
                        <div class="col-md-4 mb-3"><label class="form-label">Apellido Paterno</label><input type="text" name="Apellido_Paterno" class="form-control" required></div>
                        <div class="col-md-4 mb-3"><label class="form-label">Apellido Materno</label><input type="text" name="Apellido_Materno" class="form-control" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Email</label><input type="email" name="Correo" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Código de Usuario</label><input type="number" name="Codigo_User" class="form-control" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Contraseña</label><input type="password" name="Password" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Rol</label><select name="Rol" class="form-select"><option value="administrador">Administrador</option><option value="capturista">Capturista</option></select></div>
                    </div>
                    <div class="form-group mb-3"><label class="form-label">Estado</label><select name="Estado" class="form-select"><option value="1">Activo</option><option value="0">Inactivo</option></select></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary">Guardar Usuario</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addGroupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= site_url('/ajustes/crearGrupo') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header"><h5 class="modal-title">Añadir Nuevo Grupo</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nombre del Grupo</label><input type="text" name="GPO_NOM" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Descripción</label><textarea name="GPO_DESC" class="form-control" rows="3"></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary">Guardar Grupo</button></div>
            </form>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    const resources = <?= json_encode($resources ?? ['users' => [], 'groups' => []]) ?>;
    let table;
    let currentViewType = 'users';

    function setupTable(viewType) {
        let columns = [];
        let data = [];
        let title = '<?= $proyecto_filtrado ? 'Miembros de: ' . esc($proyecto_filtrado['nombre']) : 'Todos' ?>';
        let columnDefs = [];

        $('#btn-add-user').toggle(viewType === 'users');
        $('#btn-add-group').toggle(viewType === 'groups');

        if (viewType === 'users') {
            $('#table_title').text(title.replace('Miembros de', 'Usuarios en') || 'Todos los Usuarios');
            
            // Columnas para Usuarios (sin Foto ni Acciones)
            columns = [
                { title: "ID", data: "Id_usuario" },
                { title: "Nombre", data: "nombre_completo" },
                { title: "Email", data: "Correo" },
                { title: "Rol", data: "Rol" },
                { title: "Estado", data: "Estado" }
            ];
            data = (resources.users || []).map(user => ({...user, nombre_completo: user.nombre_completo || `${user.Nombre} ${user.Apellido_Paterno}`.trim()}));
            
            columnDefs = [
                {
                    targets: 4, // Índice de la columna "Estado"
                    render: (data, type, row) => {
                        if (row.Estado !== undefined && row.Estado !== null) return `<span class="badge rounded-pill ${row.Estado == 1 ? 'text-bg-success' : 'text-bg-secondary'}">${row.Estado == 1 ? 'Activo' : 'Inactivo'}</span>`;
                        return '<span class="badge rounded-pill text-bg-info">Asignado</span>';
                    }
                }
            ];
        } else {
            $('#table_title').text(title.replace('Miembros de', 'Grupos en') || 'Todos los Grupos');
            
            // Columnas para Grupos (sin Acciones)
            columns = [
                { title: "ID", data: "GPO_ID" },
                { title: "Nombre del Grupo", data: "GPO_NOM" },
                { title: "Descripción", data: "GPO_DESC" }
            ];
            data = resources.groups || [];
            columnDefs = []; // No se necesita ninguna definición de columna especial
        }

        if ($.fn.DataTable.isDataTable('#main_table')) {
            table.destroy();
            $('#main_table').empty();
        }
        
        table = $('#main_table').DataTable({
            "pageLength": 10, "dom": 't<"d-flex justify-content-center pt-3"p>',
            "language": { "emptyTable": "No hay datos para mostrar.", "paginate": { "previous": "‹", "next": "›" } },
            "columns": columns, "data": data, "columnDefs": columnDefs
        });
    }

    $('input[name="view_type"]').on('change', function() {
        currentViewType = this.value;
        setupTable(currentViewType);
    });
    
    // Inicia la tabla con la vista de usuarios por defecto
    setupTable('users');
});
</script>
<?= $this->endSection() ?>