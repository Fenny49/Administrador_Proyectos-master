<?php

namespace App\Controllers;

use App\Models\Usuario;

class Login extends BaseController
{
    //Separacion de los valores mostrados en pantalla
    public function show_login(){
        $show_login=view('Login/Login_header.php');
        $show_login.=view('Login/Login_Body.php');
        $show_login.=view('Login/Login_Footer.php');
        return $show_login;
    }

    public function ingresar()
    {
        $session = session();
        $userCaptcha = $this->request->getPost('captcha');
        $sessionCaptcha = $session->get('captcha_word');
        if (empty($userCaptcha) || strtolower($userCaptcha) !== strtolower($sessionCaptcha)) {
            $session->remove('captcha_word');
            $session->setFlashdata('error', 'El texto del Captcha es incorrecto.');
            return redirect()->to('/login');
        }
        $session->remove('captcha_word');

        $correo = $this->request->getPost('correo');
        $password = $this->request->getPost('password');

        $model = new Usuario();
        $usuario = $model->verificar_login($correo, $password);

        if ($usuario) {
            // CASO DE ÉXITO
            
            // Construimos el nombre completo 
            $nombreCompleto = $usuario['Nombre'] . ' ' . $usuario['Apellido_Paterno'] . ' ' . $usuario['Apellido_Materno'];

            // Creamos los datos de la sesión, AÑADIENDO EL ROL
            $session_data = [
                'id_usuario'      => $usuario['Id_usuario'],
                'nombre_completo' => $nombreCompleto, // Usaremos este en el dashboard
                'rol'             => $usuario['Rol'],
                'is_logged_in'    => TRUE
            ];
            $session->set($session_data);

            return redirect()->to('/select-year');

        } else {
            // CASO DE FRACASO
            $session->setFlashdata('error', 'Correo o contraseña inválidos. Inténtalo de nuevo.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
         session()->destroy();
        return redirect()->to('/login');
    }

    public function captcha()
    {
        helper('captcha');
        create_captcha();
    }
}