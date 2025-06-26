
<body>
    <div class="card shadow selection-card">
        <div class="card-body">
            <h3 class="card-title text-center mb-3">¡Bienvenido, <?= esc($nombre) ?>!</h3>
            <p class="text-center text-muted mb-4">Por favor, selecciona el periodo que deseas consultar.</p>

            <form action="<?= site_url('dashboard') ?>" method="post">
                <?= csrf_field() ?> <!-- Protección CSRF -->

                <div class="mb-4">
                    <label for="anio" class="form-label fs-5">Año del Periodo</label>
                    <select class="form-select form-select-lg" id="anio" name="anio" required>
                        <?php 
                            // Generamos opciones desde el año actual hasta 2020
                            $currentYear = date('Y');
                            for ($i = $currentYear; $i >= 2020; $i--): 
                        ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Iniciar</button>
                </div>
            </form>
        </div>
    </div>
</body>
