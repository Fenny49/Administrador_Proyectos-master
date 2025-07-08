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


    public function updateProjectSP(int $id, array $data): bool
    {
        // Construimos la consulta para llamar al procedimiento almacenado
        // Usamos placeholders (?) para la vinculación de parámetros segura
        $sql = "EXEC sp_UpdateProject ?, ?, ?, ?, ?, ?, ?";
        
        // El orden de los parámetros en el array debe coincidir EXACTAMENTE
        // con el orden de los parámetros en la definición del SP.
        $params = [
            $id,
            $data['nombre'],
            $data['descripcion'],
            $data['prioridad'],
            $data['status'],
            $data['fecha_inicio'],
            $data['fecha_fin']
        ];
        
        // Ejecutamos la consulta
        // El método query() de CodeIgniter se encarga de escapar los parámetros
        // para prevenir inyección SQL.
        try {
            $this->db->query($sql, $params);
            // Si la consulta no lanza una excepción, asumimos que fue exitosa.
            return true;
        } catch (\Exception $e) {
            // Si hay un error de base de datos, lo registramos y devolvemos false.
            log_message('error', 'Error al ejecutar sp_UpdateProject: ' . $e->getMessage());
            return false;
        }
    }
    
    // Funciones para fechas (opcional pero recomendado)
    protected $useTimestamps = false;


    
}