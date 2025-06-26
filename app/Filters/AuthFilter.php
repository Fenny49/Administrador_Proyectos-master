<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Este método se ejecuta ANTES de que el controlador sea llamado.
     * Aquí es donde ponemos nuestra lógica de protección.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verificamos si en la sesión existe la variable 'is_logged_in'
        // que creamos en el controlador de Login.
        if (!session()->get('is_logged_in')) {
            // Si el usuario NO ha iniciado sesión, lo redirigimos a la página de login.
            return redirect()->to('/login');
        }
    }

    /**
     * Este método se ejecuta DESPUÉS de que el controlador ha hecho su trabajo.
     * No necesitamos hacer nada aquí para la autenticación.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacer nada
    }
}