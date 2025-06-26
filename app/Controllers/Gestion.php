<?php

namespace App\Controllers;

// Importamos los modelos
use App\Models\UsuarioModel;
use App\Models\GrupoModel;

class Gestion extends BaseController
{
    /**
     * Muestra la página principal de gestión con las tablas de usuarios y grupos.
     */
    public function index()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        // --- INICIO DE LA MODIFICACIÓN ---

        // 1. Añadimos la carga de la configuración del tema y datos de sesión
        $defaults = ['default_theme' => 'light']; 
        $settings = $session->get('general_settings') ?? $defaults;
        
        $usuarioModel = new UsuarioModel();
        $grupoModel = new GrupoModel();

        // 2. Unificamos TODOS los datos que las vistas necesitan
        $data = [
            'settings' => $settings,
            'userData' => $session->get('userData'),
            'usuarios' => $usuarioModel->findAll(),
            'grupos'   => $grupoModel->findAll(),
        ];
        
        helper('url');
        
        // 3. Reemplazamos "return view()" por tu sistema de 3 archivos
        $show_page  = view('gestion/gestion_header', $data);
        $show_page .= view('gestion/gestion_body', $data);
        $show_page .= view('gestion/gestion_footer', $data);
        
        return $show_page;

        // --- FIN DE LA MODIFICACIÓN ---
    }

    /**
     * Procesa la creación de un nuevo usuario. (SIN CAMBIOS)
     */
    public function crearUsuario()
    {
        $usuarioModel = new UsuarioModel();

        $data = [
            'Nombre'           => $this->request->getPost('Nombre'),
            'Apellido_Paterno' => $this->request->getPost('Apellido_Paterno'),
            'Apellido_Materno' => $this->request->getPost('Apellido_Materno'),
            'Codigo_User'      => $this->request->getPost('Codigo_User'),
            'Correo'           => $this->request->getPost('Correo'),
            'Password'         => password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT),
            'Rol'              => $this->request->getPost('Rol'),
            'Estado'           => $this->request->getPost('Estado')
        ];

        $usuarioModel->insert($data);

        return redirect()->to('/gestion')->with('success', 'Usuario creado con éxito.');
    }

    /**
     * Procesa la creación de un nuevo grupo. (SIN CAMBIOS)
     */
    public function crearGrupo()
    {
        $grupoModel = new GrupoModel();

        $data = [
            'GPO_NOM'  => $this->request->getPost('GPO_NOM'),
            'GPO_DESC' => $this->request->getPost('GPO_DESC')
        ];

        $grupoModel->insert($data);

        return redirect()->to('/gestion')->with('success', 'Grupo creado con éxito.');
    }
}