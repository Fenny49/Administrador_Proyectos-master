<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <h1 class="panel-title mb-0 text-center flex-grow-1">RECURSOS</h1>
    <div class="actions-bar">
        <button class="btn btn-secondary btn-sm" onclick="alert('Funcionalidad no implementada')"><i class="fas fa-download me-1"></i> Download CSV</button>
        <button class="btn btn-secondary btn-sm" onclick="alert('Funcionalidad no implementada')"><i class="fas fa-upload me-1"></i> Export</button>
        <button class="btn btn-secondary btn-sm" onclick="alert('Funcionalidad no implementada')"><i class="fas fa-download me-1"></i> Import</button>
    </div>
</div>

<div class="data-panel">
    <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
        
        <div class="d-flex align-items-center gap-3">
            <div class="btn-group" role="group">
                <input type="radio" class="btn-check" name="resource_type" id="show_users" autocomplete="off" value="users" checked>
                <label class="btn btn-outline-light" for="show_users">Usuarios</label>
                <input type="radio" class="btn-check" name="resource_type" id="show_groups" autocomplete="off" value="groups">
                <label class="btn btn-outline-light" for="show_groups">Grupos</label>
            </div>
            <div class="add-buttons">
                <a href="#" class="btn btn-info btn-sm text-white"><i class="fas fa-plus me-1"></i> Añadir Usuario</a>
                <a href="#" class="btn btn-info btn-sm text-white"><i class="fas fa-plus me-1"></i> Añadir Grupo</a>
            </div>
        </div>
        
        <div class="ms-auto d-flex flex-wrap gap-3">
            <select class="form-select form-select-sm" id="type_filter" style="width: 200px;"></select>
            <select class="form-select form-select-sm" id="project_filter" style="width: 250px;">
                <option value="">Todos los Proyectos</option>
                <?php foreach($filters['projects'] as $project): ?>
                    <option value="<?= esc($project) ?>"><?= esc($project) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table id="resources_table" class="table align-middle" style="width:100%">
            <thead>
                <tr>
                    <th id="header_codigo">Código</th>
                    <th style="width: 50px;">Foto</th>
                    <th id="header_nombre">Nombre</th>
                    <th id="header_tipo">Tipo</th>
                    <th id="header_proyecto">Proyecto Asignado</th>
                    <th class="text-center" style="width: 210px;">Acciones</th>
                </tr>
            </thead>
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
    const resources = <?= json_encode($resources) ?>;
    const filters = <?= json_encode($filters) ?>;

    $(document).ready(function() {
        let table = $('#resources_table').DataTable({
            "pageLength": 10,
            "dom": 't<"d-flex justify-content-center mt-3"p>',
            "language": { "emptyTable": "No hay datos para mostrar.", "paginate": { "previous": "‹", "next": "›" } },
            "columns": [
                { "data": "codigo" },
                { "data": "foto", "render": function(data) { return `<img src="<?= base_url('assets/images/') ?>${data}" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%;">`; }},
                { "data": "nombre" }, { "data": "tipo" }, { "data": "proyecto" },
                { "data": null, "render": function(data, type, row) {
                    return `<div class="text-center">
                                <a href="#" class="btn btn-success btn-sm">Ver</a>
                                <a href="#" class="btn btn-danger btn-sm">Eliminar</a>
                                <a href="#" class="btn btn-warning btn-sm text-dark">Editar</a>
                            </div>`;
                }}
            ],
            "columnDefs": [{ "orderable": false, "targets": [1, 5] }]
        });

        function drawTable(dataType) {
            let dataToShow = resources[dataType];
            let currentTypes = (dataType === 'users') ? filters.user_types : filters.group_types;
            
            $('#header_codigo').text(dataType === 'users' ? 'Código Usuario' : 'Código Grupo');
            $('#header_tipo').text(dataType === 'users' ? 'Tipo Usuario' : 'Tipo Grupo');
            
            table.clear().rows.add(dataToShow).draw();

            const typeFilter = $('#type_filter');
            typeFilter.empty().append('<option value="">Todos los Tipos</option>');
            currentTypes.forEach(type => { typeFilter.append(`<option value="${type}">${type}</option>`); });
        }

        $('input[name="resource_type"]').on('change', function() {
            $('#type_filter').val('').trigger('change');
            $('#project_filter').val('').trigger('change');
            drawTable(this.value);
        });

        $('#type_filter').on('change', function() { table.column(3).search(this.value).draw(); });
        $('#project_filter').on('change', function() { table.column(4).search(this.value).draw(); });

        drawTable('users');
    });
</script>
<?= $this->endSection() ?>