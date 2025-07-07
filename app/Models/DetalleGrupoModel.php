<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleGrupoModel extends Model
{
    protected $table = 'DET_GRUPOS';
    protected $primaryKey = 'DGPO_ID';
    protected $allowedFields = ['PROY_ID', 'USU_ID', 'GPO_ID'];

    /**
     * Obtiene todos los usuarios asignados a un proyecto específico.
     */
    public function getUsuariosPorProyecto(int $proyectoId): array
    {
        // Se construye la consulta uniendo la tabla 'usuario' a la tabla
        // principal de este modelo ('DET_GRUPOS').
        return $this
            ->join('usuario u', 'u.Id_usuario = DET_GRUPOS.USU_ID')
            ->where('DET_GRUPOS.PROY_ID', $proyectoId)
            ->select("u.Id_usuario, u.Nombre, u.Apellido_Paterno, (u.Nombre + ' ' + u.Apellido_Paterno) as nombre_completo, u.Correo, u.Rol, u.Estado")
            ->distinct()
            ->findAll();
    }

    /**
     * Obtiene todos los grupos involucrados en un proyecto específico.
     */
    public function getGruposPorProyecto(int $proyectoId): array
    {
        // Se construye la consulta uniendo la tabla 'GRUPOS' a la tabla
        // principal de este modelo ('DET_GRUPOS').
        return $this
            ->join('GRUPOS g', 'g.GPO_ID = DET_GRUPOS.GPO_ID')
            ->where('DET_GRUPOS.PROY_ID', $proyectoId)
            ->select('g.GPO_ID, g.GPO_NOM, g.GPO_DESC')
            ->distinct()
            ->findAll();
    }
}