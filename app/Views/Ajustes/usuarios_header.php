<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios y Grupos - AdminProject</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        /* Estilos base del layout */
        :root {
            --body-bg: #f0f2f5; --panel-bg: #ffffff; --sidebar-bg: #ffffff; 
            --sidebar-text:rgb(138, 138, 138); --sidebar-header-text: #212529; --sidebar-hover-bg: #e9ecef;
            --main-text: #212529; --secondary-text: #6c757d; --border-color: #dee2e6;
            --form-input-bg: #ffffff; --form-input-text: #212529; --brand-purple: #8e44ad;
        }
        body.theme-dark {
            --body-bg: #20202d; --panel-bg: #2c2c3e; --sidebar-bg: #2c2c3e;
            --sidebar-header-text: #ffffff; --sidebar-text: #a0a0b0; --sidebar-hover-bg: #20202d;
            --main-text: #ffffff; /* <--- LÍNEA CORREGIDA */
            --secondary-text:rgb(255, 255, 255); 
            --border-color: #4a4a6a; --form-input-bg: #4a4a6a; --form-input-text: #e0e0e0;
        }
        body.theme-dark .form-label {
            color: var(--secondary-text);
        }

        /* Estilo para la sección del filtro en modo oscuro */
        body.theme-dark .card-body {
            background-color: #ffffff;
            border-radius: 10px; /* Opcional: para redondear las esquinas */
        }

        /* Ajusta el color del texto "Filtrar por Proyecto" */
        body.theme-dark .card-body .form-label {
            color: #212529; /* Color de texto oscuro */
        }

        /* Ajusta el campo de selección para el nuevo fondo blanco */
        body.theme-dark .card-body .form-select {
            background-color: #ffffff;
            color: #212529;
            border-color: #dee2e6;
        }

        /* 1. Hace que las etiquetas (labels) sean negras y legibles */
        body.theme-dark .modal-body .form-label {
            color: #000000;
        }

        /* 2. Estilo para campos de texto (inputs) y listas (selects) dentro del modal */
        body.theme-dark .modal-body .form-control,
        body.theme-dark .modal-body .form-select {
            background-color: #ffffff; /* Fondo blanco */
            color: #000000;             /* Texto de escritura negro */
            border: 1px solid #000000;  /* Borde negro de 1px */
        }

        /* 3. Estilo para el título del modal */
        body.theme-dark .modal-title {
            color: #000000; /* Título del modal en negro */
        }

        body { background-color: var(--body-bg); color: var(--main-text); font-family: 'Poppins', sans-serif; font-size: 0.9rem; } 
        .main-container { display: flex; min-height: 100vh; } 
        .content-wrapper { flex-grow: 1; padding: 1.5rem; }

        /* Sidebar */
        .sidebar { width: 220px; background-color: var(--sidebar-bg); padding: 20px 0; flex-shrink: 0; border-right: 1px solid var(--border-color); }
        .sidebar-header { padding: 0 20px 20px 20px; font-weight: 600; font-size: 1.2rem; color: var(--sidebar-header-text); text-align: center; }
        .sidebar-nav a { display: flex; align-items: center; padding: 12px 20px; color: var(--sidebar-text); text-decoration: none; font-weight: 500; } 
        .sidebar-nav a:hover { background-color: var(--sidebar-hover-bg); }
        .sidebar-nav a.active { background-color: var(--brand-purple); color: #fff !important; }
        .sidebar-nav a i { margin-right: 15px; width: 20px; text-align: center; }
        
        /* Paneles y Formularios */
        .data-panel { background-color: var(--panel-bg); color: var(--main-text); border-radius: 15px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.05); } 
        .panel-title { color: var(--main-text); font-weight: 600; }
        .form-control, .form-select { background-color: var(--form-input-bg); border: 1px solid var(--border-color); color: var(--form-input-text); border-radius: 8px; }
        .table-light-theme { color: var(--main-text); }
        .table-light-theme thead { border-bottom: 2px solid var(--border-color); }
        .table-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; }
        .color-blanco {color:white};
    </style>
</head>