<?php

namespace App\Controllers;

use App\Models\ProyectoModel; // No olvides importar tu modelo

class Projects extends BaseController
{
    /**
     * Muestra el formulario para crear un nuevo proyecto.
     */
    public function new()
    {
        // Simplemente cargamos la vista del formulario.
        // La crearemos en el Paso 4.
        return view('projects/new');
    }

    /**
     * Recibe los datos del formulario y los guarda en la base de datos.
     */
    public function create()
    {
        // 1. Cargar el modelo
        $proyectoModel = new ProyectoModel();

        // 2. Recoger los datos del formulario (POST)
        // Usamos los nombres de los campos del formulario que crearemos
        $data = [
            'nombre'             => $this->request->getPost('nombre_proyecto'),
            'descripcion'        => $this->request->getPost('descripcion'),
            'prioridad'          => $this->request->getPost('prioridad'), // Asumiendo que tendrás un campo para esto
            'fecha_inicio'       => $this->request->getPost('fecha_inicio'),
            'fecha_fin'          => $this->request->getPost('fecha_fin'),
            'status'             => $this->request->getPost('status'), // Por ejemplo, 'Activo' por defecto
            'id_usuario_asignado'=> 1, // Simulado por ahora, puedes cambiarlo
            'anio'               => date('Y', strtotime($this->request->getPost('fecha_inicio'))) // Calcula el año desde la fecha de inicio
        ];

        // 3. Insertar los datos en la base de datos
        if ($proyectoModel->insert($data)) {
            // 4. Si se guarda con éxito, crea un mensaje de sesión "flash"
            session()->setFlashdata('success', '¡Proyecto añadido con éxito!');
        } else {
            // Manejar el error si es necesario
            session()->setFlashdata('error', 'No se pudo añadir el proyecto.');
        }

        // 5. Redireccionar al usuario al panel principal
        return redirect()->to(base_url('/dashboard')); // O la ruta de tu panel
    }
}