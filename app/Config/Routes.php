<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Login::show_login');
$routes->get('/dashboard', 'Dashboard::index');
$routes->post('/ingresar', 'Login::ingresar');
$routes->get('/registro', 'Registro::show_registro');
$routes->post('/registrar', 'Registro::guardar');
$routes->get('/login/captcha', 'Login::captcha');
$routes->get('/select-year', 'Dashboard::selectYear');
$routes->match(['get', 'post'], '/dashboard', 'Dashboard::index');
$routes->get('/ajustes', 'Ajustes::index');
$routes->get('/logout', 'Login::logout');
$routes->get('/proyectos/nuevo', 'Projects::new'); 
$routes->post('/proyectos/crear', 'Projects::create');
$routes->get('/tareas', 'Tareas::index');
$routes->post('/tareas/crear', 'Tareas::crear');
$routes->get('/recursos', 'Recursos::index');

// En app/Config/Routes.php

$routes->group('catalogos', ['filter' => 'auth'], function($routes) {
    // La página principal de selección de catálogos
    $routes->get('/', 'Catalogos::index');
    
    // La página que muestra la lista de un catálogo específico
    $routes->get('list/(:segment)', 'Catalogos::list/$1');
    
    // Rutas para las acciones AJAX (Crear, Actualizar, Eliminar)
    $routes->post('create/(:segment)', 'Catalogos::create/$1');
    $routes->post('update/(:segment)/(:num)', 'Catalogos::update/$1/$2');
    $routes->post('delete/(:segment)/(:num)', 'Catalogos::delete/$1/$2');
});
$routes->get('/ajustes', 'Ajustes::index');
$routes->get('/ajustes/generales', 'Ajustes::generales');
$routes->get('/ajustes/usuarios', 'Ajustes::usuarios');
$routes->get('/ajustes/masterdata', 'Ajustes::masterData');

// Routes especificas para la funcionalidad (NO CONECTADOS A LA BD)
$routes->post('/ajustes/generales/guardar', 'Ajustes::guardarGenerales');

//Ruta de la descarga en csv
$routes->get('dashboard/export_csv', 'Dashboard::export_csv');

$routes->get('/proyectos/nuevo', 'Projects::new'); 
$routes->post('/proyectos/crear', 'Projects::create');

// Ruta para la nueva sección de gestión de Usuarios y Grupos
$routes->get('/gestion', 'Gestion::index');
// El (:num) es un comodín que captura un número (el ID del proyecto) de la URL
$routes->get('/proyectos/(:num)/gestion', 'Gestion::index/$1');
// Ruta para mostrar la página de gestión de usuarios y grupos

// Rutas para procesar los formularios de creación
$routes->post('/gestion/usuarios/crear', 'Gestion::crearUsuario');
$routes->post('/gestion/grupos/crear', 'Gestion::crearGrupo');

// Ruta para ver los detalles de un proyecto específico
$routes->get('/proyectos/detalles/(:num)', 'Proyectos::detalles/$1');


// En app/Config/Routes.php
$routes->get('/ajustes', 'Ajustes::index');
$routes->get('/ajustes/generales', 'Ajustes::generales');
$routes->get('/ajustes/usuarios', 'Ajustes::usuarios');
$routes->post('/proyectos/update', 'Proyectos::update');
$routes->post('tareas/ajax_gestionar_tarea_criterio', 'Tareas::ajax_gestionar_tarea_criterio');

// Y también para las otras rutas AJAX que usas
$routes->post('tareas/ajax_actualizar_criterio', 'Tareas::ajax_actualizar_criterio');
$routes->post('tareas/ajax_eliminar_criterio', 'Tareas::ajax_eliminar_criterio');