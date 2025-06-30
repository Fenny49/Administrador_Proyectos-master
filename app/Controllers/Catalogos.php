<?php

namespace App\Controllers;

use App\Models\CatalogModel;

class Catalogos extends BaseController
{
    private $catalogModel;

    public function __construct()
    {
        // --- CONTROL DE ACCESO PARA ADMINISTRADOR ---
        // Asegura que solo los administradores puedan acceder a este controlador.
        if (session()->get('rol') !== 'administrador') {
            // Muestra un error 404 para no revelar la existencia de esta sección.
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $this->catalogModel = new CatalogModel();
    }

    // Muestra la página principal de "Ajustes > Catálogos"
    public function index()
    {
 // --- Lógica de Sesión y Tema ---
        $session = session();
        $defaults = ['default_theme' => 'dark']; 
        $settings = $session->get('general_settings') ?? $defaults;
        $data = [
            'settings' => $settings,
            'userData' => $session->get('userData')
        ];

        // --- Carga de Vistas en 3 Partes (EL CAMBIO IMPORTANTE) ---
        $show_page = view('Catalogos/catalogos_body.php', $data);
        return $show_page;
    }

    // Muestra la lista de un catálogo específico (ej: /catalogos/estatus)
    public function list($catalogType)
    {
        $config = $this->getCatalogConfig($catalogType);
        if (!$config) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
  // --- Lógica de Sesión y Tema ---
        $session = session();
        $defaults = ['default_theme' => 'dark']; 
        $settings = $session->get('general_settings') ?? $defaults;

        // --- Unificamos todos los datos para la vista ---
        $data = [
            'settings'    => $settings,
            'userData'    => $session->get('userData'),
            'items'       => $this->catalogModel->getAll($config['sp_read_all']),
            'title'       => $config['title'],
            'catalogType' => $catalogType,
            'id_field'    => $config['id_field'],
            'name_field'  => $config['name_field']
        ];     
        // --- Carga de Vistas en 3 Partes (EL CAMBIO IMPORTANTE) ---
        $show_page = view('Catalogos/lista_catalogos.php', $data);
        return $show_page;
    }

    // Guarda un nuevo registro (se llama vía AJAX)
     public function create($catalogType)
    {
        $config = $this->getCatalogConfig($catalogType);
        $name = $this->request->getPost('name');

        // CAMBIAR ESTA LÍNEA
        if ($this->catalogModel->createEntry($config['sp_create'], $name)) { // ANTES: ->create
            return $this->response->setJSON(['success' => true, 'message' => 'Registro creado con éxito.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Error al crear el registro.']);
    }

    // Dentro del método update()
    public function update($catalogType, $id)
    {
        $config = $this->getCatalogConfig($catalogType);
        $name = $this->request->getPost('name');

        // CAMBIAR ESTA LÍNEA
        if ($this->catalogModel->updateEntry($config['sp_update'], $id, $name)) { // ANTES: ->update
            return $this->response->setJSON(['success' => true, 'message' => 'Registro actualizado con éxito.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar el registro.']);
    }

    // Dentro del método delete()
    public function delete($catalogType, $id)
    {
        $config = $this->getCatalogConfig($catalogType);
        
        // CAMBIAR ESTA LÍNEA
        if ($this->catalogModel->deleteEntry($config['sp_delete'], $id)) { // ANTES: ->delete
            return $this->response->setJSON(['success' => true, 'message' => 'Registro eliminado con éxito.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar el registro.']);
    }

    // Helper para obtener la configuración de cada catálogo
    private function getCatalogConfig($catalogType)
    {
        $config = [
            'estatus' => [
                'title' => 'Estatus',
                'id_field' => 'STAT_ID',
                'name_field' => 'STAT_NOM',
                'sp_create' => 'sp_estatus_create',
                'sp_read_all' => 'sp_estatus_read_all',
                'sp_update' => 'sp_estatus_update',
                'sp_delete' => 'sp_estatus_delete',
            ],
            'tipocosto' => [
                'title' => 'Tipos de Costo',
                'id_field' => 'TIPOCOST_ID',
                'name_field' => 'TIPOCOST_NOM',
                'sp_create' => 'sp_tipocosto_create',
                'sp_read_all' => 'sp_tipocosto_read_all',
                'sp_update' => 'sp_tipocosto_update',
                'sp_delete' => 'sp_tipocosto_delete',
            ],
            'prioridades' => [
                'title' => 'Prioridades',
                'id_field' => 'PRIO_ID',
                'name_field' => 'PRIO_NOM',
                'sp_create' => 'sp_prioridades_create',
                'sp_read_all' => 'sp_prioridades_read_all',
                'sp_update' => 'sp_prioridades_update',
                'sp_delete' => 'sp_prioridades_delete',
            ],
            'roles' => [
                'title' => 'Roles de Usuario',
                'id_field' => 'ID_rol',
                'name_field' => 'Nombre_rol',
                'sp_create' => 'sp_roles_create',
                'sp_read_all' => 'sp_roles_read_all',
                'sp_update' => 'sp_roles_update',
                'sp_delete' => 'sp_roles_delete',
            ]
        ];

        return $config[$catalogType] ?? null;
    }
}