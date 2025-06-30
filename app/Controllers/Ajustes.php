<?php

namespace App\Controllers;

class Ajustes extends BaseController
{
    /**
     * Muestra la página principal de Ajustes (el menú con 4 botones).
     */
    public function index()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        // Carga la configuración del tema para pasársela a la vista
        $defaults = ['default_theme' => 'dark']; 
        $settings = $session->get('general_settings') ?? $defaults;
        
        $data = [
            'userData' => $session->get('userData'),
            'settings' => $settings
        ];
        helper('url');
        
        $show_page  = view('Ajustes/ajustes_header', $data);
        $show_page .= view('Ajustes/ajustes_body', $data);
        $show_page .= view('Ajustes/ajustes_footer', $data);
        return $show_page;
    }

    /**
     * Muestra la página de configuraciones generales.
     */
    public function generales()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }
        helper('form');

        $defaults = [
            'allow_new_projects'    => '1', 'show_user_avatar'      => '1',
            'allow_notifications'   => '1', 'feedback_from_users'   => '1',
            'active_users'          => 'all', 'default_theme'         => 'dark',
        ];
        $data['settings'] = $session->get('general_settings') ?? $defaults;
        $data['userData'] = $session->get('userData');

        $show_page  = view('Ajustes/ajustes_header', $data);
        $show_page .= view('ajustes/generales', $data);
        $show_page .= view('Ajustes/ajustes_footer',  $data);
        return $show_page;
    }

    /**
     * Guarda las configuraciones generales en la sesión.
     */
    public function guardarGenerales()
    {
        $session = session();
        $settings = [
            'active_users'          => $this->request->getPost('active_users'),
            'default_theme'         => $this->request->getPost('default_theme'),
            'allow_new_projects'    => $this->request->getPost('allow_new_projects') ?? '0',
            'show_user_avatar'      => $this->request->getPost('show_user_avatar') ?? '0',
            'allow_notifications'   => $this->request->getPost('allow_notifications') ?? '0',
            'feedback_from_users'   => $this->request->getPost('feedback_from_users') ?? '0',
        ];
        $session->set('general_settings', $settings);
        $session->setFlashdata('success_message', '¡Configuraciones guardadas!');
        return redirect()->to('/ajustes/generales');
    }

    /**
     * Muestra la página de gestión de Usuarios y Grupos.
     */
    public function usuarios()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }
        helper('url');

        $defaults = ['default_theme' => 'dark']; 
        $settings = $session->get('general_settings') ?? $defaults;

        $users = [
            ['id' => 1, 'codigo' => '12456', 'foto' => 'avatar.png', 'nombre' => 'Lizandra Villanueva', 'email' => 'lizandra@mail.com', 'rol' => 'Manager', 'estado' => 'Activo'],
            ['id' => 2, 'codigo' => '94621', 'foto' => 'avatar.png', 'nombre' => 'Antonio Banderas', 'email' => 'antonio@mail.com', 'rol' => 'Administrador', 'estado' => 'Activo'],
        ];
        $groups = [
            ['id' => 1, 'codigo' => 'GRP-001', 'nombre' => 'Equipo de Desarrollo', 'miembros' => 5, 'lider' => 'Lizandra Villanueva', 'tipo' => 'Desarrollo'],
        ];

        $data = [
            'settings'  => $settings,
            'userData'  => $session->get('userData'),
            'resources' => ['users'  => $users, 'groups' => $groups],
            'filters' => [
                'user_types'  => array_values(array_unique(array_column($users, 'rol'))),
                'group_types' => array_values(array_unique(array_column($groups, 'tipo'))),
                'estados'     => array_values(array_unique(array_column($users, 'estado'))),
            ]
        ];
        
        $show_page  = view('Ajustes/ajustes_header', $data);
        $show_page .= view('ajustes/usuarios', $data);
        $show_page .= view('Ajustes/ajustes_footer', $data);
        return $show_page;
    }

    /**
     * Muestra la página de gestión de Master Data.
     */
    public function masterData()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }
        helper('url');

        $defaults = ['default_theme' => 'dark']; 
        $settings = $session->get('general_settings') ?? $defaults;

        $data['roles'] = [['id' => 1, 'nombre' => 'Administrador'],['id' => 2, 'nombre' => 'Manager'],['id' => 3, 'nombre' => 'Usuario']];
        $data['estados_proyecto'] = [['id' => 1, 'nombre' => 'Activo'],['id' => 2, 'nombre' => 'Pendiente'],['id' => 3, 'nombre' => 'Completado']];
        $data['prioridades'] = [['id' => 1, 'nombre' => 'Alta'],['id' => 2, 'nombre' => 'Media'],['id' => 3, 'nombre' => 'Normal']];
        $data['tipos_tarea'] = [['id' => 1, 'nombre' => 'Diseño UX/UI'],['id' => 2, 'nombre' => 'Desarrollo Frontend']];
        $data['tipos_costo'] = [['id' => 1, 'nombre' => 'Licencias de Software'],['id' => 2, 'nombre' => 'Servicios Cloud']];
        $data['departamentos'] = [['id' => 1, 'nombre' => 'Tecnologías de la Información'],['id' => 2, 'nombre' => 'Marketing Digital']];
        $data['userData'] = $session->get('userData');
        $data['settings'] = $settings;

        $show_page  = view('Ajustes/ajustes_header', $data);
        $show_page .= view('Ajustes/masterdata_body', $data);
        $show_page .= view('Ajustes/ajustes_footer', $data);
        return $show_page;
    }
}