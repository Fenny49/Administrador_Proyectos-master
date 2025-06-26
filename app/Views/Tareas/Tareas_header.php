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
        /* Estilos CSS estandarizados, copiados de la plantilla principal */
        :root { 
            --bg-dark: #20202d; 
            --panel-bg: #2c2c3e; 
            --panel-light-bg: #4a4a6a;
            --text-light: #e0e0e0;
            --text-muted: #a0a0b0; 
            --brand-purple: #8e44ad; 
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
        .task-table {
            color: var(--text-light);
            border-collapse: collapse;
            width: 100%;
        }
        .task-table th, .task-table td {
            border-bottom: 1px solid var(--panel-light-bg);
            padding: 15px;
            vertical-align: middle;
        }
        .task-table tbody tr:last-child td {
            border-bottom: 0;
        }
        .btn-add { 
            background-color: var(--accent-teal); 
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
        .status-completada { background-color: #28a745; color: #fff; }
        .status-en-progreso { background-color: #ffc107; color: #212529; }
        .status-pendiente { background-color: #dc3545; color: #fff; }
    </style>
</head>