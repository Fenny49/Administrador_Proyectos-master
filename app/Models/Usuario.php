<?php

namespace App\Models;

use CodeIgniter\Model;

class Usuario extends Model
{
    protected $table = 'dbo.usuario';
    protected $allowedFields = ['Nombre', 'Apellido_Paterno', 
    'Apellido_Materno', 'Codigo_User', 
    'Correo', 'Password', 'rol'];

    
    public function verificar_login($correo, $password)
    {
        return $this->where('Correo', $correo)
                    ->where('Password', $password)
                    ->first();
    }


    /**
     *  Registra un usuario llamando al procedimiento almacenado 'sp_RegistrarUsuario'.
     */
    public function registrar_usuario($data)
    {
       
        $sql = "EXEC dbo.sp_RegistrarUsuario ?, ?, ?, ?, ?, ?, ?";

   
        $params = [
            $data['Nombre'],
            $data['Apellido_Paterno'],
            $data['Apellido_Materno'],
            $data['Codigo_User'],
            $data['Correo'],
            $data['Password'],
            $data['rol']
        ];

        // Se ejecuta consulta usando el query builder de CodeIgniter.
        //    Pasar los parámetros como un segundo argumento es la forma segura
        //    de prevenir inyección SQL (query binding).
        try {
            $this->db->query($sql, $params);
            return true; // Si la consulta se ejecuta sin errores, devolvemos true.
        } catch (\Exception $e) {
            // Si el procedimiento almacenado lanza un error, lo capturamos.
            log_message('error', 'Error al registrar usuario vía SP: ' . $e->getMessage());
            return false; // Devolvemos false para indicar que falló.
        }
    }

    public function getUsuariosRol($rolEquipoId)
    {
        // Usamos el Query Builder de CodeIgniter PENDIENTE
        return $this->select('Id_usuario, Nombre, Apellido_Paterno, Apellido_Materno')
                    ->where('Rol_Equipo', $rolEquipoId)
                    ->orderBy('Nombre', 'ASC') 
                    ->findAll(); 
    }
}