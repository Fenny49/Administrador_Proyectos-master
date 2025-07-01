<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\GrupoModel;
use Config\Database;

class Projects extends BaseController
{
    /**
     * Muestra el formulario para crear un nuevo proyecto.
     * Esta función no cambia.
     */
    public function new()
    {
       // --- 1. OBTENER DATOS DE SESIÓN Y TEMA (LA PARTE AÑADIDA) ---
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }
        
        // Carga la configuración del tema, usando 'dark' como predeterminado si no existe
        $defaults = ['default_theme' => 'dark'];
        $settings = $session->get('general_settings') ?? $defaults;

        $usuarioModel = new UsuarioModel();
        $grupoModel = new GrupoModel();
        $anio_trabajo = session()->get('anio_trabajo') ?? date('Y');

        $data = [
            'settings'      => $settings, 
            'page_title'    => 'Añadir Nuevo Proyecto',
            'usuarios'      => $usuarioModel->where('Estado', 1)->findAll(),
            'grupos'        => $grupoModel->findAll(),
            'anio_trabajo'  => $anio_trabajo
        ];

        // Carga el header en una variable
        $html_output  = view('projects/header', $data);
        
        // Carga el contenido del body y lo añade a la variable
        $html_output .= view('projects/new', $data);
        
        // Carga el footer y lo añade al final
        $html_output .= view('projects/footer', $data);
        
        // Devuelve el string HTML completo al navegador
        return $html_output;
    }

    /**
     * Recibe los datos del formulario y llama al proceso almacenado para crear el proyecto.
     */
    public function create()
    {
        // 1. Recoger los datos del formulario (esto no cambia)
        $nombre_proyecto = $this->request->getPost('nombre_proyecto');
        $descripcion = $this->request->getPost('descripcion');
        $prioridad = $this->request->getPost('prioridad');
        $responsable_id = $this->request->getPost('responsable_id');
        $fecha_inicio = $this->request->getPost('fecha_inicio');
        $fecha_fin = $this->request->getPost('fecha_fin');
        
        // 2. Convertir los arrays de IDs en strings separadas por comas
        $usuariosAsignados = $this->request->getPost('usuarios') ?? [];
        $gruposAsignados = $this->request->getPost('grupos') ?? [];
        
        $usuariosIDsString = implode(',', $usuariosAsignados);
        $gruposIDsString = implode(',', $gruposAsignados);

        try {
            // 3. Preparar la llamada al Proceso Almacenado
            $db = Database::connect();
            $sql = "EXEC dbo.sp_CrearProyectoCompleto @nombre=?, @descripcion=?, @prioridad=?, @id_usuario_asignado=?, @fecha_inicio=?, @fecha_fin=?, @UsuariosIDs=?, @GruposIDs=?";

            // 4. Ejecutar el Proceso Almacenado con los parámetros
            $db->query($sql, [
                $nombre_proyecto,
                $descripcion,
                $prioridad,
                $responsable_id,
                $fecha_inicio,
                $fecha_fin,
                $usuariosIDsString,
                $gruposIDsString
            ]);

            // Si la ejecución fue exitosa (no hubo excepciones), mostrar mensaje de éxito
            session()->setFlashdata('success', '¡Proyecto creado con éxito mediante Proceso Almacenado!');

        } catch (\Exception $e) {
            // Si el proceso almacenado falla y lanza un error, lo capturamos aquí
            log_message('error', '[ERROR SP] ' . $e->getMessage()); // Opcional: guardar el error en los logs
            session()->setFlashdata('error', 'No se pudo crear el proyecto. Error de base de datos.');
        }

        // 5. Redireccionar al usuario al panel principal
        return redirect()->to(base_url('/dashboard'));
    }
}