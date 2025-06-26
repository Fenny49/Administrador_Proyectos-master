<body>

    <div class="container d-flex align-items-center justify-content-center main-container">
        <div class="col-11 col-md-8 col-lg-6">
            <h2 class="text-center mb-4">Crear una Cuenta</h2>

            <form action="registrar"  method="post">
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="Nombre" class="form-label">Nombre(s)<span class="required-field-indicator">*</span></label>
                        <input type="text" class="form-control" name="Nombre" required value="<?= old('Nombre') ?>">
                        <?php if(isset($validation) && $validation->hasError('Nombre')): ?>
                            <div class="error-message"><?= $validation->getError('Nombre') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="Apellido_Paterno" class="form-label">Apellido Paterno<span class="required-field-indicator">*</span></label>
                        <input type="text" class="form-control" name="Apellido_Paterno" required value="<?= old('Apellido_Paterno') ?>">
                        <?php if(isset($validation) && $validation->hasError('Apellido_Paterno')): ?>
                            <div class="error-message"><?= $validation->getError('Apellido_Paterno') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="Apellido_Materno" class="form-label">Apellido Materno<span class="required-field-indicator">*</span></label>
                        <input type="text" class="form-control" name="Apellido_Materno" required value="<?= old('Apellido_Materno') ?>">
                        <?php if(isset($validation) && $validation->hasError('Apellido_Materno')): ?>
                            <div class="error-message"><?= $validation->getError('Apellido_Materno') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- EL CAMPO DE CÓDIGO DE USUARIO HA SIDO ELIMINADO DE AQUÍ -->

                <div class="mb-3">
                    <label for="Correo" class="form-label">Correo Electrónico<span class="required-field-indicator">*</span></label>
                    <input type="email" class="form-control" name="Correo" required value="<?= old('Correo') ?>">
                    <?php if(isset($validation) && $validation->hasError('Correo')): ?>
                        <div class="error-message"><?= $validation->getError('Correo') ?></div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="Password" class="form-label">Contraseña<span class="required-field-indicator">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="Password" id="Password" required>
                            <!-- Botón para alternar la visibilidad -->
                            <button class="btn btn-password-toggle" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('Password')): ?>
                            <div class="error-message"><?= $validation->getError('Password') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="pass_confirm" class="form-label">Confirmar Contraseña<span class="required-field-indicator">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="pass_confirm" id="pass_confirm" required>
                            <!-- Botón para alternar la visibilidad -->
                            <button class="btn btn-password-toggle" type="button" id="togglePassConfirm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('pass_confirm')): ?>
                            <div class="error-message"><?= $validation->getError('pass_confirm') ?></div>
                        <?php endif; ?>
                    </div>
                </div>
               

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-register">Registrarse</button>
                </div>

            </form>

            <p class="text-center mt-3 small register-help">
                ¿Ya tienes una cuenta? <a href="<?= site_url('login') ?>">Inicia sesión aquí</a>
            </p>
        </div>
    </div>
<script>
        // Esperamos a que todo el documento HTML se cargue antes de ejecutar el script
        document.addEventListener('DOMContentLoaded', function () {

            // Función reutilizable para manejar la lógica de un botón
            function setupPasswordToggle(toggleButtonId, passwordInputId) {
                const toggleButton = document.getElementById(toggleButtonId);
                const passwordInput = document.getElementById(passwordInputId);
                const icon = toggleButton.querySelector('i');

                toggleButton.addEventListener('click', function () {
                    // Alternar el tipo de input entre 'password' y 'text'
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Alternar el icono del ojo
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }

            // Configuramos el botón para el campo de contraseña principal
            setupPasswordToggle('togglePassword', 'Password');

            // Configuramos el botón para el campo de confirmar contraseña
            setupPasswordToggle('togglePassConfirm', 'pass_confirm');

        });
    </script>

</body>