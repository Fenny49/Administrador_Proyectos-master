<?php


namespace App\Controllers;
use App\Models\TareaModel;
use App\Models\UsuarioModel;
use App\Models\ProyectoModel;
use App\Models\CriterioModel;
use App\Models\EstatusModel;

class Tareas extends BaseController
{
    public function index($id_proyecto)
    {

        $usuarioModel = new UsuarioModel();
        $proyectoModel = new ProyectoModel();
        $proyecto = $proyectoModel->find($id_proyecto); 

        $listaUsuarios = $usuarioModel->obtenerUsuariosParaDropdown(); 

        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

     if (!$proyecto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("El proyecto con ID $id_proyecto no fue encontrado.");
        }

        // 4. PREPARAMOS LOS DATOS PARA LA VISTA
        $defaults = ['default_theme' => 'dark']; 
        $settings = $session->get('general_settings') ?? $defaults;
        helper(['url', 'form']);
        
        // Puntos de esfuerzo tipo SCRUM (Fibonacci modificado)
        $puntosScrum = [1, 2, 3, 5, 8, 13, 21, 34, 55, 89];

        $data = [
            'settings'     => $settings,
            'userData'     => $session->get('userData'),
            'proyecto'     => $proyecto,        // <-- Objeto del proyecto (es un array)
            'listaUsuarios' => $listaUsuarios,  // <-- Array de usuarios
            'puntosScrum'  => $puntosScrum,      // <-- Array de puntos para el combobox
            'id_proyecto'  => $id_proyecto,
        ];
        
        $show_page  = view('Tareas/tareas_header', $data);
        $show_page .= view('Tareas/tareas_body', $data);
        $show_page .= view('Tareas/tareas_footer', $data);
        return $show_page;
    }

    /**
     * Procesa los datos del nuevo formulario detallado.
     */
   public function ajax_gestionar_tarea_criterio()
{
    if (!$this->request->isAJAX()) {
        return $this->response->setStatusCode(403, 'Forbidden');
    }

    // --- REFINAMIENTO DE VALIDACIÓN ---
    // Hacemos que el criterio sea opcional si solo se quiere guardar la tarea.
    $criterioDesc = $this->request->getPost('criterio_desc');
    $validationRules = ['tar_nom' => 'required'];

    // Solo validamos el criterio si el usuario ha escrito algo en él.
    if (!empty($criterioDesc)) {
        $validationRules['criterio_desc'] = 'required';
        $validationRules['criterio_puntos'] = 'required|numeric';
    }

    if (!$this->validate($validationRules)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'El nombre de la tarea es obligatorio.']);
    }
    
    try {
        $tareaId = $this->request->getPost('tarea_id') ?: 0;

        $sql = "DECLARE @out_tar_id INT, @out_crit_id INT;
                EXEC dbo.sp_CrearOAgregarCriterioTarea
                    @TAR_ID_INOUT = ?,
                    @PROY_ID = ?,
                    @STAT_ID = ?,
                    @PRIO_ID = ?,
                    @GPO_ID = ?,
                    @TAR_NOM = ?,
                    @TAR_DESC = ?,
                    @solicitado_por_usuario_id = ?,
                    @TAR_FECHAFIN = ?,                 -- <-- AÑADIDO Y EN ORDEN
                    @CRITERIO_DESCRIPCION = ?,
                    @PUNTOS_ESTIMADOS = ?,
                    @NUEVA_TAREA_ID = @out_tar_id OUTPUT,
                    @NUEVO_CRITERIO_ID = @out_crit_id OUTPUT;
                SELECT @out_tar_id as TareaID, @out_crit_id as CriterioID;";

        // --- CORRECCIÓN 2: REORDENAR EL ARRAY DE PARÁMETROS ---
        // El orden ahora coincide 100% con el SP.
        $params = [
            $tareaId,
            $this->request->getPost('proy_id'),
            $this->request->getPost('stat_id') ?: 1,
            $this->request->getPost('prio_id') ?: 2,
            $this->request->getPost('gpo_id') ?: 3,
            $this->request->getPost('tar_nom'),
            $this->request->getPost('tar_desc'),
            $this->request->getPost('solicitado_por_usuario_id'),
            $this->request->getPost('tar_fechafin') ?: null, // <-- MOVIMOS ESTE A LA POSICIÓN CORRECTA
            $this->request->getPost('criterio_desc'),
            $this->request->getPost('criterio_puntos')
        ];

        $db = \Config\Database::connect();
        $query = $db->query($sql, $params);
        $result = $query->getRow();

        // El SP puede no devolver un CriterioID si solo se guardó la tarea
        if ($result && $result->TareaID) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Operación completada exitosamente.',
                'tarea_id' => $result->TareaID,
                'criterio_id' => $result->CriterioID ?? null // Devolvemos null si no se creó criterio
            ]);
        } else {
            throw new \Exception('El procedimiento almacenado no devolvió un resultado válido.');
        }

    } catch (\Exception $e) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}

    /**
     * AJAX: Actualiza la descripción de un criterio existente.
     */
    public function ajax_actualizar_criterio()
    {
        if (!$this->request->isAJAX()) { return $this->response->setStatusCode(403); }

        $criterioModel = new CriterioModel();
        $id = $this->request->getPost('criterio_id');
        $descripcion = $this->request->getPost('descripcion');

        if ($criterioModel->update($id, ['descripcion' => $descripcion])) {
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo actualizar.']);
    }
    
    /**
     * AJAX: Elimina un criterio.
     */
    public function ajax_eliminar_criterio()
    {
        if (!$this->request->isAJAX()) { return $this->response->setStatusCode(403); }
        
        // Recibimos JSON en lugar de form-data
        $data = $this->request->getJSON();
        $id = $data->criterio_id;

        $criterioModel = new CriterioModel();
        if ($criterioModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo eliminar.']);
    }

public function listarPorProyecto($id_proyecto)
{
    $tareaModel = new TareaModel();
    
    // MEJORA: Hacemos un JOIN para obtener el nombre del estado
    $tareas = $tareaModel
        ->select('TAREAS.*, ESTATUS.STAT_NOM') // Seleccionamos todos los campos de TAREAS y el nombre del estado
        ->join('ESTATUS', 'ESTATUS.STAT_ID = TAREAS.STAT_ID', 'left') // Unimos con la tabla de estados
        ->where('TAREAS.PROY_ID', $id_proyecto)
        ->findAll();

     $tareaModel = new TareaModel();
    
    $data = [
        'settings' => session()->get('general_settings') ?? ['default_theme' => 'light'],
        'userData' => session()->get('userData'),
        // Usamos el nuevo método que hace los cálculos
        'tareas'   => $tareaModel->obtenerTareasConCalculos($id_proyecto),
        'id_proyecto' => $id_proyecto,
    ];

    // Llamamos a la vista que crearemos a continuación
    return view('Tareas/tareas_lista', $data);
}

    /**
     * Muestra el formulario para crear o editar una tarea.
     */
   public function formulario($id_identificador, $modo = 'crear')
{
    $session = session();
    if (!$session->get('is_logged_in')) {
        return redirect()->to('/login');
    }

    $proyectoModel = new ProyectoModel();
    $usuarioModel = new UsuarioModel();
    $tareaModel = new TareaModel();
    $criterioModel = new CriterioModel();
    $estatusModel = new EstatusModel();
    
    $tarea = [];
    $criterios = [];

    if ($modo === 'editar') {
        $id_tarea = $id_identificador;
        $tarea = $tareaModel->find($id_tarea);
        if (!$tarea) { throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(); }
        $criterios = $criterioModel->obtenerCriteriosPorTarea($id_tarea);
        $id_proyecto = $tarea['PROY_ID'];
    } else {
        $id_proyecto = $id_identificador;
    }

    $proyecto = $proyectoModel->find($id_proyecto);
    
    $data = [
        'listaEstatus' => $estatusModel->findAll(),
        'settings' => $session->get('general_settings') ?? ['default_theme' =>'dark'],
        'userData' => $session->get('userData'),
        'proyecto' => $proyecto,
        'tarea'    => $tarea,
        'criteriosExistentes' => $criterios,
        'listaUsuarios' => $usuarioModel->obtenerUsuariosParaDropdown(),
        'puntosScrum'  => [1, 2, 3, 5, 8, 13, 21, 34, 55, 89],
        'id_proyecto'  => $id_proyecto,
        'modo'         => $modo 
    ];

    // Reutilizamos las mismas vistas de formulario
    $show_page  = view('Tareas/tareas_header', $data);
    $show_page .= view('Tareas/tareas_body_editar', $data);
    $show_page .= view('Tareas/tareas_footer',  $data); // También pasamos $data aquí
    return $show_page;
}

public function ajax_eliminar_tarea()
{
    if (!$this->request->isAJAX()) {
        return $this->response->setStatusCode(403);
    }

    $data = $this->request->getJSON();
    $tareaId = $data->tarea_id ?? null;

    if (!$tareaId) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'No se proporcionó un ID de tarea.']);
    }

    // Es necesario obtener el PROY_ID antes de borrar para saber a dónde redirigir.
    $tareaModel = new TareaModel();
    $tarea = $tareaModel->find($tareaId);
    if (!$tarea) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'La tarea no existe.']);
    }
    $proyectoId = $tarea['PROY_ID'];

    try {
        // --- ¡CAMBIO IMPORTANTE AQUÍ! ---
        // En lugar de llamar al modelo, llamamos directamente al SP.
        $db = \Config\Database::connect();
        $sql = "EXEC dbo.sp_DeleteTask ?;";
        $params = [$tareaId];
        
        $db->query($sql, $params);

        // Si la consulta no lanza una excepción, fue exitosa.
        $redirectUrl = site_url('tareas/listar/' . $proyectoId);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Tarea eliminada exitosamente.',
            'redirect_url' => $redirectUrl
        ]);

    } catch (\Exception $e) {
        // Capturamos cualquier excepción lanzada por el SP.
        return $this->response->setJSON(['status' => 'error', 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}


}
