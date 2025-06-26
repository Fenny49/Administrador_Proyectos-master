<?php

namespace App\Controllers;

class Proyectos extends BaseController
{
    /**
     * Muestra la página de detalles de un proyecto específico.
     * @param int $projectId El ID del proyecto que se va a mostrar.
     */
    public function detalles($projectId)
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        // Cargamos la configuración del tema y helpers
        $defaults = ['default_theme' => 'dark']; 
        $settings = $session->get('general_settings') ?? $defaults;
        helper('url');

        // ==========================================================
        // ===== DATOS ESTÁTICOS / DE EJEMPLO PARA LA VISTA =====
        // ==========================================================
        
        // Simula la información del proyecto principal
        $data['proyecto'] = [
            'id' => $projectId,
            'nombre' => 'Actualización del ERP Corporativo',
            'descripcion' => 'Migración completa del sistema ERP a la nueva versión en la nube, incluyendo módulos de finanzas, RH y logística. El objetivo es mejorar el rendimiento y la seguridad.',
            'estado' => 'Activo',
            'responsable' => 'Ricardo Chab Pool',
            'fecha_inicio' => '2025-02-01',
            'fecha_fin' => '2025-12-15'
        ];

        // Simula las estadísticas del proyecto
        $data['stats'] = [
            'total_tareas' => 25,
            'tareas_completadas' => 11,
            'costo_actual' => 18500.00,
            'presupuesto' => 50000.00,
        ];
        
        // Simula la lista de usuarios y grupos asignados
        $data['usuarios_asignados'] = ['Ricardo Chab', 'Ana García', 'Luis Hernández', 'Marina Escalante'];
        $data['grupos_asignados'] = ['Equipo de Desarrollo Backend', 'Equipo QA'];


        // Pasamos toda la información a las vistas
        $data['settings'] = $settings;
        $data['userData'] = $session->get('userData');

        // Construimos la página con un nuevo conjunto de vistas
        $show_page  = view('proyectos/detalles_header', $data);
        $show_page .= view('proyectos/detalles_body', $data);
        $show_page .= view('proyectos/detalles_footer', $data);
        
        return $show_page;
    }
}