<?php

namespace App\Controllers;

class Tiempos extends BaseController
{
    public function index()
    {
        $session = session();
        
        // 1. Proteger la página, si no hay sesión, redirigir al login.
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        // 2. Obtener datos del usuario de la sesión para la cabecera.
        $userData = [
            'id'     => $session->get('id_usuario'),
            'nombre' => $session->get('nombre_completo'),
            'rol'    => $session->get('rol')
        ];
        
        // 3. Simular datos de actividades (en un futuro, esto vendría de un modelo).
        $actividades = [
            [
                'actividad' => 'Actividad #1', 
                'prioridad' => 'Alta', 
                'tiempo'    => '04:35:12', 
                'status'    => 'activo' // Usamos minúsculas para que coincida con las clases CSS
            ],
            [
                'actividad' => 'Actividad #2', 
                'prioridad' => 'Alta', 
                'tiempo'    => '05:42:15', 
                'status'    => 'detenido'
            ],
            [
                'actividad' => 'Actividad #3', 
                'prioridad' => 'Baja', 
                'tiempo'    => '01:23:04', 
                'status'    => 'detenido'
            ],
            [
                'actividad' => 'Actividad #4', 
                'prioridad' => 'Media', 
                'tiempo'    => '03:21:15', 
                'status'    => 'detenido'
            ],
        ];

        // 4. Preparar todos los datos para pasar a la vista.
        $data = [
            'userData'    => $userData,
            'actividades' => $actividades,
            'activePage'  => 'tiempo' // Para resaltar el enlace correcto en el menú
        ];

        // 5. Cargar la vista, pasándole todos los datos.
        return view('Tiempos/tiempos.php', $data);
    }
}