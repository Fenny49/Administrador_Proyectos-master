<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* --- Estilos Personalizados (Copiados del Login para consistencia) --- */
        body {
            background-color: #2a43a8;
            color: #fff;
            overflow-x: hidden;
            position: relative;
        }
        body::before, body::after {
            content: '';
            position: absolute;
            background-color: rgba(206, 212, 218, 0.2);
            border-radius: 50%;
            z-index: 0;
        }
        body::before {
            width: 50vw; height: 50vw; max-width: 500px; max-height: 500px;
            bottom: -15%; left: -15%;
            border-radius: 45% 55% 60% 40% / 40% 45% 55% 60%;
        }
        body::after {
            width: 35vw; height: 35vw; max-width: 350px; max-height: 350px;
            top: -10%; right: -10%;
            border-radius: 50% 50% 45% 55% / 50% 40% 60% 50%;
        }
        .main-container {
            min-height: 100vh;
            position: relative;
            z-index: 1;
            padding: 40px 0; /* Añadimos padding para que no se corte en móviles */
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid #fff;
            color: #fff;
        }
        .form-control::placeholder { color: rgba(255, 255, 255, 0.7); }
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            border-color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
        }
        .btn-register {
            background-color: #fff;
            color: #2a43a8;
            font-weight: bold;
            padding: 0.75rem;
        }
        .register-help a {
            color: #fff;
        }
        .error-message {
            color: #ffc4c4;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
           .btn-password-toggle {
            border-color: #fff;
            color: #fff;
            background-color: transparent;
        }
        .btn-password-toggle:hover, .btn-password-toggle:focus {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            border-color: #fff;
            box-shadow: none;
    </style>
</head>