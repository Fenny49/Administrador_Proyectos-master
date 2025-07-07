<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\Proyecto;
use App\Models\ProyectoModel;
use Config\Database;

class Proyectos extends BaseController
{
    use ResponseTrait;

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

        // --- 1. DATOS PRINCIPALES DEL PROYECTO (Sin cambios) ---
        $proyectoInfo = $db->table('dbo.proyectos p')
            ->select('p.id_proyecto, p.nombre, p.descripcion, p.status, p.fecha_inicio, p.fecha_fin, u.Nombre, u.Apellido_Paterno')
            ->join('dbo.usuario u', 'u.Id_usuario = p.id_usuario_asignado', 'left')
            ->where('p.id_proyecto', $projectId)
            ->get()
            ->getRowArray();

        if (!$proyectoInfo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // --- 2. ESTADÍSTICAS (Sin cambios) ---
        $total_tareas = $db->table('dbo.TAREAS')->where('PROY_ID', $projectId)->countAllResults();
        $tareas_completadas = $db->table('dbo.TAREAS t')->join('dbo.ESTATUS e', 't.STAT_ID = e.STAT_ID')->where('t.PROY_ID', $projectId)->where('e.STAT_NOM', 'Completado')->countAllResults();
        
        // =====================================================================
        // INICIO DEL NUEVO MÉTODO "A LA FUERZA"
        // =====================================================================

        // -- 3. OBTENER GRUPOS CON SQL PURO Y CONSTRUIR HTML --
        $sqlGrupos = "SELECT g.GPO_NOM FROM dbo.DET_GRUPOS dg JOIN dbo.GRUPOS g ON dg.GPO_ID = g.GPO_ID WHERE dg.PROY_ID = ? GROUP BY g.GPO_NOM";
        $gruposResult = $db->query($sqlGrupos, [$projectId])->getResultArray();
        
        $html_grupos = '';
        if (!empty($gruposResult)) {
            foreach ($gruposResult as $grupo) {
                $html_grupos .= '<li>' . esc($grupo['GPO_NOM']) . '</li>';
            }
        } else {
            $html_grupos = '<li class="text">No hay grupos asignados.</li>';
        }

        // -- 4. OBTENER USUARIOS CON SQL PURO Y CONSTRUIR HTML --
        $sqlUsuarios = "SELECT (u.Nombre + ' ' + u.Apellido_Paterno) as nombre_completo FROM dbo.DET_GRUPOS dg JOIN dbo.usuario u ON dg.USU_ID = u.Id_usuario WHERE dg.PROY_ID = ? GROUP BY u.Nombre, u.Apellido_Paterno";
        $usuariosResult = $db->query($sqlUsuarios, [$projectId])->getResultArray();

        $html_usuarios = '';
        if (!empty($usuariosResult)) {
            foreach ($usuariosResult as $usuario) {
                $html_usuarios .= '<li>' . esc($usuario['nombre_completo']) . '</li>';
            }
        } else {
            $html_usuarios = '<li class="text">No hay usuarios asignados.</li>';
        }
        
        // =====================================================================
        // FIN DEL NUEVO MÉTODO
        // =====================================================================

        // --- 5. OBTENER TAREAS RECIENTES (Sin cambios) ---
        $tareas = $db->table('dbo.TAREAS t')->select('t.TAR_NOM, e.STAT_NOM')->join('dbo.ESTATUS e', 't.STAT_ID = e.STAT_ID', 'left')->where('t.PROY_ID', $projectId)->orderBy('t.TAR_FECHAINI', 'DESC')->limit(5)->get()->getResultArray();

        // --- CONSTRUCCIÓN DEL ARRAY FINAL PARA LA VISTA ---
        $data['proyecto'] = $proyectoInfo;
        $data['stats'] = [
            'total_tareas' => $total_tareas, 
            'tareas_completadas' => $tareas_completadas
        ];
        // Pasamos los contadores y el HTML ya construido
        $data['total_usuarios'] = count($usuariosResult);
        $data['total_grupos'] = count($gruposResult);
        $data['html_lista_usuarios'] = $html_usuarios;
        $data['html_lista_grupos'] = $html_grupos;
        
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

        if ($proyectoModel->updateProjectSP($id, $data)) {
            return $this->respondUpdated(['message' => 'Proyecto actualizado con éxito mediante SP.']);
        } else {
            return $this->fail('No se pudo actualizar el proyecto mediante el procedimiento almacenado.');
        }
    }
}