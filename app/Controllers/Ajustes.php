<?php

namespace App\Controllers;
use App\Models\UsuarioModel;
use App\Models\GrupoModel;
use App\Models\ProyectoModel;
use App\Models\DetalleGrupoModel;
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

        // --- INICIO DEL CAMBIO ---
        // Construimos el array 'userData' manualmente desde la sesión.
        $userData = [
            'rol' => strtolower($session->get('rol') ?? ''),
            'nombre_completo' => $session->get('nombre_completo')
            // Puedes añadir más datos si los necesitas, ej: 'id_usuario' => $session->get('id_usuario')
        ];
        // --- FIN DEL CAMBIO ---

        // Carga la configuración del tema para pasársela a la vista
        $defaults = ['default_theme' => 'dark']; 
        $settings = $session->get('general_settings') ?? $defaults;
        
        $data = [
            'userData' => $userData, // Usamos el array que acabamos de crear
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

        // --- INICIO DEL CAMBIO ---
        // Construimos el array 'userData' manualmente.
        $userData = [
            'rol' => strtolower($session->get('rol') ?? ''),
            'nombre_completo' => $session->get('nombre_completo')
        ];
        // --- FIN DEL CAMBIO ---

        $defaults = [
            'allow_new_projects'    => '1', 'show_user_avatar'      => '1',
            'allow_notifications'   => '1', 'feedback_from_users'   => '1',
            'active_users'          => 'all', 'default_theme'         => 'dark',
        ];
        $data['settings'] = $session->get('general_settings') ?? $defaults;
        $data['userData'] = $userData; // Usamos el array que acabamos de crear

        $show_page  = view('Ajustes/ajustes_header', $data);
        $show_page .= view('ajustes/generales', $data);
        $show_page .= view('Ajustes/ajustes_footer',  $data);
        return $show_page;
    }

    /**
     * Guarda las configuraciones generales en la sesión.
     * (Este método no necesita cambios)
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

        $defaults = ['default_theme' => 'dark']; 
        $settings = $session->get('general_settings') ?? $defaults;
        helper('url');

        $usuarioModel = new UsuarioModel();
        $grupoModel = new GrupoModel();
        $proyectoModel = new ProyectoModel();
        $detalleGrupoModel = new DetalleGrupoModel();

        $projectId = $this->request->getGet('proyecto_id');
        
        $usuarios_a_mostrar = [];
        $grupos_a_mostrar = [];
        $proyecto_filtrado = null;

        if ($projectId && is_numeric($projectId) && $projectId > 0) {
            $usuarios_a_mostrar = $detalleGrupoModel->getUsuariosPorProyecto($projectId);
            $grupos_a_mostrar = $detalleGrupoModel->getGruposPorProyecto($projectId);
            $proyecto_filtrado = $proyectoModel->find($projectId);
        } else {
            $usuarios_a_mostrar = $usuarioModel->findAll();
            $grupos_a_mostrar = $grupoModel->findAll();
        }

        $data = [
            'settings'            => $settings,
            'userData'            => $session->get('userData'),
            'resources'           => [
                'users'  => $usuarios_a_mostrar,
                'groups' => $grupos_a_mostrar
            ],
            'filters' => [
                'user_types' => array_values(array_unique(array_column($usuarioModel->findAll(), 'Rol'))),
                'estados'    => array_values(array_unique(array_column($usuarioModel->findAll(), 'Estado'))),
            ],
            'proyectos'           => $proyectoModel->findAll(),
            'proyecto_filtrado'   => $proyecto_filtrado,
            'selected_project_id' => $projectId
        ];
        
        $show_page  = view('Ajustes/usuarios_header', $data);
        $show_page .= view('ajustes/usuarios', $data);
        $show_page .= view('Ajustes/usuarios_footer', $data);
        return $show_page;
    }

    /**
     * Procesa la creación de un nuevo usuario desde el formulario modal.
     */
    public function crearUsuario()
    {
        // --- INICIO DE LA MODIFICACIÓN ---

        // 1. Definimos las reglas de validación de una forma más clara
        $rules = [
        'Nombre'  => 'required|alpha_space',
        'Apellido_Paterno' => 'required|alpha_space',
        'Apellido_Materno' => 'required|alpha_space',
        'Password' => 'required|min_length[8]',
                    'Correo' => [
                        'rules' => 'required|valid_email|is_unique[usuario.Correo]',
                        'errors' => [
                            'required' => 'El correo electrónico es obligatorio.',
                            'valid_email' => 'Por favor, introduce un correo electrónico válido.',
                            'is_unique' => 'Este correo electrónico ya está registrado. Por favor, utiliza otro.'
                        ]
                    ],
        'Codigo_User' => [
                        'rules' => 'required|numeric|is_unique[usuario.Codigo_User]',
                        'errors' => [
                            'required' => 'El código de usuario es obligatorio.',
                            'numeric' => 'El código de usuario solo debe contener números.',
                            'is_unique' => 'Este código de usuario ya existe. Por favor, elige otro.'
                        ]
                    ]
        ];

                // 2. Ejecutamos la validación con el método recomendado
        if (!$this->validate($rules)) {
                    // Si la validación falla, regresamos al formulario con los errores.
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

                // 3. Si la validación es exitosa, procedemos a guardar.
        $usuarioModel = new UsuarioModel();
        $data = [
        'Nombre'=> $this->request->getPost('Nombre'),
        'Apellido_Paterno' => $this->request->getPost('Apellido_Paterno'),
        'Apellido_Materno' => $this->request->getPost('Apellido_Materno'),
        'Codigo_User'=> $this->request->getPost('Codigo_User'),
        'Correo' => $this->request->getPost('Correo'),
        'Password'=> password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT),
        'Rol'=> $this->request->getPost('Rol'),
        'Estado'=> $this->request->getPost('Estado')
        ];
        $usuarioModel->insert($data);

        return redirect()->to('/ajustes/usuarios')->with('success', 'Usuario creado con éxito.');

                // --- FIN DE LA MODIFICACIÓN ---
        }

    /**
     * Procesa la creación de un nuevo grupo desde el formulario modal.
     */
    public function crearGrupo()
    {
        $validation = \Config\Services::validation();
        $validation->setRules(['GPO_NOM' => 'required']);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors_grupo', $validation->getErrors());
        }

        $grupoModel = new GrupoModel();
        $data = [
            'GPO_NOM'  => $this->request->getPost('GPO_NOM'),
            'GPO_DESC' => $this->request->getPost('GPO_DESC')
        ];
        $grupoModel->insert($data);

        return redirect()->to('/ajustes/usuarios')->with('success', 'Grupo creado con éxito.');
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