<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminProject - Control de Tiempo</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        /* Plantilla estandarizada del dashboard oscuro */
        :root { 
            --bg-dark: #20202d; 
            --panel-bg: #2c2c3e; 
            --panel-light-bg: #4a4a6a;
            --text-light: #e0e0e0;
            --text-muted: #a0a0b0; 
            --brand-purple: #8e44ad; 
            --accent-green: #28a745;
            --accent-red: #dc3545;
            --accent-teal: #17a2b8;
        } 
        body { 
            background-color: var(--bg-dark); 
            color: var(--text-light); 
            font-family: 'Poppins', sans-serif; 
            font-size: 0.9rem; 
        } 
        .main-container { 
            display: flex; 
            min-height: 100vh; 
        } 
        .sidebar { 
            width: 220px; 
            background-color: var(--bg-dark); 
            padding: 20px 0;
            flex-shrink: 0; 
            border-right: 1px solid #333;
        }
        .sidebar-header {
            padding: 0 20px 20px 20px;
            font-weight: 600;
            font-size: 1.2rem;
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
        .panel-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        } 
        .user-profile { 
            display: flex; 
            align-items: center; 
            gap: 15px; 
        } 
        .user-profile img { 
            width: 40px; 
            height: 40px; 
            border-radius: 50%; 
        } 
        .user-info small { 
            color: var(--text-muted); 
        }

        /* --- NUEVOS ESTILOS PARA LA SECCIÓN DE TIEMPO --- */
        .activity-list .activity-header, .activity-list .activity-row {
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 1.5fr; /* 4 columnas */
            align-items: center;
            padding: 1rem 0.5rem;
            border-bottom: 1px solid var(--panel-light-bg);
        }
        .activity-list .activity-header {
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.8rem;
            text-transform: uppercase;
        }
        .activity-list .activity-row:last-child {
            border-bottom: none;
        }
        .status-badge {
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 500;
            text-align: center;
            width: fit-content; /* Para que el badge no ocupe toda la celda */
        }
        .status-activo { background-color: var(--accent-green); color: #fff; }
        .status-detenido { background-color: var(--accent-red); color: #fff; }
        
        .btn-admin-times {
            background-color: var(--brand-purple);
            color: #fff;
            border-radius: 20px;
            padding: 10px 25px;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-admin-times:hover {
            opacity: 0.9;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<div class="main-container">
    
    <aside class="sidebar d-none d-lg-block">
        <div class="sidebar-header">
            AdminProject
        </div>
        <nav class="sidebar-nav mt-3">
            <a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('recursos') ?>"><i class="fas fa-star"></i> RECURSOS</a>
            <a href="<?= site_url('tareas') ?>"><i class="fas fa-tasks"></i> TAREAS</a>
            <a href="<?= site_url('tiempos') ?>" class="active"><i class="fas fa-clock"></i> TIEMPO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
            
        </nav>
    </aside>

    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                <i class="fas fa-bars"></i>
            </button>
            <h4 class="text-center py-3 m-0 flex-grow-1">
                Control de Tiempo
            </h4>
        </div>

        <div class="main-panel">
            <!-- Cabecera del panel con perfil de usuario (estandarizada) -->
            <div class="panel-header mb-4">
                <div class="flex-grow-1">
                    <!-- Espacio en blanco donde iría el buscador del dashboard -->
                </div>
                <div class="user-profile">
                    <i class="fas fa-bell"></i>
                    <i class="fas fa-envelope"></i>
                    <img src="https://i.pravatar.cc/40?u=ricardo" alt="User Avatar">
                    <div class="user-info">
                        <strong>Ricardo Chab</strong><br>
                        <small>Administrador</small>
                    </div>
                </div>
            </div>

            <!-- INICIO DEL CONTENIDO DE LA PÁGINA DE TIEMPO -->
            <h5 class="mb-4">Actividades en curso</h5>
            <div class="activity-list">
                <div class="activity-header">
                    <div>Actividad</div>
                    <div>Prioridad</div>
                    <div>Tiempo Trabajado</div>
                    <div></div> <!-- Columna para el badge -->
                </div>
                <div class="activity-row">
                    <div>Actividad #1</div>
                    <div>Alta</div>
                    <div>04:35:12</div>
                    <div><span class="status-badge status-activo">Activo</span></div>
                </div>
                <div class="activity-row">
                    <div>Actividad #2</div>
                    <div>Alta</div>
                    <div>05:42:15</div>
                    <div><span class="status-badge status-detenido">Detenido</span></div>
                </div>
                <div class="activity-row">
                    <div>Actividad #3</div>
                    <div>Baja</div>
                    <div>01:23:04</div>
                    <div><span class="status-badge status-detenido">Detenido</span></div>
                </div>
                <div class="activity-row">
                    <div>Actividad #4</div>
                    <div>Media</div>
                    <div>03:21:15</div>
                    <div><span class="status-badge status-detenido">Detenido</span></div>
                </div>
            </div>
            <!-- FIN DEL CONTENIDO DE LA PÁGINA DE TIEMPO -->

        </div>
        
        <div class="text-center mt-4">
            <button class="btn-admin-times">
                <i class="fas fa-cog me-2"></i>Administrar Tiempos
            </button>
        </div>

    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">AdminProject</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="sidebar-nav">
            <a href="#"><i class="fas fa-home"></i> INICIO</a>
            <a href="#"><i class="fas fa-star"></i> RECURSOS</a>
            <a href="#"><i class="fas fa-tasks"></i> TAREAS</a>
            <a href="#" class="active"><i class="fas fa-clock"></i> TIEMPO</a>
            <a href="#"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>