<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\Proyecto;
use App\Models\ProyectoModel;
use Config\Database;

class Proyectos extends BaseController
{
     use ResponseTrait;
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

        $defaults = ['default_theme' => 'dark'];
        $settings = $session->get('general_settings') ?? $defaults;
        helper('url');

        $db = Database::connect();

        // --- 1. OBTENER DATOS PRINCIPALES DEL PROYECTO ---
        $proyectoInfo = $db->table('dbo.proyectos p')
            ->select('p.id_proyecto, p.nombre, p.descripcion, p.status, p.fecha_inicio, p.fecha_fin, u.Nombre, u.Apellido_Paterno')
            ->join('dbo.usuario u', 'u.Id_usuario = p.id_usuario_asignado', 'left')
            ->where('p.id_proyecto', $projectId)
            ->get()
            ->getRowArray();

        if (!$proyectoInfo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // --- 2. OBTENER ESTADÍSTICAS ---
        $total_tareas = $db->table('dbo.TAREAS')->where('PROY_ID', $projectId)->countAllResults();
        $tareas_completadas = $db->table('dbo.TAREAS t')->join('dbo.ESTATUS e', 't.STAT_ID = e.STAT_ID')->where('t.PROY_ID', $projectId)->where('e.STAT_NOM', 'Completado')->countAllResults();
        $costo = $db->table('dbo.DET_COSTOS')->selectSum('COST_MONTO', 'costo_total')->where('PROY_ID', $projectId)->get()->getRow();
        $costo_actual = $costo ? (float)$costo->costo_total : 0.00;

        // --- 3. OBTENER PARTICIPANTES Y GRUPOS ---
        // CORRECCIÓN FINAL: Se usa ->distinct() por separado de ->select()
        $usuarios = $db->table('dbo.DET_GRUPOS dg')
            ->distinct()
            ->select("(u.Nombre + ' ' + u.Apellido_Paterno) as nombre_completo")
            ->join('dbo.usuario u', 'dg.USU_ID = u.Id_usuario')
            ->where('dg.PROY_ID', $projectId)
            ->get()
            ->getResultArray();
        
        // CORRECCIÓN FINAL: Se usa ->distinct() por separado de ->select()
        $grupos = $db->table('dbo.DET_GRUPOS dg')
            ->distinct()
            ->select('g.GPO_NOM')
            ->join('dbo.GRUPOS g', 'dg.GPO_ID = g.GPO_ID')
            ->where('dg.PROY_ID', $projectId)
            ->get()
            ->getResultArray();
        
        // --- 4. OBTENER TAREAS RECIENTES ---
        $tareas = $db->table('dbo.TAREAS t')->select('t.TAR_NOM, e.STAT_NOM')->join('dbo.ESTATUS e', 't.STAT_ID = e.STAT_ID', 'left')->where('t.PROY_ID', $projectId)->orderBy('t.TAR_FECHAINI', 'DESC')->limit(5)->get()->getResultArray();

        // --- CONSTRUCCIÓN DEL ARRAY FINAL PARA LA VISTA ---
        $data['proyecto'] = ['id' => $proyectoInfo['id_proyecto'], 'nombre' => $proyectoInfo['nombre'], 'descripcion' => $proyectoInfo['descripcion'], 'estado' => $proyectoInfo['status'], 'responsable' => $proyectoInfo['Nombre'] . ' ' . $proyectoInfo['Apellido_Paterno'], 'fecha_inicio' => $proyectoInfo['fecha_inicio'], 'fecha_fin' => $proyectoInfo['fecha_fin']];
        $data['stats'] = ['total_tareas' => $total_tareas, 'tareas_completadas' => $tareas_completadas, 'costo_actual' => $costo_actual, 'presupuesto' => 0.00];
        $data['usuarios_asignados'] = array_column($usuarios, 'nombre_completo');
        $data['grupos_asignados'] = array_column($grupos, 'GPO_NOM');
        $data['tareas'] = $tareas;
        $data['settings'] = $settings;
        $data['userData'] = $session->get('userData');
        $show_page  = view('proyectos/detalles_header', $data);
        $show_page .= view('proyectos/detalles_body', $data);
        $show_page .= view('proyectos/detalles_footer', $data);
        return $show_page;
    }

         public function update()
    {
        // ... (La validación del rol y la obtención de datos se quedan igual) ...
        if (session()->get('rol') !== 'administrador') {
            return $this->failForbidden('No tienes permiso para realizar esta acción.');
        }
        $json = $this->request->getJSON();
        $id = $json->id_proyecto ?? null;
        if (!$id) {
            return $this->fail('No se proporcionó un ID de proyecto válido.');
        }
        $data = [
            'nombre'        => $json->nombre,
            'descripcion'   => $json->descripcion,
            'prioridad'     => $json->prioridad,
            'status'        => $json->status,
            'fecha_inicio'  => $json->fecha_inicio,
            'fecha_fin'     => $json->fecha_fin
        ];

        $proyectoModel = new ProyectoModel();

        // --- ¡CAMBIO IMPORTANTE AQUÍ! ---
        // En lugar de llamar a $proyectoModel->update(), llamamos a nuestro nuevo método.
        if ($proyectoModel->updateProjectSP($id, $data)) {
            // La lógica de respuesta exitosa es la misma
            return $this->respondUpdated(['message' => 'Proyecto actualizado con éxito mediante SP.']);
        } else {
            // La lógica de respuesta de error es la misma
            return $this->fail('No se pudo actualizar el proyecto mediante el procedimiento almacenado.');
        }
    }
}