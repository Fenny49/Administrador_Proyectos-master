<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuario';
    protected $primaryKey       = 'Id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Campos permitidos para la inserción y actualización
    protected $allowedFields    = [
        'Nombre', 
        'Apellido_Paterno', 
        'Apellido_Materno', 
        'Codigo_User', 
        'Correo', 
        'Password', 
        'Rol_Equipo', 
        'Rol', 
        'Estado'
    ];
        
     public function obtenerUsuariosParaDropdown()
    {
        // El constructor de consultas nos permite crear consultas complejas de forma segura.
        // Usamos asArray() para forzar la salida como array, respetando la configuración del modelo.
        return $this->select("Id_usuario, CONCAT(Nombre, ' ', Apellido_Paterno, ' ', Apellido_Materno) as NombreCompleto, Rol")
                    ->where('Estado', 1) // Filtramos solo por usuarios activos (Estado = 1)
                    ->orderBy('Nombre', 'ASC')
                    ->asArray() // Aseguramos que el resultado sea un array
                    ->findAll();
    }
}