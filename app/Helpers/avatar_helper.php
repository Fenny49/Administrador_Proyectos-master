<?php
// app/Helpers/avatar_helper.php

if (!function_exists('user_avatar')) {
    /**
     * Genera un avatar circular con la inicial de un nombre y un color de fondo.
     *
     * @param string $name El nombre completo del usuario.
     * @return string El HTML completo del avatar.
     */
    function user_avatar(string $name): string
    {
        // Obtiene la primera letra del nombre, o '?' si está vacío.
        $initial = mb_substr($name, 0, 1, 'UTF-8') ?: '?';
        $initial = strtoupper($initial);

        // Lista de colores de fondo predefinidos y bonitos.
        $colors = [
            '#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#34495e',
            '#f1c40f', '#e67e22', '#e74c3c', '#7f8c8d', '#2c3e50'
        ];

        // Asigna un color basado en el valor numérico del nombre.
        // Esto asegura que el mismo nombre siempre tenga el mismo color.
        $colorIndex = ord($name[0] ?? 'A') % count($colors);
        $backgroundColor = $colors[$colorIndex];

        // Genera el HTML del avatar.
        // Usamos un estilo en línea para el color de fondo, ya que es dinámico.
        return '<div class="avatar-circle" style="background-color: ' . $backgroundColor . ';">'
             . '<span>' . esc($initial) . '</span>'
             . '</div>';
    }
}