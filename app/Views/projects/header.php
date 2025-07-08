<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($page_title ?? 'AdminProject') ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
<style>
    /* ==========================================================================
       1. TEMA CLARO (POR DEFECTO) - SIN CAMBIOS
       ========================================================================== */
    :root {
        --body-bg: #f4f7f6;
        --panel-bg: #ffffff;
        --sidebar-bg: #ffffff;
        --border-color: #dee2e6;
        --main-text: #212529;
        --secondary-text: #6c757d;
        --sidebar-text: #495057;
        --sidebar-header-text: #212529;
        --sidebar-hover-bg: #f8f9fa;
        --form-input-bg: #ffffff;
        --form-input-text: #212529;
        --brand-purple: #8e44ad;
        --accent-yellow: #ffc107;
    }

    /* ==========================================================================
       2. TEMA OSCURO (PALETA CORREGIDA Y COHESIVA)
       ========================================================================== */
    body.theme-dark {
        --body-bg: #1a1b26;              /* Fondo principal muy oscuro */
        --panel-bg: #242535;             /* Paneles un poco más claros */
        --sidebar-bg: #242535;
        --border-color: #41425e;         /* Bordes visibles */
        
        /* SOLUCIÓN: El texto principal DEBE ser claro en un tema oscuro */
        --main-text:rgb(60, 60, 97);             /* Texto principal (títulos, etc.) blanco-grisáceo */
        --secondary-text: #a0a0b0;       /* Texto secundario (etiquetas) más tenue */
        
        --sidebar-text: #a0a0b0;
        --sidebar-header-text: #ffffff;
        --sidebar-hover-bg: #1a1b26;
        
        /* SOLUCIÓN: Los inputs deben seguir el tema oscuro */
        --form-input-bg:rgb(255, 255, 255);         /* Fondo de inputs oscuro, igual al fondo principal */
        --form-input-text:rgb(0, 0, 0);       /* Texto de inputs claro, igual al texto principal */
        
        --brand-purple: #9b59b6;
        --accent-yellow: #f1c40f;
    }

    /* ==========================================================================
       3. ESTILOS GENERALES (SIN CAMBIOS)
       ========================================================================== */
    body { 
        background-color: var(--body-bg); 
        color: var(--main-text);
        font-family: 'Poppins', sans-serif; 
        font-size: 0.9rem; 
        transition: background-color 0.3s, color 0.3s;
    } 
    .main-container { display: flex; min-height: 100vh; } 
    .content-wrapper { flex-grow: 1; padding: 1rem; }
    
    .sidebar { width: 220px; background-color: var(--sidebar-bg); padding: 20px 0; flex-shrink: 0; border-right: 1px solid var(--border-color); }
    .sidebar-header { padding: 0 20px 20px 20px; font-weight: 600; font-size: 1.2rem; color: var(--sidebar-header-text); text-align: center; }
    .sidebar-nav a { display: flex; align-items: center; padding: 12px 20px; color: var(--sidebar-text); text-decoration: none; font-weight: 500; transition: background-color 0.2s, color 0.2s; } 
    .sidebar-nav a:hover { background-color: var(--sidebar-hover-bg); color: var(--brand-purple); }
    .sidebar-nav a.active { background-color: var(--brand-purple); color: #fff !important; border-radius: 0 30px 30px 0; margin-left: -1px; }
    .sidebar-nav a.active i, .sidebar-nav a.active:hover { color: #fff; }
    .sidebar-nav a i { margin-right: 15px; width: 20px; text-align: center; }
    
    .offcanvas { background-color: var(--sidebar-bg); }
    .main-panel, .data-panel { background-color: var(--panel-bg); color: var(--main-text); border-radius: 20px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.05); } 
    
    .panel-title, .form-legend { 
        color:  #a0a0b0;
        font-weight: 600; 
        border-bottom: 1px solid var(--border-color); 
        padding-bottom: 0.5rem; 
        margin-bottom: 1rem; 
    }
    .form-label { 
        color: var(--secondary-text) !important; 
        font-weight: 500; 
    }
    small.text-muted { 
        color: var(--secondary-text) !important; 
        opacity: 0.8; 
    }
    .form-control, .form-select { 
        background-color: var(--form-input-bg); 
        border: 1px solid var(--border-color); 
        color: var(--form-input-text); 
        border-radius: 8px; 
    }
    .form-control:focus, .form-select:focus { 
        background-color: var(--form-input-bg); 
        color: var(--form-input-text); 
        border-color: var(--brand-purple); 
        box-shadow: 0 0 0 0.25rem rgba(142, 68, 173, 0.25); 
    }
    select[multiple] {
        background-color: var(--form-input-bg) !important;
        color: var(--form-input-text) !important;
    }
</style>

</head>

<body class="<?= ($settings['default_theme'] ?? 'light') === 'dark' ? 'theme-dark' : 'theme-light' ?>">

<div class="main-container">
    <aside class="sidebar d-none d-lg-block">
        <div class="sidebar-header">AdminProject</div>
        <nav class="sidebar-nav mt-3">
            <a href="<?= site_url('dashboard') ?>" class="<?= (uri_string() == 'dashboard' || uri_string() == '/') ? 'active' : '' ?>"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('ajustes') ?>" class="<?= (strpos(uri_string(), 'ajustes') === 0) ? 'active' : '' ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </aside>

    <div class="content-wrapper">