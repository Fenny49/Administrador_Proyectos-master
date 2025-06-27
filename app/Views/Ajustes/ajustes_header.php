<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajustes del Sistema</title>
    
    <!-- CSS (Exactamente el mismo que el del dashboard) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
    /* ================================================================== */
        /* ===== DEFINICIÓN DE TEMAS DINÁMICOS (CLARO Y OSCURO) ===== */
        /* ================================================================== */
        
        /* Define las variables para el Tema Claro (por defecto) */
        :root {
            --body-bg: #f0f2f5;
            --panel-bg: #ffffff;
            --sidebar-bg: #ffffff; 
            --sidebar-text:rgb(0, 0, 0);
            --sidebar-header-text: #212529;
            --sidebar-hover-bg: #e9ecef;
            --main-text: #212529; /* Texto principal oscuro para fondos claros */
            --secondary-text:rgb(0, 0, 0);
            --border-color: #dee2e6;
            --form-input-bg: #ffffff;
            --form-input-text: #212529;
            --table-light-bg: #ffffff;
            --table-light-text: #212529;
            --brand-purple: #8e44ad; 
            --accent-yellow: #ffc107;
        }

        /* Sobreescribe las variables solo si el body tiene la clase 'theme-dark' */
        body.theme-dark {
            --body-bg: #20202d;
            --panel-bg: #2c2c3e;
            --sidebar-bg: #2c2c3e;
            --sidebar-header-text: #ffffff;
            --sidebar-text: #a0a0b0;
            --sidebar-hover-bg: #20202d;
            --main-text: #e0e0e0; 
            --secondary-text: #a0a0b0;
            --border-color: #4a4a6a;
            --form-input-bg: #4a4a6a;
            --form-input-text: #e0e0e0;
        }
        /* --- Estilos Generales que usan las variables --- */
        body { 
            background-color: var(--body-bg); 
            color: var(--main-text); 
            font-family: 'Poppins', sans-serif; 
            font-size: 0.9rem; 
        } 
        .main-container { display: flex; min-height: 100vh; } 
        .content-wrapper { flex-grow: 1; padding: 1rem; }
        
        /* Sidebar */
        .sidebar { width: 220px; background-color: var(--sidebar-bg); padding: 20px 0; flex-shrink: 0; border-right: 1px solid var(--border-color); }
        .sidebar-header { padding: 0 20px 20px 20px; font-weight: 600; font-size: 1.2rem; color: var(--sidebar-header-text); text-align: center; }
        .sidebar-nav a { display: flex; align-items: center; padding: 12px 20px; color: var(--text-muted); text-decoration: none; transition: all 0.3s ease; font-weight: 500; } 
        .sidebar-nav a:hover, .sidebar-nav a.active { background-color: var(--brand-purple); color: #fff; border-radius: 0 30px 30px 0; margin-left: -1px; } 
        .sidebar-nav a.active { background-color: var(--brand-purple); color: #fff !important; border-radius: 0 30px 30px 0; margin-left: -1px; }
        .sidebar-nav a.active i, .sidebar-nav a.active:hover { color: #fff; }
        .sidebar-nav a i { margin-right: 15px; width: 20px; text-align: center; }
        
        .badge-priority { padding: 6px 15px; border-radius: 20px; color: #fff; font-weight: 500; min-width: 90px; text-align: center; } .badge-normal { background-color: var(--accent-green); } .badge-media { background-color: var(--accent-yellow); color: #333; } .badge-alta { background-color: var(--accent-red); } .badge-activo { background-color: var(--accent-green); } .badge-pendiente { background-color: var(--accent-teal); } .badge-atrasado { background-color: var(--accent-red); } .table-actions a { color: var(--text-muted); font-size: 1.2rem; margin: 0 5px; }
        .pagination { justify-content: center; margin-top: 20px; } 
        .pagination .page-item .page-link { background-color: var(--panel-light-bg); border: none; color: var(--text-light); margin: 0 3px; border-radius: 5px; } 
        .pagination .page-item.active .page-link { background-color: var(--brand-purple); } 
        .pagination .page-item.disabled .page-link { background-color: #3a3a4a; color: #6c757d; }

        /* Contenido y Formularios */
        .offcanvas { background-color: var(--sidebar-bg); }
        .main-panel, .data-panel { background-color: var(--panel-bg); border-radius: 20px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.05); } 
        .form-legend { font-weight: 500; color: var(--main-text); margin-bottom: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem; }
        .form-label, small.text-muted { color:rgb(233, 81, 81) !important; }
        .form-control, .form-select { background-color: var(--form-input-bg); border: 1px solid var(--border-color); color: var(--form-input-text); border-radius: 8px; }
        .form-control:focus, .form-select:focus { background-color: var(--form-input-bg); color: var(--form-input-text); border-color: var(--brand-purple); box-shadow: 0 0 0 0.25rem rgba(142, 68, 173, 0.25); }
        .settings-card { display: flex; flex-direction: column; justify-content: center; align-items: center; background-color: #fff; color: #333; border-radius: 15px; padding: 2rem; text-decoration: none; transition: all 0.3s ease; height: 100%; border: 1px solid #eee; }
        .settings-card:hover { transform: translateY(-8px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); color: var(--brand-purple); }
        .settings-card .icon { font-size: 3.5rem; margin-bottom: 1rem; line-height: 1; }
        .settings-card .title { font-weight: 500; font-size: 1.1rem; }
       /* Las etiquetas principales ahora usan el color de texto principal del tema */
        .form-label {
            color: var(--main-text) !important; 
        }

        /* El texto pequeño y secundario mantiene el color de texto secundario */
        small.text-muted {
            color: var(--secondary-text) !important;
        }
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 600;
            color: #FFFFFF;
            text-transform: uppercase;
        }

    </style>
</head>