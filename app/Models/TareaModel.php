<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Class TareaModel
 * 
 * Este modelo gestiona las operaciones CRUD para la tabla de tareas (dbo.TAREAS).
 */
class TareaModel extends Model
{
    /**
     * El grupo de conexión a la base de datos a utilizar, como se define en app/Config/Database.php.
     * Si usas el grupo por defecto ('default'), no necesitas esta línea.
     * Descomenta si tu conexión a SQL Server tiene un nombre de grupo específico (ej: 'sqlserver').
     */
    // protected $DBGroup = 'default';

    /**
     * La tabla principal asociada a este modelo.
     * Es importante especificar el schema (dbo) si tu configuración de base de datos no lo hace por defecto.
     * @var string
     */
    protected $table = 'dbo.TAREAS';

    /**
     * La clave primaria de la tabla.
     * @var string
     */
    protected $primaryKey = 'TAR_ID';

    /**
     * El tipo de datos que devolverán los métodos del modelo (find, findAll, etc.).
     * 'object' es generalmente más limpio para trabajar en las vistas.
     * @var string
     */
    protected $returnType = 'object';

    /**
     * Si es true, las operaciones de inserción y actualización usarán automáticamente
     * los valores de las columnas `created_at` y `updated_at`.
     * Tu tabla actual no tiene estas columnas, así que lo establecemos en `false`.
     * Si las añades, puedes cambiar esto a `true`.
     * @var bool
     */
    protected $useTimestamps = false;
    
    // Si decides usar timestamps, puedes personalizar los nombres de las columnas:
    // protected $createdField  = 'fecha_creacion';
    // protected $updatedField  = 'fecha_modificacion';
    // protected $dateFormat    = 'datetime'; // o 'int', 'date'

    /**
     * Especifica qué campos de la tabla se pueden establecer masivamente
     * durante una operación de inserción o actualización (ej: a través de un formulario).
     * Esta es una medida de seguridad crucial para prevenir la asignación masiva de campos no deseados.
     * @var array
     */
    protected $allowedFields = [
        'PROY_ID',
        'TAR_NOM',
        'TAR_DESC',
        'TAR_FECHAINI',
        'TAR_FECHAFIN',
        'STAT_ID',
        'PRIO_ID',
        'TAR_NOTAS',
        'GPO_ID',
        'solicitado_por_usuario_id',
        'solicitado_por_puesto_id',
        'complejidad_id',
        'bitacora_pruebas'
    ];

    /**
     * Reglas de validación que se pueden usar antes de insertar o actualizar.
     * Puedes definir tus reglas aquí y llamarlas desde el controlador con $model->validate($data).
     * @var array
     */
    protected $validationRules = [
        'TAR_NOM' => 'required|min_length[5]|max_length[255]',
        'TAR_DESC' => 'permit_empty|string',
        'solicitado_por_usuario_id' => 'required|is_natural_no_zero',
        'PROY_ID' => 'permit_empty|is_natural_no_zero',
        // Agrega aquí más reglas para otros campos según sea necesario
    ];

    /**
     * Mensajes de error personalizados para las reglas de validación.
     * @var array
     */
    protected $validationMessages = [
        'TAR_NOM' => [
            'required' => 'El nombre de la tarea es obligatorio.',
            'min_length' => 'El nombre de la tarea debe tener al menos 5 caracteres.'
        ],
        'solicitado_por_usuario_id' => [
            'required' => 'Debe seleccionar un usuario solicitante.',
            'is_natural_no_zero' => 'El ID del usuario solicitante no es válido.'
        ]
    ];

    /**
     * Si deseas omitir la validación durante las inserciones o actualizaciones.
     * Por lo general, es mejor mantenerlo en `false` y realizar la validación.
     * @var bool
     */
    protected $skipValidation = false;


    // --------------------------------------------------------------------
    // MÉTODOS PERSONALIZADOS
    // --------------------------------------------------------------------
    
    /**
     * Obtiene todas las tareas con información relacionada de otras tablas (joins).
     * Este es un ejemplo de cómo podrías obtener una lista de tareas para tu página principal.
     *
     * @param int|null $projectId El ID del proyecto para filtrar las tareas.
     * @return array
     */
    public function obtenerTareasConDetalles($projectId = null)
    {
        // El constructor de consultas (Query Builder) es la forma recomendada y segura
        $builder = $this->db->table($this->table . ' t'); // 't' es un alias para la tabla TAREAS

        $builder->select('
            t.TAR_ID, 
            t.TAR_NOM, 
            t.TAR_FECHAINI,
            u.nombre_completo as solicitado_por,  
            s.STAT_NOMBRE as estado_nombre,     
            p.PRIO_NOMBRE as prioridad_nombre    
        ');

        // Realizamos los JOINs para obtener los nombres en lugar de solo los IDs
        $builder->join('dbo.USUARIO u', 'u.id = t.solicitado_por_usuario_id', 'left');
        $builder->join('dbo.ESTADOS s', 's.STAT_ID = t.STAT_ID', 'left');
        $builder->join('dbo.PRIORIDADES p', 'p.PRIO_ID = t.PRIO_ID', 'left');

        // Si se proporciona un ID de proyecto, filtramos por él
        if ($projectId) {
            $builder->where('t.PROY_ID', $projectId);
        }

        // Ordenamos los resultados
        $builder->orderBy('t.TAR_ID', 'DESC');

        // Ejecutamos la consulta y devolvemos los resultados
        return $builder->get()->getResult();
    }
}