<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Proyectos</title>
    
    <!-- Assets de CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
                /* Estilos base (sin cambios) */
        :root {
            --body-bg: #f0f2f5;
            --panel-bg: #ffffff;
            --sidebar-bg: #ffffff; 
            --sidebar-text: #495057;
            --sidebar-header-text: #212529;
            --sidebar-hover-bg: #e9ecef;
            --main-text: #212529; 
            --secondary-text: #6c757d;
            --border-color: #dee2e6;
            --form-input-bg: #ffffff;
            --form-input-text: #212529;
            --form-label:  #212529;
            
            /* Variables de acento comunes */
            --brand-purple: #8e44ad; 
            --accent-green: #28a745; 
            --accent-teal: #17a2b8;
            --accent-yellow: #ffc107; 
            --accent-red: #dc3545; 
        }

        /* Sobreescribe las variables solo si el body tiene la clase 'theme-dark' */
        /* Estas son las variables de TU tema oscuro original */
        body.theme-dark {
            --body-bg: #20202d;
            --panel-bg: #2c2c3e;
            --sidebar-bg: #20202d; /* Usamos el más oscuro para el sidebar */
            --sidebar-header-text: #ffffff;
            --sidebar-text: #a0a0b0;
            --sidebar-hover-bg: #2c2c3e;
            --main-text: #e0e0e0; 
            --secondary-text: #a0a0b0; 
            --border-color: #4a4a6a;
            --form-input-bg: #4a4a6a;
            --form-input-text: #e0e0e0;
        }

        /*body { background-color: var(--bg-dark); color: var(--text-light); font-family: 'Poppins', sans-serif; font-size: 0.9rem; } 
        .main-container { display: flex; min-height: 100vh; } */

        /* --- Estilos Generales que usan las variables --- */
        body { background-color: var(--body-bg); color: var(--main-text); font-family: 'Poppins', sans-serif; font-size: 0.9rem; } 
        .main-container { display: flex; min-height: 100vh; } 
        
        
        .sidebar { width: 220px; background-color: var(--bg-dark); padding: 20px 0; flex-shrink: 0; border-right: 1px solid #333; }
        .sidebar-nav a { display: flex; align-items: center; padding: 12px 20px; color: var(--text-muted); text-decoration: none; transition: all 0.3s ease; font-weight: 500; } 
        .sidebar-nav a:hover, .sidebar-nav a.active { background-color: var(--brand-purple); color: #fff; border-radius: 0 30px 30px 0; margin-left: -1px; } 
        .sidebar-nav a i { margin-right: 15px; width: 20px; text-align: center; } 
        .offcanvas { background-color: var(--bg-dark); }
        .content-wrapper { flex-grow: 1; padding: 1rem; } 
        .main-panel { background-color: var(--panel-bg); border-radius: 20px; padding: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.2); } 
        .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; } 
        .search-bar { background-color: #e9ecef; border: none; border-radius: 20px; padding: 10px 20px; } 
        .user-profile { display: flex; align-items: center; gap: 15px; } .user-profile i { color: var(--text-muted); font-size: 1.2rem; } .user-profile img { width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--brand-purple); } .user-info small { color: var(--text-muted); } .actions-bar { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; } .btn-custom { border-radius: 8px; padding: 8px 15px; font-weight: 500; border: none; } .btn-add { background-color: var(--accent-teal); color: #fff; } 
        
        /* CAMBIO 1: Ajustes en el estilo de la tabla */
        .project-table {
            color: black;
            border-collapse: collapse; /* Usamos bordes colapsados */
            width: 100%;
        }
        .project-table thead th {
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8em;
            padding: 15px;
        }
        .project-table tbody td {
            padding: 15px;
            vertical-align: middle;
        }
        /* Añadimos una línea inferior a todas las celdas para separarlas */
        .project-table th, .project-table td {
            border-bottom: 1px solid var(--panel-light-bg);
        }
        /* Quitamos el borde de la última fila para un look más limpio */
        .project-table tbody tr:last-child td {
            border-bottom: 0;
        }
        
        .badge-priority { padding: 6px 15px; border-radius: 20px; color: #fff; font-weight: 500; min-width: 90px; text-align: center; } .badge-normal { background-color: var(--accent-green); } .badge-media { background-color: var(--accent-yellow); color: #333; } .badge-alta { background-color: var(--accent-red); } .badge-activo { background-color: var(--accent-green); } .badge-pendiente { background-color: var(--accent-teal); } .badge-atrasado { background-color: var(--accent-red); } .table-actions a { color: var(--text-muted); font-size: 1.2rem; margin: 0 5px; }
        .pagination { justify-content: center; margin-top: 20px; } 
        .pagination .page-item .page-link { background-color: var(--panel-light-bg); border: none; color: var(--text-light); margin: 0 3px; border-radius: 5px; } 
        .pagination .page-item.active .page-link { background-color: var(--brand-purple); } 
        .pagination .page-item.disabled .page-link { background-color: #3a3a4a; color: #6c757d; }

     

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
         .offcanvas-body, .offcanvas-title { color:rgb(203, 210, 216); }
        .main-panel, .data-panel { background-color: var(--panel-bg); border-radius: 20px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.05); } 
        .colorBlack {color: black};
        .colorBlue (color:rgb(0, 0, 121));
    </style>



</head>