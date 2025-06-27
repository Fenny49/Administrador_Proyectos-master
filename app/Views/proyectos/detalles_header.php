<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminProject</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        
        /* Define las variables para el Tema Claro */
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
            --main-text:rgb(255, 255, 255); 
            --secondary-text: #a0a0b0; 
            --border-color: #4a4a6a;
            --form-input-bg: #4a4a6a;
            --form-input-text: #e0e0e0;
        }

        /* --- Estilos Generales que usan las variables --- */
        body { background-color: var(--body-bg); color: var(--main-text); font-family: 'Poppins', sans-serif; font-size: 0.9rem; } 
        .main-container { display: flex; min-height: 100vh; } 
        .content-wrapper { flex-grow: 1; padding: 1rem; }
        
        /* Sidebar */
        .sidebar { width: 220px; background-color: var(--sidebar-bg); padding: 20px 0; flex-shrink: 0; border-right: 1px solid var(--border-color); }
        .sidebar-header { padding: 0 20px 20px 20px; font-weight: 600; font-size: 1.2rem; color: var(--sidebar-header-text); text-align: center; }
        .sidebar-nav a { display: flex; align-items: center; padding: 12px 20px; color: var(--sidebar-text); text-decoration: none; font-weight: 500; } 
        .sidebar-nav a:hover { background-color: var(--sidebar-hover-bg); color: var(--brand-purple); }
        .sidebar-nav a.active { background-color: var(--brand-purple); color: #fff !important; border-radius: 0 30px 30px 0; margin-left: -1px; }
        .sidebar-nav a.active i, .sidebar-nav a.active:hover { color: #fff; }
        .sidebar-nav a i { margin-right: 15px; width: 20px; text-align: center; }
        
        /* Contenido, Paneles y Formularios */
        .offcanvas { background-color: var(--sidebar-bg); }
        .main-panel, .data-panel { background-color: var(--panel-bg); color: var(--main-text); border-radius: 20px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.05); } 
        .form-label, small.text-muted { color: var(--secondary-text) !important; }
        .form-control, .form-select { background-color: var(--form-input-bg); border: 1px solid var(--border-color); color: var(--form-input-text); border-radius: 8px; }
        .form-control:focus, .form-select:focus { background-color: var(--form-input-bg); color: var(--form-input-text); border-color: var(--brand-purple); box-shadow: 0 0 0 0.25rem rgba(142, 68, 173, 0.25); }
        
        /* Estilos para Modales (Ventanas Emergentes) */
        body.theme-dark .modal-content { background-color: var(--panel-bg); color: var(--main-text); }
        body.theme-dark .modal-header { border-bottom-color: var(--border-color); }
        body.theme-dark .modal-footer { border-top-color: var(--border-color); }
        body.theme-dark .btn-close { filter: invert(1) grayscale(100) brightness(200%); }
        body.theme-dark .modal-body .form-label { color: var(--main-text) !important; }

    </style>
</head>