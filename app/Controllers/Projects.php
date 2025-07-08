<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\GrupoModel;
use App\Models\ProyectoModel; // Aseguramos que el modelo de Proyecto esté importado
use Config\Database;

class Projects extends BaseController
{
    /**
     * Muestra el formulario para crear un nuevo proyecto.
     * Esta función está correcta y ya incluye la lógica del tema.
     */
    public function new()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }
        
        $defaults = ['default_theme' => 'dark'];
        $settings = $session->get('general_settings') ?? $defaults;

        $usuarioModel = new UsuarioModel();
        $grupoModel = new GrupoModel();
        $anio_trabajo = $session->get('anio_trabajo') ?? date('Y');

        $data = [
            'settings'      => $settings,
            'page_title'    => 'Añadir Nuevo Proyecto',
            'usuarios'      => $usuarioModel->where('Estado', 1)->findAll(),
            'grupos'        => $grupoModel->findAll(),
            'anio_trabajo'  => $anio_trabajo
        ];

        $html_output  = view('projects/header', $data);
        $html_output .= view('projects/new', $data);
        $html_output .= view('projects/footer', $data);
        
        return $html_output;
    }

    /**
     * Recibe los datos del formulario y los guarda usando el Modelo y Transacciones.
     * (Versión restaurada sin Proceso Almacenado)
     */
    public function create()
    {
        // <-- AÑADIDO: Bloque completo de validación -->
        $validation = \Config\Services::validation();

        // Reglas de validación
        $rules = [
            'nombre_proyecto' => [
                'label' => 'Nombre del Proyecto',
                'rules' => 'required|trim|is_unique[proyectos.nombre]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'is_unique' => 'Ya existe un proyecto con este nombre. Por favor, elige otro.'
                ]
            ],
            'fecha_inicio' => [
                'label' => 'Fecha de Inicio',
                'rules' => 'required|valid_date'
            ],
            // --- ¡AQUÍ ESTÁ EL CAMBIO! ---
            'fecha_fin' => [
                'label' => 'Fecha de Fin',
                // En lugar de una cadena, la regla es una función anónima.
                'rules' => ['required', 'valid_date', function($fecha_fin) {
                    $fecha_inicio = $this->request->getPost('fecha_inicio');
                    if (empty($fecha_inicio) || empty($fecha_fin)) {
                        return true; // Si una de las fechas no está, otras reglas lo capturarán.
                    }
                    return strtotime($fecha_fin) >= strtotime($fecha_inicio);
                }],
                'errors' => [
                    // El error se muestra para la regla anónima (en la posición 2 del array de reglas).
                    '2' => 'La Fecha de Fin no puede ser anterior a la Fecha de Inicio.'
                ]
            ],
            'responsable_id' => [
                'label' => 'Responsable del Proyecto',
                'rules' => 'required',
                'errors' => ['required' => 'Debes seleccionar un {field}.']
            ],
            'usuarios' => [
                'label' => 'Usuarios del Equipo',
                'rules' => 'required',
                'errors' => ['required' => 'Debes asignar al menos un usuario al equipo.']
            ]
        ];

        if (!$this->validate($rules)) {
            // Si la validación falla, redirigimos de vuelta.
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // ... el resto de tu código para guardar en la base de datos permanece EXACTAMENTE IGUAL ...
        $db = \Config\Database::connect();
        // etc...
    }

        public function check_name()
    {
        // Solo responde a peticiones AJAX por seguridad
        if ($this->request->isAJAX()) {
            $proyectoModel = new ProyectoModel();
            $nombre = $this->request->getJSON()->nombre_proyecto;
            
            // Busca si ya existe un proyecto con ese nombre
            $existe = $proyectoModel->where('nombre', $nombre)->first();
            
            // Retorna una respuesta JSON que el script del frontend puede leer
            return $this->response->setJSON(['existe' => ($existe !== null)]);
        }
        // Si no es una petición AJAX, no se permite el acceso.
        return $this->response->setStatusCode(403, 'Forbidden');
    }
}