<?php


namespace App\Controllers;
use App\Models\TareaModel;
use App\Models\UsuarioModel;
use App\Models\ProyectoModel;

class Tareas extends BaseController
{
    public function index($id_proyecto)
    {

        $usuarioModel = new UsuarioModel();
        $proyectoModel = new ProyectoModel();

        $listaUsuarios = $usuarioModel->obtenerUsuariosParaDropdown(); 

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
            'tasks'        => $tasks,
            'id_proyecto'  => $id_proyecto,
            'listaUsuarios' => $listaUsuarios
        ];
        
        $show_page  = view('Tareas/tareas_header', $data);
        $show_page .= view('Tareas/tareas_body', $data);
        $show_page .= view('Tareas/tareas_footer', $data);
        return $show_page;

           $tareaModel = new TareaModel();
        
        // Ejemplo de uso del método personalizado para poblar tu vista principal
        $tasks = $tareaModel->obtenerTareasConDetalles(); 

        $data = [
            'tasks' => $tasks // Ahora usas datos reales de la base de datos
        ];
    }

    /**
     * Procesa los datos del nuevo formulario detallado.
     */
      public function ajax_gestionar_tarea_criterio()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403, 'Forbidden');
        }

        // Validación simple (puedes mejorarla)
        $validation = $this->validate([
            'tar_nom' => 'required',
            'criterio_desc' => 'required',
            'criterio_puntos' => 'required|numeric'
        ]);

        if (!$validation) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Faltan datos obligatorios.']);
        }
        
        try {
            // El ID de la tarea puede venir vacío (creación) o con un valor (adición)
            $tareaId = $this->request->getPost('tarea_id') ?: 0; // Usamos 0 si es nulo o vacío

            // Construimos la consulta para ejecutar el SP
            // Usamos DECLARE y SELECT para capturar los parámetros OUTPUT del SP
          $sql = "DECLARE @out_tar_id INT, @out_crit_id INT;
        EXEC dbo.sp_CrearOAgregarCriterioTarea
            @TAR_ID_INOUT = ?,
            @PROY_ID = ?,                  -- <-- AÑADIDO
            @STAT_ID = ?,                  -- <-- AÑADIDO
            @PRIO_ID = ?,                  -- <-- AÑADIDO
            @GPO_ID = ?,                   -- <-- AÑADIDO
            @TAR_NOM = ?,
            @TAR_DESC = ?,
            @solicitado_por_usuario_id = ?,
            @TAR_FECHAINI = ?,
            @CRITERIO_DESCRIPCION = ?,
            @PUNTOS_ESTIMADOS = ?,
            @NUEVA_TAREA_ID = @out_tar_id OUTPUT,
            @NUEVO_CRITERIO_ID = @out_crit_id OUTPUT;
        SELECT @out_tar_id as TareaID, @out_crit_id as CriterioID;";

// Preparamos los parámetros en el orden correcto
$params = [
    $tareaId,
    $this->request->getPost('proy_id'), // <-- AÑADIDO
    $this->request->getPost('stat_id'), // <-- AÑADIDO
    $this->request->getPost('prio_id'), // <-- AÑADIDO
    $this->request->getPost('gpo_id'),  // <-- AÑADIDO
    $this->request->getPost('tar_nom'),
    $this->request->getPost('tar_desc'),
    $this->request->getPost('solicitado_por_usuario_id'),
    $this->request->getPost('fecha_creacion'),
    $this->request->getPost('criterio_desc'),
    $this->request->getPost('criterio_puntos')
];
            $db = \Config\Database::connect();
            $query = $db->query($sql, $params);
            
            // Obtenemos la fila de resultado que contiene nuestros IDs de salida
            $result = $query->getRow();

            if ($result && $result->CriterioID) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Operación completada exitosamente.',
                    'tarea_id' => $result->TareaID,
                    'criterio_id' => $result->CriterioID
                ]);
            } else {
                throw new \Exception('El procedimiento almacenado no devolvió un resultado válido.');
            }

        } catch (\Exception $e) {
            // Capturamos cualquier excepción (incluyendo las de SQL Server)
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

}
