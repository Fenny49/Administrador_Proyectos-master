<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestión de: <?= esc($title) ?></h1>
        <button id="btn-nuevo" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Nuevo Registro
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= esc($item[$id_field]) ?></td>
                                <td><?= esc($item[$name_field]) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm btn-editar" 
                                            data-id="<?= esc($item[$id_field]) ?>" 
                                            data-name="<?= esc($item[$name_field]) ?>">
                                        Editar
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-eliminar"
                                            data-id="<?= esc($item[$id_field]) ?>">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Crear/Editar -->
<div class="modal fade" id="catalog-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="catalog-form">
                    <input type="hidden" id="item-id" name="id">
                    <div class="form-group">
                        <label for="item-name">Nombre</label>
                        <input type="text" class="form-control" id="item-name" name="name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="catalog-form">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Incluir SweetAlert2 y jQuery -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Asegúrate de tener jQuery -->

<script>
$(document).ready(function() {
    const catalogType = '<?= esc($catalogType, 'js') ?>';
    let editMode = false;
    
    // Abrir modal para NUEVO registro
    $('#btn-nuevo').on('click', function() {
        editMode = false;
        $('#catalog-form')[0].reset();
        $('#modal-title').text('Nuevo Registro en <?= esc($title, 'js') ?>');
        $('#item-id').val('');
        $('#catalog-modal').modal('show');
    });

    // Abrir modal para EDITAR registro
    $('.btn-editar').on('click', function() {
        editMode = true;
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        $('#modal-title').text('Editar Registro en <?= esc($title, 'js') ?>');
        $('#item-id').val(id);
        $('#item-name').val(name);
        $('#catalog-modal').modal('show');
    });

    // Enviar formulario (Crear o Actualizar)
    $('#catalog-form').on('submit', function(e) {
        e.preventDefault();
        const id = $('#item-id').val();
        const name = $('#item-name').val();
        let url = '';
        
        if (editMode) {
            url = `<?= site_url('catalogos/update/') ?>${catalogType}/${id}`;
        } else {
            url = `<?= site_url('catalogos/create/') ?>${catalogType}`;
        }
        
        $.ajax({
            url: url,
            method: 'POST',
            data: { name: name },
            dataType: 'json',
            success: function(response) {
                $('#catalog-modal').modal('hide');
                if (response.success) {
                    Swal.fire('¡Éxito!', response.message, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'No se pudo comunicar con el servidor.', 'error');
            }
        });
    });

    // Eliminar registro
    $('.btn-eliminar').on('click', function() {
        const id = $(this).data('id');
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, ¡eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `<?= site_url('catalogos/delete/') ?>${catalogType}/${id}`,
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('¡Eliminado!', response.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'No se pudo comunicar con el servidor.', 'error');
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>