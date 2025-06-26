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
}