<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\GrupoModel;
use App\Models\ProyectoModel;
use App\Models\DetalleGrupoModel;

class Gestion extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        $defaults = ['default_theme' => 'dark']; 
        $settings = $session->get('general_settings') ?? $defaults;
        
        $usuarioModel = new UsuarioModel();
        $grupoModel = new GrupoModel();
        $proyectoModel = new ProyectoModel();
        $detalleGrupoModel = new DetalleGrupoModel();

        $projectId = $this->request->getGet('proyecto_id');
        
        $usuarios = [];
        $grupos = [];
        $proyecto_filtrado = null;

        if ($projectId && is_numeric($projectId)) {
            // Ahora estas llamadas al modelo funcionarán correctamente
            $usuarios = $detalleGrupoModel->getUsuariosPorProyecto($projectId);
            $grupos = $detalleGrupoModel->getGruposPorProyecto($projectId);
            $proyecto_filtrado = $proyectoModel->find($projectId);
        } else {
            $usuarios = $usuarioModel->findAll();
            $grupos = $grupoModel->findAll();
        }

        $data = [
            'settings'            => $settings,
            'userData'            => $session->get('userData'),
            'usuarios'            => $usuarios,
            'grupos'              => $grupos,
            'proyectos'           => $proyectoModel->findAll(),
            'proyecto_filtrado'   => $proyecto_filtrado,
            'selected_project_id' => $projectId
        ];
        
        $show_page  = view('gestion/gestion_header', $data);
        $show_page .= view('gestion/gestion_body', $data);
        $show_page .= view('gestion/gestion_footer', $data);
        
        return $show_page;
    }
    /**
     * Procesa la creación de un nuevo usuario. (SIN CAMBIOS)
     */
    public function crearUsuario()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'Nombre'           => 'required|alpha_space',
            'Apellido_Paterno' => 'required|alpha_space',
            'Apellido_Materno' => 'required|alpha_space',
            'Codigo_User'      => 'required|numeric',
            // CORRECCIÓN: Apunta a la tabla correcta 'usuario'
            'Correo'           => 'required|valid_email|is_unique[usuario.Correo]',
            'Password'         => 'required|min_length[8]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Si la validación falla, regresamos con los errores
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

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
     * Procesa la creación de un nuevo grupo desde el formulario modal.
     */
    public function crearGrupo()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'GPO_NOM' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Si la validación falla, regresamos con los errores
            return redirect()->back()->withInput()->with('errors_grupo', $validation->getErrors());
        }

        $grupoModel = new GrupoModel();

        $data = [
            'GPO_NOM'  => $this->request->getPost('GPO_NOM'),
            'GPO_DESC' => $this->request->getPost('GPO_DESC')
        ];

        $grupoModel->insert($data);

        return redirect()->to('/gestion')->with('success', 'Grupo creado con éxito.');
    }
}