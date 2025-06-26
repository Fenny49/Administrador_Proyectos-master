<?php

namespace App\Controllers;

class Recursos extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        $defaults = ['default_theme' => 'light']; 
        $settings = $session->get('general_settings') ?? $defaults;
        
        $users = [
            ['id' => 1, 'codigo' => '12456', 'foto' => 'avatar.png', 'nombre' => 'Lizandra Villanueva', 'email' => 'lizandra@mail.com', 'rol' => 'Manager', 'estado' => 'Activo', 'fecha_registro' => '2025-01-15'],
            ['id' => 2, 'codigo' => '94621', 'foto' => 'avatar.png', 'nombre' => 'Antonio Banderas', 'email' => 'antonio@mail.com', 'rol' => 'Administrador', 'estado' => 'Activo', 'fecha_registro' => '2025-02-20'],
            ['id' => 3, 'codigo' => '972513', 'foto' => 'avatar.png', 'nombre' => 'Marina Escalante', 'email' => 'marina@mail.com', 'rol' => 'Manager', 'estado' => 'Inactivo', 'fecha_registro' => '2025-03-10'],
            ['id' => 4, 'codigo' => '847291', 'foto' => 'avatar.png', 'nombre' => 'Eugenia Turron', 'email' => 'eugenia@mail.com', 'rol' => 'Administrador', 'estado' => 'Activo', 'fecha_registro' => '2024-12-05'],
            ['id' => 5, 'codigo' => '638125', 'foto' => 'avatar.png', 'nombre' => 'America Suicune', 'email' => 'america@mail.com', 'rol' => 'Usuario', 'estado' => 'Activo', 'fecha_registro' => '2025-04-01'],
        ];
        $groups = [
            ['id' => 1, 'codigo' => 'GRP-001', 'nombre' => 'Equipo de Desarrollo', 'miembros' => 5, 'lider' => 'Lizandra Villanueva', 'tipo' => 'Desarrollo'],
            ['id' => 2, 'codigo' => 'GRP-002', 'nombre' => 'Administración de Sistemas', 'miembros' => 3, 'lider' => 'Antonio Banderas', 'tipo' => 'Soporte'],
            ['id' => 3, 'codigo' => 'GRP-003', 'nombre' => 'Infraestructura Cloud', 'miembros' => 4, 'lider' => 'Ana García', 'tipo' => 'Servidor'],
        ];

        // Unificamos todos los datos para la vista
        $data = [
            'settings'  => $settings,
            'userData'  => $session->get('userData'),
            'resources' => [
                'users'  => $users,
                'groups' => $groups
            ],
            'filters' => [
                'user_types'  => array_values(array_unique(array_column($users, 'rol'))),
                'group_types' => array_values(array_unique(array_column($groups, 'tipo'))), // Corregido para que tome los tipos de grupo
                'estados'     => array_values(array_unique(array_column($users, 'estado'))),
                'projects'    => [] // No aplica en esta vista, lo dejamos vacío
            ]
        ];
        
        return view('recursos/index', $data);
    }
}