<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* --- Estilos Personalizados para replicar el diseño --- */
        body {
            background-color: #2a43a8;
            color: #fff;
            overflow-x: hidden; /* Evita scroll horizontal por las formas */
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
        }
        .form-control-custom {
            background-color: transparent;
            border: 1px solid #fff;
            color: #fff;
            padding-left: 2.5rem;
        }
        .form-control-custom::placeholder { color: rgba(255, 255, 255, 0.7); }
        .form-control-custom:focus {
            background-color: transparent;
            color: #fff;
            border-color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
        }
        .input-group-custom { position: relative; }
        .input-group-custom .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 70%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }
        .btn-login {
            background-color: #fff;
            color: #2a43a8;
            font-weight: bold;
            padding: 0.75rem;
        }
        .btn-login:hover {
            background-color: #e9ecef;
            color: #2a43a8;
        }
        .login-help a {
            color: #fff;
            text-decoration: none;
        }
        .login-help a:hover { color: #ddd; }
        .captcha-refresh-icon {
            color: #fff;
            text-decoration: none;
            background-color: #3e5fde; /* Un azul un poco más claro para el botón de refrescar */
            border: 1px solid #fff;
            border-left: 0;
        }
        .captcha-refresh-icon:hover {
            background-color: #5472e3;
        }
         .btn-password-toggle {
            position: absolute;
            right: 0;
            top: 33;
            height: 50%;
            z-index: 5; /* Para que esté sobre el input */
            border: 2px solid #fff;
            border-left: 0;
            background-color: transparent;
            color: #fff;
        }
        .btn-password-toggle:hover, .btn-password-toggle:focus {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            box-shadow: none;
        }
        /* Ajuste para que el input no se solape con el botón */
        .input-with-toggle {
            padding-right: 40px; 
        }
    </style>
</head>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>