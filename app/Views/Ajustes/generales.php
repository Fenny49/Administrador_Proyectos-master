<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="data-panel">
    <div class="panel-header" style="display: flex; align-items: center; gap: 1rem;">
        <a href="<?= site_url('ajustes') ?>" class="btn btn-light" title="Volver a Ajustes">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="mb-0">Configuraciones Generales</h2>
    </div>

    <?php if (session()->getFlashdata('success_message')): ?>
        <div class="alert alert-success mt-4" role="alert">
            <?= session()->getFlashdata('success_message') ?>
        </div>
    <?php endif; ?>

    <?= form_open('ajustes/generales/guardar') ?>

        <div class="row mt-4">

            <div class="col-md-6">
                <div class="mb-4">
                    <label for="active_users" class="form-label">Usuarios Activos</label>
                    <select name="active_users" id="active_users" class="form-select">
                        <option value="all" <?= ($settings['active_users'] ?? 'all') == 'all' ? 'selected' : '' ?>>Todos los Usuarios Activos</option>
                        <option value="admins" <?= ($settings['active_users'] ?? '') == 'admins' ? 'selected' : '' ?>>Solo Administradores</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <label class="form-label mb-0">Añadir Nuevo Proyecto</label>
                        <small class="d-block text-muted">Permitir que se añadan nuevos agentes.</small>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="allow_new_projects" value="1" <?= ($settings['allow_new_projects'] ?? 0) == '1' ? 'checked' : '' ?>>
                    </div>
                </div>

                 <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <label class="form-label mb-0">Notificaciones</label>
                        <small class="d-block text-muted">Permitir notificaciones del sistema.</small>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="allow_notifications" value="1" <?= ($settings['allow_notifications'] ?? 0) == '1' ? 'checked' : '' ?>>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <label class="form-label mb-0">Avatar de Usuarios</label>
                        <small class="d-block text-muted">Mostrar avatar de los usuarios.</small>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="show_user_avatar" value="1" <?= ($settings['show_user_avatar'] ?? 0) == '1' ? 'checked' : '' ?>>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <label class="form-label mb-0">Feedback de Usuarios</label>
                        <small class="d-block text-muted">Permitir a los usuarios dar feedback.</small>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="feedback_from_users" value="1" <?= ($settings['feedback_from_users'] ?? 0) == '1' ? 'checked' : '' ?>>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="default_theme" class="form-label">Tema por Defecto para Usuarios</label>
                    <select name="default_theme" id="default_theme" class="form-select">
                        <option value="dark" <?= ($settings['default_theme'] ?? 'light') == 'dark' ? 'selected' : '' ?>>Tema Oscuro</option>
                        <option value="light" <?= ($settings['default_theme'] ?? 'light') == 'light' ? 'selected' : '' ?>>Tema Claro</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="text-center mt-4 border-top pt-4" style="border-color: var(--sidebar-hover-bg) !important;">
            <button type="submit" class="btn btn-primary px-5">Guardar Cambios</button>
        </div>

    <?= form_close() ?>
</div>
<?= $this->endSection() ?>