<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminProject - Tareas</title>
    
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
        --sidebar-text: rgb(0, 0, 0);
        --sidebar-header-text: #212529;
        --main-text: #212529;
        --secondary-text: #6c757d; /* Color gris estándar para texto secundario */
        --border-color: #dee2e6;
        --brand-purple: #8e44ad; 
        --accent-yellow: #ffc107;
        /* Añadimos variables para los estados para que también puedan cambiar */
        --status-success-bg: #28a745;
        --status-success-text: #ffffff;
        --status-warning-bg: #ffc107;
        --status-warning-text: #212529;
        --status-danger-bg: #dc3545;
        --status-danger-text: #ffffff;
    }

    /* Sobreescribe las variables solo si el body tiene la clase 'theme-dark' */
    body.theme-dark {
        --body-bg: #20202d;
        --panel-bg: #2c2c3e;
        --sidebar-bg: #2c2c3e;
        --sidebar-header-text: #ffffff;
        --sidebar-text: #a0a0b0;
        --main-text: #e0e0e0; 
        --secondary-text: #a0a0b0;
        --border-color: #4a4a6a;
        /* Los colores de estado pueden seguir iguales o los puedes ajustar */
        /* Por ejemplo, hacer el amarillo un poco menos brillante en modo oscuro */
        --status-warning-bg: #e0ac00;
    } 

    /* --- Estilos Generales (CORREGIDOS) --- */
    body { 
        /* CORRECCIÓN: Usamos las variables correctas */
        background-color: var(--body-bg); 
        color: var(--main-text); 
        font-family: 'Poppins', sans-serif; 
        font-size: 0.9rem; 
    } 
    .main-container { display: flex; min-height: 100vh; } 
    .content-wrapper { flex-grow: 1; padding: 1rem; }

    /* --- Sidebar (CORREGIDO) --- */
    .sidebar { 
        width: 220px; 
        /* CORRECCIÓN: Usamos las variables correctas */
        background-color: var(--sidebar-bg); 
        border-right: 1px solid var(--border-color);
        padding: 20px 0;
        flex-shrink: 0; 
    }
    .sidebar-header {
        padding: 0 20px 20px 20px;
        font-weight: 600;
        font-size: 1.2rem;
        /* CORRECCIÓN: Usamos variable para el texto del header */
        color: var(--sidebar-header-text);
        text-align: center;
    }
    .sidebar-nav a { 
        display: flex; 
        align-items: center; 
        padding: 12px 20px; 
        /* CORRECCIÓN: Usamos la variable de texto de la barra lateral */
        color: var(--sidebar-text); 
        text-decoration: none; 
        transition: all 0.2s ease; 
        font-weight: 500; 
    } 
    .sidebar-nav a:hover, .sidebar-nav a.active {
        background-color: var(--brand-purple);
        color: #fff; /* El blanco aquí está bien sobre el fondo morado */
        border-radius: 0 30px 30px 0;
        margin-left: -1px;
    }
    .sidebar-nav a i { margin-right: 15px; width: 20px; text-align: center; }

    /* --- Paneles y Contenido (CORREGIDO) --- */
    .offcanvas {
        /* CORRECCIÓN: Usamos la variable correcta */
        background-color: var(--sidebar-bg);
    }
    .main-panel { 
        background-color: var(--panel-bg); 
        border-radius: 20px; 
        padding: 1.5rem; 
        box-shadow: 0 5px 15px rgba(0,0,0,0.05); /* Sombra sutil que funciona en ambos temas */
    } 
    .panel-header { display: flex; justify-content: space-between; align-items: center; } 
    .user-profile { display: flex; align-items: center; gap: 15px; } 
    .user-profile img { width: 40px; height: 40px; border-radius: 50%; } 
    .user-info small { 
        /* CORRECCIÓN: Usamos la variable para texto secundario */
        color: var(--secondary-text); 
    }

    /* --- Tabla (CORREGIDO) --- */
    .task-table {
        /* CORRECCIÓN: Hereda el color del body, no es necesario declararlo */
        border-collapse: collapse;
        width: 100%;
    }
    .task-table th, .task-table td {
        /* CORRECCIÓN: Usamos la variable de borde */
        border-bottom: 1px solid var(--border-color);
        padding: 15px;
        vertical-align: middle;
    }
    .task-table tbody tr:last-child td {
        border-bottom: 0;
    }

    /* --- Botones e insignias (CORREGIDO) --- */
    .btn-add { 
        /* NOTA: --accent-teal no estaba definido, lo cambié por --brand-purple */
        background-color: var(--brand-purple); 
        color: #fff; 
        border-radius: 8px;
        padding: 8px 15px;
        font-weight: 500;
        border: none;
    }
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.8rem;
    }
    /* CORRECCIÓN: Usamos variables para los estados */
    .status-completada { background-color: var(--status-success-bg); color: var(--status-success-text); }
    .status-en-progreso { background-color: var(--status-warning-bg); color: var(--status-warning-text); }
    .status-pendiente { background-color: var(--status-danger-bg); color: var(--status-danger-text); }
    </style>
</head>