<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyectoModel extends Model
{
    protected $table            = 'proyectos';
    protected $primaryKey       = 'id_proyecto';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nombre',
        'descripcion',
        'prioridad',
        'status',
        'fecha_inicio',
        'fecha_fin',
        'id_usuario_asignado',
        'anio'
    ];

    // Funciones para fechas (opcional pero recomendado)
    protected $useTimestamps = false;
}