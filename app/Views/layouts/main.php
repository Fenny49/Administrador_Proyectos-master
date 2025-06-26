<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | AdminProject</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        /* --- CORRECCIÓN DE COLORES Y ESTANDARIZACIÓN --- */
        :root { 
            --bg-dark: #20202d; 
            --panel-bg: #2c2c3e; 
            --panel-light-bg: #4a4a6a; /* Corregido al color que usamos en la tabla */
            --text-light: #e0e0e0; /* CORREGIDO: El texto debe ser claro en un tema oscuro */
            --text-muted: #a0a0b0; 
            --accent-green: #28a745; 
            --accent-teal: #17a2b8; 
            --accent-yellow: #ffc107; 
            --accent-red: #dc3545; 
            --brand-purple: #8e44ad; 
        } 
        body { 
            background-color: var(--bg-dark); 
            color: var(--text-light); /* Ahora el color por defecto es claro */
            font-family: 'Poppins', sans-serif; 
            font-size: 0.9rem; 
        } 
        .main-container { 
            display: flex; 
            min-height: 100vh; 
        } 
        /* --- BARRA LATERAL ESTANDARIZADA --- */
        .sidebar { 
            width: 220px; /* Ancho estándar del dashboard */
            background-color: var(--bg-dark); 
            padding: 20px 0;
            flex-shrink: 0; 
            border-right: 1px solid #333;
        }
        .sidebar-header {
            padding: 0 20px 20px 20px;
            font-weight: 600;
            font-size: 1.2rem; /* Tamaño de fuente más consistente */
            color: #fff;
            text-align: center;
        }
        .sidebar-nav a { 
            display: flex; 
            align-items: center; 
            padding: 12px 20px; 
            color: var(--text-muted); 
            text-decoration: none; 
            transition: all 0.2s ease; 
            font-weight: 500; 
        } 
        /* Estilo de "píldora" estandarizado */
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background-color: var(--brand-purple);
            color: #fff;
            border-radius: 0 30px 30px 0;
            margin-left: -1px;
        }
        .sidebar-nav a i { 
            margin-right: 15px; 
            width: 20px; 
            text-align: center; 
        }
        /* --- RESPONSIVIDAD REINCORPORADA --- */
        .offcanvas {
            background-color: var(--bg-dark);
        }
        .content-wrapper { 
            flex-grow: 1; 
            padding: 1rem; 
        } 
        .main-panel { 
            background-color: var(--panel-bg); 
            border-radius: 20px; 
            padding: 1.5rem; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
        } 
        /* Estilos de formulario corregidos para el tema oscuro */
        .form-legend {
            font-size: 1.1rem;
            font-weight: 500;
            color: #fff; /* Usamos blanco para que se lea bien */
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--panel-light-bg);
            padding-bottom: 0.5rem;
        }
        .form-control, .form-select {
            background-color: var(--panel-light-bg);
            border: 1px solid #555;
            color: var(--text-light);
            border-radius: 8px;
        }
        .form-control:focus, .form-select:focus {
            background-color: var(--panel-light-bg);
            color: var(--text-light);
            border-color: var(--brand-purple);
            box-shadow: 0 0 0 0.25rem rgba(142, 68, 173, 0.25);
        }
        /* Pequeño ajuste para que los placeholders se vean en el tema oscuro */
        .form-control::placeholder {
            color: var(--text-muted);
            opacity: 0.7;
        }
    </style>
</head>
<body>

<div class="main-container">
    
    <!-- Sidebar para pantallas grandes (estándar) -->
    <aside class="sidebar d-none d-lg-block">
        <div class="sidebar-header">
            AdminProject
        </div>
        <nav class="sidebar-nav mt-3">
            <a href="<?= site_url('dashboard') ?>" ><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('recursos') ?>"><i class="fas fa-star"></i> RECURSOS</a>
            <a href="<?= site_url('tareas') ?>"><i class="fas fa-tasks"></i> TAREAS</a>
            <a href="<?= site_url('tiempos') ?>"><i class="fas fa-clock"></i> TIEMPO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </aside>

    <!-- Contenido Principal -->
    <div class="content-wrapper">
        <!-- Cabecera con título dinámico y botón de menú móvil -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                <i class="fas fa-bars"></i>
            </button>
            <h4 class="text-center py-3 m-0 flex-grow-1">
                <?= $this->renderSection('page_title') ?>
            </h4>
        </div>

        <!-- El contenido específico de cada página se insertará aquí -->
        <?= $this->renderSection('content') ?>
    </div>
</div>

<!-- Offcanvas Sidebar para pantallas pequeñas (REINCORPORADO) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">AdminProject</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="sidebar-nav">
           <a href="<?= site_url('dashboard') ?>" class="active"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('recursos') ?>"><i class="fas fa-star"></i> RECURSOS</a>
            <a href="<?= site_url('tareas') ?>"><i class="fas fa-tasks"></i> TAREAS</a>
            <a href="#"><i class="fas fa-clock"></i> TIEMPO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Sección para scripts JS específicos de cada página -->
<?= $this->renderSection('scripts') ?>

</body>
</html>