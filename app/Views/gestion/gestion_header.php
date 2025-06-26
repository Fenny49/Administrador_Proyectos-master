<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión | AdminProject</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        /* Define las variables para el Tema Claro (por defecto) */
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
            --brand-purple: #8e44ad; 
            --accent-green: #28a745; 
            --accent-teal: #17a2b8;
            --accent-yellow: #ffc107; 
            --accent-red: #dc3545; 
        }

        /* Sobreescribe las variables solo si el body tiene la clase 'theme-dark' */
        body.theme-dark {
            --body-bg: #20202d;
            --panel-bg: #2c2c3e;
            --sidebar-bg: #2c2c3e;
            --sidebar-header-text: #ffffff;
            --sidebar-text: #a0a0b0;
            --sidebar-hover-bg: #20202d;
            --main-text2:rgb(129, 129, 129);
            --main-text:rgb(187, 187, 187);
            --secondary-text: #a0a0b0;
            --border-color: #4a4a6a;
        }

        /* --- Estilos Generales que usan las variables --- */
        body { background-color: var(--body-bg); color: var(--main-text2); font-family: 'Poppins', sans-serif; font-size: 0.9rem; } 
        .main-container { display: flex; min-height: 100vh; } 
        .content-wrapper { flex-grow: 1; padding: 1rem; }
        
        /* Sidebar */
        .sidebar { width: 220px; background-color: var(--sidebar-bg); padding: 20px 0; flex-shrink: 0; border-right: 1px solid var(--border-color); }
        .sidebar-header { color: var(--sidebar-header-text); /* ...y otros estilos... */ }
        .sidebar-nav a { color: var(--sidebar-text); /* ...y otros estilos... */ } 
        .sidebar-nav a:hover { background-color: var(--sidebar-hover-bg); color: var(--brand-purple); }
        .sidebar-nav a.active { background-color: var(--brand-purple); color: #fff !important; } 
        .sidebar-nav a.active i, .sidebar-nav a.active:hover { color: #fff; }
        
        /* Contenido y Paneles */
        .offcanvas { background-color: var(--sidebar-bg); }
        .main-panel { background-color: var(--panel-bg); color: var(--main-text); border-radius: 20px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.05); } 
        
        /* Tablas */
        .project-table { color: var(--main-text); }
        .project-table thead th { color: var(--secondary-text); text-transform: uppercase; font-size: 0.8em; }
        .project-table th, .project-table td { border-bottom: 1px solid var(--border-color); }
        .project-table tbody tr:last-child td { border-bottom: 0; }
        .table-actions a { color: var(--secondary-text); }

        /* Estilos específicos que ya tenías */
        .sidebar-header { padding: 0 20px 20px 20px; font-weight: 600; font-size: 1.2rem; text-align: center; }
        .sidebar-nav a { display: flex; align-items: center; padding: 12px 20px; text-decoration: none; font-weight: 500; } 
        .sidebar-nav a.active { border-radius: 0 30px 30px 0; margin-left: -1px; } 
        .sidebar-nav a i { margin-right: 15px; width: 20px; text-align: center; } 
        .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; } 
        .btn-custom { border-radius: 8px; padding: 8px 15px; font-weight: 500; border: none; } 
        .btn-add { background-color: var(--accent-teal); color: #fff; }
        .project-table thead th { font-weight: 600; padding: 15px; }
        .project-table tbody td { padding: 15px; vertical-align: middle; }
    </style>
</head>