<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\Usuario; // No olvides importar el modelo

class CheckAdmin extends BaseCommand
{
    protected $group       = 'User';
    protected $name        = 'user:checkadmin';
    protected $description = 'Verifica si existe un usuario con el rol de administrador.';

    public function run(array $params)
    {
        $model = new Usuario();
        $admin = $model->where('Rol', 'administrador')->first();

        if ($admin) {
            CLI::write('----------------------------------------', 'green');
            CLI::write('  ¡Administrador encontrado!  ', 'white', 'green');
            CLI::write('----------------------------------------', 'green');
            CLI::write('ID:       ' . $admin['Id_usuario']);
            CLI::write('Nombre:   ' . $admin['Nombre'] . ' ' . $admin['Apellido_Paterno']);
            CLI::write('Correo:   ' . $admin['Correo']);
            CLI::write('Estado:   ' . ($admin['Estado'] ? 'Activo' : 'Inactivo'));
        } else {
            CLI::error('No se encontró ningún usuario con el rol de administrador en la base de datos.');
        }
    }
}