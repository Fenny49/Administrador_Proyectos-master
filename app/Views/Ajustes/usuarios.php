<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Gestión de Usuarios y Grupos
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="panel-title mb-0">Gestión de Usuarios y Grupos</h1>
    <div class="actions-bar">
        <button class="btn btn-secondary btn-sm" onclick="alert('Funcionalidad no implementada')"><i class="fas fa-download me-1"></i> Download CSV</button>
        <button class="btn btn-secondary btn-sm" onclick="alert('Funcionalidad no implementada')"><i class="fas fa-upload me-1"></i> Export</button>
    </div>
</div>

<div class="data-panel">
    <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
        <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="view_type" id="show_users" value="users" checked>
            <label class="btn btn-outline-light" for="show_users">Usuarios</label>
            <input type="radio" class="btn-check" name="view_type" id="show_groups" value="groups">
            <label class="btn btn-outline-light" for="show_groups">Grupos</label>
        </div>
        <div id="action_buttons">
            <a href="#" class="btn btn-info btn-sm text-white"><i class="fas fa-plus me-1"></i> Añadir Usuario</a>
            <a href="#" class="btn btn-info btn-sm text-white" style="display:none;"><i class="fas fa-plus me-1"></i> Añadir Grupo</a>
        </div>
        <div class="ms-auto d-flex flex-wrap gap-3" id="user_filters">
            <select class="form-select form-select-sm" id="role_filter" style="width: 180px;">
                <option value="">Todos los Roles</option>
                <?php if (!empty($filters['user_types'])): ?>
                    <?php foreach($filters['user_types'] as $role): ?>
                        <option value="<?= esc($role) ?>"><?= esc($role) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <select class="form-select form-select-sm" id="status_filter" style="width: 180px;">
                <option value="">Todos los Estados</option>
                <?php if (!empty($filters['estados'])): ?>
                    <?php foreach($filters['estados'] as $estado): ?>
                        <option value="<?= esc($estado) ?>"><?= esc($estado) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table id="main_table" class="table table-light-theme" style="width:100%">
            <thead></thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
    const resources = <?= isset($resources) ? json_encode($resources) : '[]' ?>;
    const filters = <?= isset($filters) ? json_encode($filters) : '[]' ?>;
    let currentViewType = 'users';

    $(document).ready(function() {
        let table; 
        function setupTable(type) {
            let columns = [];
            let data = [];
            
            $("#user_filters").toggle(type === 'users');
            $("#action_buttons a").eq(0).toggle(type === 'users');
            $("#action_buttons a").eq(1).toggle(type === 'groups');

            if (type === 'users') {
                columns = [
                    { title: "Foto", data: "foto", orderable: false },
                    { title: "Nombre", data: "nombre" },
                    { title: "Email", data: "email" },
                    { title: "Rol", data: "rol" },
                    { title: "Estado", data: "estado" },
                    { title: "Acciones", data: null, orderable: false, className: "text-center" }
                ];
                data = resources.users || [];
            } else { // groups
                
                // ===== INICIO DE LA CORRECCIÓN =====
                // Ahora la tabla de grupos también tiene 6 columnas para que coincida
                columns = [
                    { title: "Código", data: "codigo" },
                    { title: "Nombre del Grupo", data: "nombre" },
                    { title: "Miembros", data: "miembros" },
                    { title: "Líder de Grupo", data: "lider" },
                    { title: "", data: null, orderable: false, defaultContent: "" }, // <-- Columna vacía de relleno
                    { title: "Acciones", data: null, orderable: false, className: "text-center" }
                ];
                // ===== FIN DE LA CORRECCIÓN =====

                data = resources.groups || [];
            }
            if ($.fn.DataTable.isDataTable('#main_table')) { table.destroy(); $('#main_table thead').empty(); }
            
            table = $('#main_table').DataTable({
                "pageLength": 10, "dom": 't<"d-flex justify-content-center pt-3"p>',
                "language": { "emptyTable": "No hay datos para mostrar.", "paginate": { "previous": "‹", "next": "›" } },
                "columns": columns, "data": data,
                "columnDefs": [
                     {
                        targets: 0,
                        render: function(data, type, row) {
                            if (currentViewType === 'users') {
                                return `<img src="<?= base_url('assets/images/') ?>${row.foto}" alt="Avatar" class="table-avatar">`;
                            }
                            return row.codigo;
                        }
                    },
                    {
                        targets: -1, 
                        render: function() {
                            return `<a href="#" class="btn btn-sm btn-outline-secondary">Editar</a> <a href="#" class="btn btn-sm btn-outline-danger">Eliminar</a>`;
                        }
                    }
                ]
            });
        }
        $('input[name="view_type"]').on('change', function() {
            currentViewType = this.value;
            $('#role_filter').val('').trigger('change');
            $('#status_filter').val('').trigger('change');
            setupTable(this.value);
        });
        $('#role_filter').on('change', function() { table.column(3).search(this.value).draw(); });
        $('#status_filter').on('change', function() { table.column(4).search(this.value).draw(); });
        
        setupTable('users');
    });
</script>
<?= $this->endSection() ?>