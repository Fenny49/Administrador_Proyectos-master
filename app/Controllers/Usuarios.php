<?php

namespace App\Controllers;

class Usuarios extends BaseController
{
    /**
     * Muestra la página de gestión de Usuarios y Grupos.
     */
    public function index()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        // Cargamos el 'ayudante' para que base_url() funcione en la vista
        helper('url');

        // Preparamos todos los datos de ejemplo para la tabla interactiva
        $users = [
            ['id' => 1, 'codigo' => '12456', 'foto' => 'avatar.png', 'nombre' => 'Lizandra Villanueva', 'email' => 'lizandra@mail.com', 'rol' => 'Manager', 'estado' => 'Activo', 'fecha_registro' => '2025-01-15'],
            ['id' => 2, 'codigo' => '94621', 'foto' => 'avatar.png', 'nombre' => 'Antonio Banderas', 'email' => 'antonio@mail.com', 'rol' => 'Administrador', 'estado' => 'Activo', 'fecha_registro' => '2025-02-20'],
            ['id' => 3, 'codigo' => '972513', 'foto' => 'avatar.png', 'nombre' => 'Marina Escalante', 'email' => 'marina@mail.com', 'rol' => 'Manager', 'estado' => 'Inactivo', 'fecha_registro' => '2025-03-10'],
            ['id' => 4, 'codigo' => '847291', 'foto' => 'avatar.png', 'nombre' => 'Eugenia Turron', 'email' => 'eugenia@mail.com', 'rol' => 'Administrador', 'estado' => 'Activo', 'fecha_registro' => '2024-12-05'],
        ];
        $groups = [
            ['id' => 1, 'codigo' => 'GRP-001', 'nombre' => 'Equipo de Desarrollo', 'miembros' => 5, 'lider' => 'Lizandra Villanueva'],
            ['id' => 2, 'codigo' => 'GRP-002', 'nombre' => 'Administración de Sistemas', 'miembros' => 3, 'lider' => 'Antonio Banderas'],
        ];

        // Preparamos los datos que se pasarán a la vista
        $data['view_data'] = [
            'users' => $users,
            'groups' => $groups,
            'roles' => array_values(array_unique(array_column($users, 'rol'))),
            'estados' => array_values(array_unique(array_column($users, 'estado'))),
            'userData' => $session->get('userData')
        ];

        // Cargamos la vista desde su nueva ubicación
        return view('usuarios/index', $data['view_data']);
    }
}