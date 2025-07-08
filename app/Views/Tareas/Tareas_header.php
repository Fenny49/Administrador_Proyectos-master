<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminProject - Tareas</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <style>
    /* ================================================================== */
    /* ===== DEFINICIÓN DE TEMAS DINÁMICOS (CLARO Y OSCURO) ===== */
    /* ================================================================== */

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

     .panel-bloqueado {
        opacity: 0.6;
        pointer-events: none; 

     }
      /* Para bloquear el panel de TAREA cuando se edita un criterio */
    #panel-info-tarea.panel-locked {
        opacity: 0.5;
        pointer-events: none; /* Evita clics en el panel bloqueado */
        transition: opacity 0.3s ease;
    }

    /* CAMBIO: Nueva clase para bloquear GRUPOS de campos individuales */
    .field-group-locked {
        opacity: 0.5;
        pointer-events: none; /* Bloquea la interacción con label e input */
        transition: opacity 0.3s ease;
    }

    /* Para bloquear el panel de CRITERIOS antes de guardar la tarea (modo crear) */
    #panel-agregar-criterio.form-disabled {
        opacity: 0.6;
        background-color: #f8f9fa;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
.modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1055;
    display: none;
    width: 100%;
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
    outline: 0;
}
.modal-dialog {
    position: relative;
    width: auto;
    margin: 0.5rem;
    pointer-events: none;
}
.modal.fade .modal-dialog {
    transition: transform .3s ease-out;
    transform: translate(0,-50px);
}
.modal.show .modal-dialog {
    transform: none;
}
@media (min-width: 576px) {
    .modal-dialog {
        max-width: 500px;
        margin: 1.75rem auto;
    }
}
.modal-content {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    color: var(--bs-modal-color);
    pointer-events: auto;
    background-color: var(--bs-modal-bg, #fff); /* Usa variable o un color por defecto */
    background-clip: padding-box;
    border: 1px solid var(--bs-modal-border-color, rgba(0,0,0,.2));
    border-radius: 0.5rem; /* Reemplaza var(--bs-modal-border-radius) */
    outline: 0;
}
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    width: 100vw;
    height: 100vh;
    background-color: #000;
}
.panel-locked {
        opacity: 0.5;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    .criterio-cumplido-check { transform: scale(1.5); cursor: pointer; }
.modal-backdrop.fade {
    opacity: 0;
}
.modal-backdrop.show {
    opacity: 0.5;
}
.modal-header {
    display: flex;
    flex-shrink: 0;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1rem; /* Reemplaza var(--bs-modal-header-padding) */
    border-bottom: 1px solid var(--bs-modal-header-border-color, #dee2e6);
    border-top-left-radius: calc(0.5rem - 1px);
    border-top-right-radius: calc(0.5rem - 1px);
}
.modal-title {
    margin-bottom: 0;
    line-height: 1.5; /* Reemplaza var(--bs-modal-title-line-height) */
}
.modal-body {
    position: relative;
    flex: 1 1 auto;
    padding: 1rem; /* Reemplaza var(--bs-modal-padding) */
}
.modal-footer {
    display: flex;
    flex-wrap: wrap;
    flex-shrink: 0;
    align-items: center;
    justify-content: flex-end;
    padding: 0.75rem; /* Reemplaza var(--bs-modal-footer-padding) */
    border-top: 1px solid var(--bs-modal-footer-border-color, #dee2e6);
    border-bottom-right-radius: calc(0.5rem - 1px);
    border-bottom-left-radius: calc(0.5rem - 1px);
}
.modal-footer > * {
    margin: 0.25rem;
}
.fade {
    transition: opacity .15s linear;
}
.fade:not(.show) {
    opacity: 0;
}
/* Estilos para el botón de cierre (muy importante) */
.btn-close {
    box-sizing: content-box;
    width: 1em;
    height: 1em;
    padding: .25em .25em;
    color: #000;
    background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    border: 0;
    border-radius: .375rem;
    opacity: .5;
}
.btn-close:hover {
    opacity: .75;
}
.btn-close:focus {
    outline: 0;
    box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
    opacity: 1;
}
     <!-- MODIFICADO: Añadido solo el CSS necesario para el Modal de Bootstrap -->
<style>
/* Estilos Esenciales para el Modal de Bootstrap 5.3 */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1055;
    display: none;
    width: 100%;
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
    outline: 0;
}
.modal-dialog {
    position: relative;
    width: auto;
    margin: 0.5rem;
    pointer-events: none;
}
.modal.fade .modal-dialog {
    transition: transform .3s ease-out;
    transform: translate(0,-50px);
}
.modal.show .modal-dialog {
    transform: none;
}
@media (min-width: 576px) {
    .modal-dialog {
        max-width: 500px;
        margin: 1.75rem auto;
    }
}
.modal-content {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    color: var(--bs-modal-color);
    pointer-events: auto;
    background-color: var(--bs-modal-bg, #fff); /* Usa variable o un color por defecto */
    background-clip: padding-box;
    border: 1px solid var(--bs-modal-border-color, rgba(0,0,0,.2));
    border-radius: 0.5rem; /* Reemplaza var(--bs-modal-border-radius) */
    outline: 0;
}
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    width: 100vw;
    height: 100vh;
    background-color: #000;
}
.modal-backdrop.fade {
    opacity: 0;
}
.modal-backdrop.show {
    opacity: 0.5;
}
.modal-header {
    display: flex;
    flex-shrink: 0;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1rem; /* Reemplaza var(--bs-modal-header-padding) */
    border-bottom: 1px solid var(--bs-modal-header-border-color, #dee2e6);
    border-top-left-radius: calc(0.5rem - 1px);
    border-top-right-radius: calc(0.5rem - 1px);
}
.modal-title {
    margin-bottom: 0;
    line-height: 1.5; /* Reemplaza var(--bs-modal-title-line-height) */
}
.modal-body {
    position: relative;
    flex: 1 1 auto;
    padding: 1rem; /* Reemplaza var(--bs-modal-padding) */
}
.modal-footer {
    display: flex;
    flex-wrap: wrap;
    flex-shrink: 0;
    align-items: center;
    justify-content: flex-end;
    padding: 0.75rem; /* Reemplaza var(--bs-modal-footer-padding) */
    border-top: 1px solid var(--bs-modal-footer-border-color, #dee2e6);
    border-bottom-right-radius: calc(0.5rem - 1px);
    border-bottom-left-radius: calc(0.5rem - 1px);
}
.modal-footer > * {
    margin: 0.25rem;
}
.fade {
    transition: opacity .15s linear;
}
.fade:not(.show) {
    opacity: 0;
}
/* Estilos para el botón de cierre (muy importante) */
.btn-close {
    box-sizing: content-box;
    width: 1em;
    height: 1em;
    padding: .25em .25em;
    color: #000;
    background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    border: 0;
    border-radius: .375rem;
    opacity: .5;
}
.btn-close:hover {
    opacity: .75;
}
.btn-close:focus {
    outline: 0;
    box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
    opacity: 1;
}
</style>
    </style>
</head>