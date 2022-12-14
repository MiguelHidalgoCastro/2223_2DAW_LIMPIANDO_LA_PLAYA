<?php

/** FACHADA de la aplicación.
 *
 * Su objetivo principal es LLAMAR AL CONTROLADOR QUE QUIERE EL USUARIO
 *
 * Sus responsabilidades son:
 * 1. Leer la configuración general de la aplicación.
 * 2. Abrir la sesión del usuario, si hay.
 * 3. Leer los parámetros de la petición.
 * 4. Cargar el Controlador.
 * 5. Llamar al método del controlador.
 * 6. Gestionar los errores.
 * */

//Cargar la configuración
$config = require_once('config.php');
if ($config['debug']) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}

try {

	//Abrimos la sesión y cargamos... lo que haya (usuario logeado, carrito...)
	session_start();
	$usuario = null;
	if (isset($_SESSION['usuario']))
		$usuario = $_SESSION['usuario'];

	//Leer los parámetros: 
	//Ref:https://www.php.net/manual/es/reserved.variables.server.php 
	//	método de la petición: $metodo
	//	parámetros del path: $pathParams
	//	parámetros de consulta: $queryParams
	//	cuerpo de la petición: $body
	//
	//	http://.../index.php/pathParam1/pathParam2?qp1=56&qp2=Hola&qp3=42
	//	Ejemplos:
	//		http://midominio.com/aplicacion/index.php?accion=consulta&id_cliente=7
	//		http://midominio.com/aplicacion/index.php/login
	//		http://midomi.../index.php/cliente/alta?nombre=Pepe&apellidos=Garcia%20Torres
	//
	//		http://midominio.com/index.php - Sin controlador.
	//

	//Leemos el método de la petición HTTP
	$metodo = $_SERVER['REQUEST_METHOD'];	//GET, POST, PUT, DELETE, OPTIONS, HEAD...

	//Leemos los Path Params
	$pathParams = [];
	if (isset($_SERVER['PATH_INFO'])) {
		$pathParams = explode('/', $_SERVER['PATH_INFO']);
	}

	//si no pide controlador, le mando al cuerno

	if (count($pathParams) < 2) {
		header('Location: index.html');
		//var_dump($pathParams);
		die();
	}



	//Leemos el controlador. Hemos acordado que estará en el primer parámetro de Path
	$controlador = $pathParams[1];

	//para cuando no quiera que se vea index.php
	/*
	if (isset($pathParams[0]))
		$controlador = $pathParams[1];
	else
		$controlador = 'inicio';
	*/

	//Leemos los parámetros de consulta
	$queryParams = null;
	parse_str($_SERVER['QUERY_STRING'], $queryParams);

	//Leemos el body (AJAX con JSON)
	$body = json_decode(file_get_contents('php://input'));


	//Cargamos el controlador
	switch ($controlador) {
			/*
		case 'inicio':
			require_once('index.html');
			die();
			break;
			*/
		case 'login':
			require_once($config['path_controladores'] . 'login.php');
			$controlador = new ControladorLogin();
			break;
		case 'cliente':
			require_once($config['path_controladores'] . 'cliente.php');
			$controlador = new ControladorCliente($config);
			break;
		case 'escenario':
			require_once($config['path_controladores'] . 'escenario.php');
			$controlador = new ControladorEscenario($config);
			break;
		default:
			header('HTTP/1.1 501 Not Implemented');
	}
	switch ($metodo) {
		case 'GET':
			$controlador->get($usuario, $pathParams, $queryParams);
			die();
		case 'POST':
			$controlador->post($usuario, $pathParams, $queryParams, $body);
			die();
	}
} catch (Throwable $e) {
	header('HTTP/1.1 500 Internal Server Error');
	if ($config['debug'])
		echo $e;
}
