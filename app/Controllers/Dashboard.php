<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProyectoModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $defaults = ['default_theme' => 'dark']; // Tema por defecto
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

        // ===== AÑADIDO: Lógica para leer el tema guardado =====
        $defaults = ['default_theme' => 'dark']; // Tema por defecto
        $settings = $session->get('general_settings') ?? $defaults;

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

    //Código para el CSV 
     public function export_csv()
{
    $session = session();
    
    // 1. Proteger la ruta (sin cambios)
    if (!$session->get('is_logged_in')) {
        return redirect()->to('/login');
    }

    $selectedYear = $this->request->getGet('anio');
    if (!$selectedYear) {
        return redirect()->to('/dashboard')->with('error', 'Debe seleccionar un periodo para exportar.');
    }

    // 2. Obtener los datos (sin cambios)
    $proyectoModel = new ProyectoModel();
    $userRole = $session->get('rol');
    $userId = $session->get('id_usuario');
    $query = $proyectoModel->where('anio', $selectedYear);
    if ($userRole === 'administrador') {
        $proyectos = $query->findAll();
    } else {
        $proyectos = $query->where('id_usuario_asignado', $userId)->findAll();
    }

    // 3. Construir el contenido del CSV como una cadena de texto
    $filename = 'proyectos_' . $selectedYear . '.csv';
    
    // Añadimos el BOM para la compatibilidad con acentos en Excel
    $csvData = "\xEF\xBB\xBF";
    
    // Definimos las cabeceras
    $headers = ['ID Proyecto', 'Nombre', 'Prioridad', 'Descripción', 'Fecha Inicio', 'Fecha Fin', 'Status'];
    
    // Añadimos la fila de cabeceras a nuestra cadena, usando punto y coma
    $csvData .= implode(';', $headers) . "\n";

    // Recorremos los datos y añadimos cada fila a la cadena
    foreach ($proyectos as $project) {
        $row = [
            $project['id_proyecto'],
            $project['nombre'],
            $project['prioridad'],
            // Importante: Remplazar saltos de línea y comillas en la descripción para no romper el CSV
            str_replace('"', '""', $project['descripcion']), 
            $project['fecha_inicio'],
            $project['fecha_fin'],
            $project['status']
        ];
        $csvData .= implode(';', $row) . "\n";
    }

    // 4. Usar el método de descarga de CodeIgniter
    // Esto se encarga de todos los encabezados HTTP y de enviar los datos de forma segura.
    // No necesitamos usar header(), fopen(), fputcsv(), ni exit() manualmente.
    return $this->response->download($filename, $csvData);
}

}