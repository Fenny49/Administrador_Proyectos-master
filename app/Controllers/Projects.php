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
        // Conectamos a la base de datos para poder usar transacciones
        $db = Database::connect();
        $proyectoModel = new ProyectoModel();

        // 1. Recoger los datos del formulario
        $proyectoData = [
            'nombre'              => $this->request->getPost('nombre_proyecto'),
            'descripcion'         => $this->request->getPost('descripcion'),
            'prioridad'           => $this->request->getPost('prioridad'),
            'id_usuario_asignado' => $this->request->getPost('responsable_id'),
            'fecha_inicio'        => $this->request->getPost('fecha_inicio'),
            'fecha_fin'           => $this->request->getPost('fecha_fin'),
            'status'              => 'Activo', // El estado es 'Activo' por defecto
            'anio'                => date('Y', strtotime($this->request->getPost('fecha_inicio')))
        ];

        // Recogemos los arrays de usuarios y grupos asignados
        $usuariosAsignados = $this->request->getPost('usuarios') ?? [];
        $gruposAsignados = $this->request->getPost('grupos') ?? [];

        // 2. Iniciar una transacción para garantizar la integridad de los datos
        $db->transStart();

        // 2.1. Insertar el proyecto principal usando el Modelo
        $proyectoModel->insert($proyectoData);

        // 2.2. Obtener el ID del proyecto que acabamos de crear
        $newProjectId = $proyectoModel->getInsertID();

        // 2.3. Preparar y guardar las asignaciones en la tabla DET_GRUPOS
        $asignaciones = [];
        if (!empty($usuariosAsignados) && !empty($gruposAsignados)) {
            foreach ($usuariosAsignados as $userId) {
                foreach ($gruposAsignados as $groupId) {
                    $asignaciones[] = [
                        'PROY_ID' => $newProjectId,
                        'USU_ID'  => $userId,
                        'GPO_ID'  => $groupId
                    ];
                }
            }
        }
        
        // Si hay asignaciones, las insertamos en un solo lote
        if (!empty($asignaciones)) {
            $db->table('dbo.DET_GRUPOS')->insertBatch($asignaciones);
        }

        // 3. Finalizar la transacción
        $db->transComplete();

        // 4. Redireccionar con un mensaje de éxito o error
        if ($db->transStatus() === false) {
            // La transacción falló
            session()->setFlashdata('error', 'No se pudo crear el proyecto. La transacción falló.');
        } else {
            // La transacción fue exitosa
            session()->setFlashdata('success', '¡Proyecto creado y equipo asignado con éxito!');
        }

        return redirect()->to(base_url('/dashboard'));
    }
}
