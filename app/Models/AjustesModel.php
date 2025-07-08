<?php

namespace App\Models;

use CodeIgniter\Model;

class AjustesModel extends Model
{
    /**
     * La conexión a la base de datos se hereda automáticamente del padre.
     * No definimos una tabla principal ($table) porque este modelo
     * realizará consultas complejas en múltiples tablas.
     */
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    /**
     * Obtiene todos los usuarios de la base de datos con un formato
     * listo para ser mostrado en la vista.
     *
     * @return array Un array de usuarios.
     */
    public function obtenerTodosLosUsuarios(): array
    {
        // Consulta SQL para seleccionar y formatear los datos de los usuarios.
        $sql = "
            SELECT
                Id_usuario,
                Nombre + ' ' + Apellido_Paterno AS NombreCompleto, -- Concatenamos para SQL Server
                Correo AS Email,
                Rol,
                CASE
                    WHEN Estado = 1 THEN 'Activo'
                    ELSE 'Inactivo'
                END AS Estado
            FROM
                dbo.usuario
            ORDER BY
                NombreCompleto ASC;
        ";

        // Ejecutamos la consulta
        $query = $this->db->query($sql);

        // Devolvemos el resultado como un array
        return $query->getResultArray();
    }

    /**
     * Obtiene todos los grupos y concatena los nombres de los usuarios
     * que pertenecen a cada grupo.
     *
     * @return array Un array de grupos con sus miembros.
     */
    public function obtenerTodosLosGruposConMiembros(): array
    {
        // Consulta SQL para obtener los grupos y agregar a sus miembros.
        // STRING_AGG es la función de SQL Server para concatenar strings de varias filas.
        $sql = "
            SELECT
                g.GPO_ID,
                g.GPO_NOM AS NombreGrupo,
                g.GPO_DESC AS DescripcionGrupo,
                ISNULL(STRING_AGG(u.Nombre + ' ' + u.Apellido_Paterno, ', '), 'No hay miembros asignados') AS Miembros
            FROM
                dbo.GRUPOS g
            LEFT JOIN
                dbo.DET_GRUPOS dg ON g.GPO_ID = dg.GPO_ID
            LEFT JOIN
                dbo.usuario u ON dg.USU_ID = u.Id_usuario
            GROUP BY
                g.GPO_ID, g.GPO_NOM, g.GPO_DESC
            ORDER BY
                g.GPO_NOM ASC;
        ";

        // Ejecutamos la consulta
        $query = $this->db->query($sql);

        // Devolvemos el resultado como un array
        return $query->getResultArray();
    }
}
