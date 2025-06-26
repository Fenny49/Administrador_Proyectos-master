<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProyectoModel;

class Dashboard extends BaseController
{
    /**
     * Muestra la página para seleccionar el año.
     */
    public function selectYear()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        // ===== AÑADIDO: Lógica para leer el tema guardado =====
        $defaults = ['default_theme' => 'light']; // Tema por defecto
        $settings = $session->get('general_settings') ?? $defaults;

        // Añadimos los settings a los datos que se pasan a la vista
        $data = [
            'nombre'   => $session->get('nombre_completo'),
            'settings' => $settings, // La pieza que faltaba
            'userData' => $session->get('userData') // Pasamos también userData por consistencia
        ];
        
        $show_year=view('select_year_view/select_year_view_header.php', $data);
        $show_year.=view('select_year_view/select_year_view_body.php', $data);
        $show_year.=view('select_year_view/select_year_view_footer.php', $data);
        return $show_year;
    }

    /**
     * Muestra el dashboard principal.
     */
    public function index()
    {
        $session = session();

        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        $yearFromRequest = $this->request->getVar('anio');
        if ($yearFromRequest) {
            $selectedYear = $yearFromRequest;
            $session->set('selected_year', $selectedYear);
        } else {
            $selectedYear = $session->get('selected_year');
        }

        if (!$selectedYear) {
            return redirect()->to('/select-year');
        }
        
        $userData = [
            'id'     => $session->get('id_usuario'),
            'nombre' => $session->get('nombre_completo'),
            'rol'    => $session->get('rol')
        ];

        $proyectoModel = new ProyectoModel();
        $query = $proyectoModel->where('anio', $selectedYear);

        if ($userData['rol'] === 'administrador') {
            $proyectos = $query->findAll();
        } else {
            $proyectos = $query->where('id_usuario_asignado', $userData['id'])->findAll();
        }
        
        // ===== AÑADIDO: Lógica para leer el tema guardado =====
        $defaults = ['default_theme' => 'light']; // Tema por defecto
        $settings = $session->get('general_settings') ?? $defaults;
        
        // Unificamos todos los datos que la vista necesita
        $data = [
            'userData'     => $userData,
            'proyectos'    => $proyectos,
            'selectedYear' => $selectedYear,
            'settings'     => $settings // La pieza que faltaba
        ];
        
        $show_dashboard=view('dashboard/dashboard_header.php', $data);
        $show_dashboard.=view('dashboard/dashboard_body.php', $data);
        $show_dashboard.=view('dashboard/dashboard_footer.php', $data);
        return $show_dashboard;
    }
}