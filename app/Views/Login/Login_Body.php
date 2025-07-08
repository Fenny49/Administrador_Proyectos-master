<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="container d-flex align-items-center justify-content-center main-container">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">
            
            <div class="text-center mb-4">
                <img src="assets/images/bluelogo.png" alt="Icono Login" style="width: 100px;">
            </div>

            <!-- Mensajes de Error / Éxito -->
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= site_url('ingresar') ?>" method="post">
                
                <!-- Campo Usuario -->
                <div class="input-group-custom mb-3">
                    <label for="correo" class="form-label">Usuario</label>
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control form-control-custom" id="correo" name="correo" placeholder="USUARIO" required>
                </div>

                <!-- Campo Contraseña -->
                <div class="input-group-custom mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <i class="fas fa-lock input-icon"></i>
                    <!-- Añadimos una clase extra para el padding -->
                    <input type="password" class="form-control form-control-custom input-with-toggle" id="password" name="password" placeholder="********" required>
                    <!-- Botón para alternar la visibilidad -->
                    <button class="btn btn-password-toggle" type="button" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <!-- ================================== -->
                <!-- INICIO DEL BLOQUE DEL CAPTCHA      -->
                <!-- ================================== -->
                <div class="mb-4">
                    <label for="captcha" class="form-label">Escribe el texto de la imagen</label>
                    <div class="input-group">
                        <img src="login/captcha" alt="Captcha Image" class="rounded-start" style="border: 1px solid #fff; border-right: 0;">
                        <a href="javascript:void(0);" onclick="this.previousElementSibling.src='<?= site_url('login/captcha') ?>?' + new Date().getTime()" class="input-group-text captcha-refresh-icon">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                    <input type="text" class="form-control form-control-custom mt-2" id="captcha" name="captcha" required autocomplete="off" style="padding-left: 0.75rem;">
                </div>
                <!-- ================================== -->
                <!-- FIN DEL BLOQUE DEL CAPTCHA         -->
                <!-- ================================== -->

                <!-- Botón de Login -->
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-login">LOGIN</button>
                </div>

            </form>

            <div class="text-center login-help">
                <p class="small">
                    <!-- ================================== -->
                    <!-- ENLACE A LA PÁGINA DE REGISTRO     -->
                    <!-- ================================== -->
                    ¿No tienes cuenta? <a href="<?= site_url('registro') ?>">Regístrate aquí</a>
                </p>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const icon = togglePassword.querySelector('i');

            togglePassword.addEventListener('click', function () {
                // Alternar el tipo de input
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                // Alternar el icono
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>