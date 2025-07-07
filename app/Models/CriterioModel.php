<?php

namespace App\Models;

use CodeIgniter\Model;

class CriterioModel extends Model
{
    protected $table            = 'dbo.CRITERIOS_ACEPTACION';
    protected $primaryKey       = 'CRITERIO_ID';
    protected $returnType       = 'array'; // Para ser consistente con tus otros modelos
    
    protected $allowedFields    = [
        'TAREA_ID', 
        'CRITERIO_DESCRIPCION', 
        'PUNTOS_ESTIMADOS'
    ];

    /**
     * Obtiene todos los criterios de aceptación para una tarea específica.
     * @param int $tareaId El ID de la tarea.
     * @return array
     */
    public function obtenerCriteriosPorTarea($tareaId)
    {
        if (!$tareaId) {
            return []; // Si no hay ID de tarea, devuelve un array vacío
        }
        
        return $this->where('TAREA_ID', $tareaId)
                    ->orderBy('CRITERIO_ID', 'ASC')
                    ->findAll();
    }
}