<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* --- Estilos Personalizados para replicar el diseño del login --- */

        body {
            background-color: #2a43a8; /* Color azul principal */
            color: #fff; /* Texto blanco para que contraste */
            overflow: hidden; /* Evita scrollbars causados por las formas */
            position: relative;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        /* Formas decorativas del fondo (exactamente las mismas que en el login) */
        body::before, body::after {
            content: '';
            position: absolute;
            background-color: rgba(206, 212, 218, 0.2); /* Color gris-azulado claro con transparencia */
            border-radius: 50%;
            z-index: 0; /* Detrás del contenido */
        }

        /* Círculo grande a la izquierda */
        body::before {
            width: 50vw;
            height: 50vw;
            max-width: 500px;
            max-height: 500px;
            bottom: -15%;
            left: -15%;
            border-radius: 45% 55% 60% 40% / 40% 45% 55% 60%;
        }

        /* Forma a la derecha */
        body::after {
            width: 35vw;
            height: 35vw;
            max-width: 350px;
            max-height: 350px;
            top: -10%;
            right: -10%;
            border-radius: 50% 50% 45% 55% / 50% 40% 60% 50%;
        }

        /* Contenedor principal para centrar todo */
        .error-container {
            min-height: 100vh;
            position: relative; /* Para que el contenido esté sobre las formas */
            z-index: 1;
        }

        /* Estilo para el botón de regreso */
        .btn-return {
            background-color: #fff;
            color: #2a43a8;
            font-weight: bold;
            padding: 0.75rem 1.5rem;
            border-radius: 50rem; /* Botón tipo píldora */
        }
        .btn-return:hover {
            background-color: #e9ecef;
            color: #2a43a8;
        }

    </style>
</head>
<body>

    <div class="container d-flex align-items-center justify-content-center error-container">
        <div class="text-center">
            
            <!-- 1. Logo de la empresa -->
            <!-- Usamos un filtro de CSS para que el logo se vea blanco y combine mejor -->
            <img src="<?= base_url('assets/images/bluelogo.png') ?>" alt="Logo de la Empresa" class="mb-4">

            <h1 class="display-1 fw-bold">404</h1>
            <p class="fs-3">Página no encontrada</p>
            <p class="lead fw-light">
                La página que estás buscando no existe o ha sido movida.
            </p>
            
            <!-- 2. Botón de regreso al login -->
            <a href="<?= site_url('/login') ?>" class="btn btn-return mt-4">Regresar al Login</a>

        </div>
    </div>

</body>
</html>