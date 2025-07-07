<?= $this->extend('layouts/main') ?> 

<?= $this->section('content') ?>

<div class="main-panel">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="m-0">Tareas del Proyecto</h4>
            <small class="text-muted">Aquí puedes ver y editar las tareas existentes.</small>
        </div>
        <a href="<?= site_url('tareas/index/' . $id_proyecto) ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Crear Nueva Tarea
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Tarea</th>
                    <th>Estado</th>
                    <th>Fecha Fin</th>
                    <th>Días Restantes</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tareas)): ?>
                    <?php foreach ($tareas as $tarea): ?>
                        <tr>
                            <td><?= esc($tarea['TAR_ID']) ?></td>
                            <td><?= esc($tarea['TAR_NOM']) ?></td>
                            <td>
                    <?php
                    $estado = esc($tarea['estado_calculado']);
                    $badgeClass = 'bg-secondary'; // Default
                    if ($estado === 'Atrasado') $badgeClass = 'bg-danger';
                    if ($estado === 'Completado') $badgeClass = 'bg-success';
                    if ($estado === 'En Progreso') $badgeClass = 'bg-info';
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= $estado ?></span>
                </td>
                            <td>
                                <!-- Formatea la fecha para ser más legible -->
                                <?= esc($tarea['TAR_FECHAFIN'] ? date('d/m/Y', strtotime($tarea['TAR_FECHAFIN'])) : 'N/A') ?>
                            </td>

                             <td>
                    <?php
                    $dias = $tarea['dias_restantes'];
                    if ($dias === null) {
                        echo 'N/A';
                    } elseif ($dias < 0) {
                        echo '<span class="text-danger fw-bold">' . abs($dias) . ' días de retraso</span>';
                    } elseif ($dias == 0) {
                        echo '<span class="text-warning fw-bold">Vence hoy</span>';
                    } else {
                        echo $dias . ' días';
                    }
                    ?>
                </td>
                            <td class="text-center">
                                <!-- Botón para Editar -->
                                <a href="<?= site_url('tareas/editar/' . $tarea['TAR_ID']) ?>" class="btn btn-sm btn-warning" title="Editar Tarea">
                                    <i class="fas fa-pencil-alt"></i> Editar
                                </a>
                                
                                <!-- Botón para Eliminar Tarea -->
                                <button type="button" class="btn btn-sm btn-danger btn-eliminar-tarea" 
                                        data-tarea-id="<?= esc($tarea['TAR_ID']) ?>" 
                                        title="Eliminar Tarea">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Mensaje amigable si no hay tareas -->
                    <tr>
                        <td colspan="5" class="text-center text-muted p-4">
                            No hay tareas para este proyecto todavía. ¡Crea la primera!
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- JAVASCRIPT ESPECÍFICO PARA ESTA PÁGINA -->
<script>
    const BASE_URL = "<?= site_url() ?>";

    document.addEventListener('click', function(event) {
        // Busca si el clic fue en un botón para eliminar tarea
        const btnEliminarTarea = event.target.closest('.btn-eliminar-tarea');

        if (btnEliminarTarea) {
            event.preventDefault();

            if (confirm('¿Estás SEGURO de que quieres eliminar esta tarea? Esta acción es irreversible y también borrará todos sus criterios.')) {
                
                const tareaId = btnEliminarTarea.dataset.tareaId;

                // Deshabilita el botón para evitar clics múltiples
                btnEliminarTarea.disabled = true;
                btnEliminarTarea.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Eliminando...';

                fetch(`${BASE_URL}tareas/ajax_eliminar_tarea`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ tarea_id: tareaId })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        // Muestra el mensaje de éxito y recarga la página para ver los cambios
                        alert(result.message);
                        window.location.reload(); 
                    } else {
                        // Muestra el error y restaura el botón
                        alert('Error: ' + result.message);
                        btnEliminarTarea.disabled = false;
                        btnEliminarTarea.innerHTML = '<i class="fas fa-trash"></i> Eliminar';
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar tarea:', error);
                    alert('Ocurrió un error de comunicación.');
                    btnEliminarTarea.disabled = false;
                    btnEliminarTarea.innerHTML = '<i class="fas fa-trash"></i> Eliminar';
                });
            }
        }
    });
</script>

<?= $this->endSection() ?>