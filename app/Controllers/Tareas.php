<?php

namespace App\Controllers;

class Tareas extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        $defaults = ['default_theme' => 'light']; 
        $settings = $session->get('general_settings') ?? $defaults;
        helper(['url', 'form']);

        $session_tasks = $session->get('project_tasks') ?? [];
        $default_tasks = [
            ['nombre' => 'Diseñar la interfaz de usuario del módulo de ventas', 'asignado_a' => 'Ana Pérez', 'fecha_limite' => '2025-08-30', 'estado' => 'En Progreso'],
            ['nombre' => 'Desarrollar la lógica de negocio del backend', 'asignado_a' => 'Lucas Gonzalez', 'fecha_limite' => '2025-09-15', 'estado' => 'Completada'],
        ];
        
        $tasks = array_merge($session_tasks, $default_tasks);

        $data = [
            'settings'     => $settings,
            'userData'     => $session->get('userData'),
            'nombreProyecto' => 'Actualización ERP 2025',
            'tasks'        => $tasks
        ];
        
        $show_page  = view('Tareas/tareas_header', $data);
        $show_page .= view('Tareas/tareas_body', $data);
        $show_page .= view('Tareas/tareas_footer', $data);
        return $show_page;
    }

    /**
     * Procesa los datos del nuevo formulario detallado.
     */
    public function crear()
    {
        $session = session();
        
        // ===== MODIFICACIÓN: Recogemos todos los nuevos campos del formulario =====
        $newTask = [
            'nombre'       => $this->request->getPost('nombre_tarea'),
            'descripcion'  => $this->request->getPost('descripcion'),
            'solicitante'  => $this->request->getPost('puesto_solicitante'),
            'fecha_registro' => $this->request->getPost('fecha_registro'),
            'urgencia'     => $this->request->getPost('nivel_urgencia'),
            'complejidad'  => $this->request->getPost('nivel_complejidad'),
            'seguimiento'  => $this->request->getPost('notas_seguimiento'),
            'pruebas'      => $this->request->getPost('bitacora_pruebas'),
            // Asignamos valores por defecto para los campos de la tabla principal
            'asignado_a'   => '(Sin Asignar)', // Lo puedes cambiar por un campo del form si quieres
            'fecha_limite' => $this->request->getPost('fecha_registro'), // Usamos la fecha de registro como límite inicial
            'estado'       => 'Pendiente' // Todas las tareas nuevas empiezan como pendientes
        ];

        $tasks = $session->get('project_tasks') ?? [];
        array_unshift($tasks, $newTask);
        $session->set('project_tasks', $tasks);

        return redirect()->to('/tareas');
    }
}