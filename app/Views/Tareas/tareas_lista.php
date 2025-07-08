


    <?= $this->extend('layouts/main') ?> 

    <?= $this->section('content') ?>

    <div class="main-panel">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="fs-5 fw-bold text-primary">
                    Proyecto: <?= esc($proyecto['nombre'] ?? 'Desconocido') ?>
                </small>
                <h4 class="m-0">Tareas del Proyecto</h4>
                <small>Aquí puedes ver, filtrar y editar las tareas existentes.</small>
            </div>
            <a href="<?= site_url('tareas/crear/' . $id_proyecto) ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Crear Nueva Tarea
            </a>
        </div>

        <div class="table-responsive">
            <table id="tabla-tareas" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Tarea</th>
                        <th>Estado</th>
                        <th>Fecha Fin</th>
                        <th>Días Restantes</th>
                        <th>Criterios de aceptación</th>
                        <th class="text-center no-sort">Acciones</th>
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
                                    // --- LÓGICA PARA EL BADGE DE ESTADO (ANTES EN EL HELPER) ---
                                    $estado = $tarea['estado_calculado'];
                                    $badgeClass = 'bg-secondary'; // Clase por defecto

                                    switch ($estado) {
                                        case 'Atrasado':
                                            $badgeClass = 'bg-danger';
                                            break;
                                        case 'Completado':
                                            $badgeClass = 'bg-success';
                                            break;
                                        case 'En Progreso':
                                            $badgeClass = 'bg-info';
                                            break;
                                        case 'Pendiente':
                                            $badgeClass = 'bg-warning text-dark';
                                            break;
                                        case 'En Espera':
                                            $badgeClass = 'bg-primary';
                                            break;
                                    }
                                    echo '<span class="badge ' . $badgeClass . '">' . esc($estado ?? 'N/A') . '</span>';
                                    ?>
                                </td>
                                <td>
                                    <?= esc($tarea['TAR_FECHAFIN'] ? date('d/m/Y', strtotime($tarea['TAR_FECHAFIN'])) : 'N/A') ?>
                                </td>
                                <td>
                                    <?php
                                    // --- LÓGICA PARA LOS DÍAS RESTANTES (ANTES EN EL HELPER) ---
                                    $dias = $tarea['dias_restantes'];

                                    if ($dias === null) {
                                        echo '<span class="text-muted">N/A</span>';
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
                        <span class="badge bg-light text-dark rounded-pill">
                            <?= esc($tarea['numero_criterios']) ?>
                        </span>
                    </td>
                                <td class="text-center">
                                    <a href="<?= site_url('tareas/editar/' . $tarea['TAR_ID']) ?>" class="btn btn-sm btn-warning" title="Editar Tarea">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger btn-eliminar-tarea" 
                                            data-tarea-id="<?= esc($tarea['TAR_ID']) ?>" 
                                            title="Eliminar Tarea">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                
            </table>
        </div>
    </div>

    <!-- El JAVASCRIPT para DataTables y la eliminación AJAX permanece igual -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

        <!-- 2. LUEGO, LOS PLUGINS DE JQUERY (COMO DATATABLES) -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        
        <!-- OTROS PLUGINS QUE DEPENDEN DE JQUERY (Ej. Bootstrap JS si lo usas) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.x.x/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script >
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- LÓGICA DE DATATABLES ---
            var table = $('#tabla-tareas').DataTable({
                "order": [], 
                "orderCellsTop": true,
                "fixedHeader": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
                    paginate: {
            "next": '<span class="custom-next">Next</span>',
            "previous": '<span class="custom-prev">Previous</span>'
            }

                },
                "columnDefs": [
                    { "orderable": false, "targets": 'no-sort' }
                ]
                
            });

        $('#tabla-tareas thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();
            if ($(this).hasClass('no-sort')) {
                $(this).html('');
                return;
            }

            // Si es la columna de Estado (índice 2), crea un <select>
            if (table.column(i).header().textContent === 'Estado') { 
                var select = $('<select class="form-select form-select-sm"><option value="">Todos</option></select>');
                
                // Los estados "calculados" que pueden aparecer en la tabla
                const estadosCalculados = ['Atrasado', 'Completado', 'En Progreso', 'Pendiente', 'En Espera'];
                estadosCalculados.forEach(function(estado) {
                    select.append('<option value="' + estado + '">' + estado + '</option>');
                });
                
                $(this).html(select);

                $('select', this).on('change', function() {
                    // Usamos una expresión regular para buscar la palabra exacta
                    if (this.value) {
                        table.column(i).search('^' + this.value + '$', true, false).draw();
                    } else {
                        table.column(i).search('').draw();
                    }
                });
            } else {
                // Para las demás columnas (incluyendo "Fecha Fin" y "Días Restantes"), crea un <input> normal
                $(this).html('<input type="text" class="form-control form-control-sm" placeholder="Buscar..." />');
                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table.column(i).search(this.value).draw();
                    }
                });
            }
        });


        // --- LÓGICA DE ELIMINACIÓN ---
        
        $('#tabla-tareas tbody').on('click', '.btn-eliminar-tarea', function() {
        // 'this' ahora se refiere directamente al botón en el que se hizo clic
        const deleteButton = $(this); 
        const tareaId = deleteButton.data('tarea-id'); // jQuery obtiene los atributos data-* con .data()

        // Usaremos SweetAlert2 para una mejor UX , o el confirm() normal
        if (confirm('¿Estás seguro de que quieres eliminar esta tarea?')) {
            fetch('<?= site_url('tareas/ajax_eliminar_tarea') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ tarea_id: tareaId })
            })
            .then(response => response.json())
            .then(result => {
                // Usoalert() para la notificación
                alert(result.message); 

                if (result.status === 'success') {
                    // Obtenemos la instancia de la tabla DataTables que ya definimos arriba
                    // y usamos su API para eliminar la fila.
                    table.row(deleteButton.closest('tr')).remove().draw();
                }
            })
            .catch(error => {
                console.error('Error en la llamada AJAX:', error);
                alert('Ocurrió un error al intentar eliminar la tarea. Revisa la consola.');
            });
        }
        });
    });
    </script>

    <?= $this->endSection() ?>
