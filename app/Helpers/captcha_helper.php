<?php

// app/Helpers/captcha_helper.php

function create_captcha()
{
    // 1. Generar una cadena aleatoria para el Captcha
    $word = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);

    // 2. Guardar la palabra en la sesión para poder validarla después
    session()->set('captcha_word', $word);

    // 3. Configuración de la imagen
    $image_width = 150;
    $image_height = 50;
    $font_path = WRITEPATH . 'fonts/arial.ttf'; // ¡IMPORTANTE! Debes tener un archivo de fuente aquí.
    $font_size = 20;

    // 4. Crear la imagen
    $image = imagecreatetruecolor($image_width, $image_height);
    $bg_color = imagecolorallocate($image, 255, 255, 255); // Fondo blanco
    $text_color = imagecolorallocate($image, 0, 0, 0);     // Texto negro
    $noise_color = imagecolorallocate($image, 180, 180, 180); // Ruido gris

    imagefill($image, 0, 0, $bg_color);

    // 5. Añadir ruido (líneas) para dificultar la lectura por bots
    for ($i = 0; $i < 5; $i++) {
        imageline($image, 0, rand() % $image_height, $image_width, rand() % $image_height, $noise_color);
    }

    // 6. Añadir el texto del Captcha a la imagen
    // Centrar el texto más o menos
    $textbox = imagettfbbox($font_size, 0, $font_path, $word);
    $x = ($image_width - $textbox[4]) / 2;
    $y = ($image_height - $textbox[5]) / 2;
    imagettftext($image, $font_size, 0, $x, $y, $text_color, $font_path, $word);

    // 7. Enviar la imagen al navegador
    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);
}