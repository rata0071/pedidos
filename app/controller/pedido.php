<?php

class controller_pedido {

	public function nuevo() {
		$view = Flight::View();
		$view->set('cantidades',$_GET['p']);
		self::showForm();
	}

	public static function showForm() {
		$view = Flight::View();
		$view->set('productos',model_producto::getAll());
		$view->set('horarios',model_horario::getAllJson());
		$view->set('barrios',model_barrio::getAllJson());
		$view->set('recorridos',model_recorrido::getAllJson());
		Flight::render('pedido_form',null,'layout');
	}

	public function encargar() {
		$view = Flight::View();
		$datos = Flight::request()->data;
		list( $valido, $errores ) = self::validarPedido($datos);

		if ( $valido ) {
			if ( ! auth::isLoggedIn() ) {
				$user = Model::factory('user')->create();
				$user->email = trim($datos['email']);
				$user->cargarDatos($datos);
				$user->estado = 'sinconfirmar';
				$user->save();

				$auth = Model::factory('auth')->create();
				$auth->user_id = $user->id;
				$auth->challenge = auth::newChallenge();
				$auth->save();
			}

			$pedido = Model::factory('pedido')->create();
			$pedido->estado = 'sinconfirmar';
			$pedido->user_id = $user->id;
			$pedido->fecha_entrega = strtotime($datos['fecha_entrega']);
			$recorrido = model_recorrido::getFechaDisponible($datos['fecha_entrega'], $datos['horario_id'], $datos['barrio_id']);
			$pedido->recorrido_id = $recorrido->id;
			$pedido->observaciones = $datos['observaciones'];
			$pedido->save();

			list ( $enviado, $error ) = $pedido->enviarConfirmacion();

			$view->set('user',$user);

			if ( ! $enviado ) {
				Flight::set('errores',array($error));
				Flight::render('pedido_error',null,'layout');
			} else {
				Flight::render('pedido_success',null,'layout');
			}

		} else { 
			Flight::set('errores',$errores);
			$view->set('datos',$datos);
			self::showForm();
		}
	}

	public static function validarPedido( $datos ) {
		$errores = array();
		$ok = true;
		if ( array_sum($datos[p]) < 1 ) {
			$ok = false;
			$errores[] = 'No seleccionaste ningun producto.';
		}

		if ( ! auth::isLoggedIn() ) {
			if ( mb_strlen($datos['nombre']) < 2 ) {
				$ok = false;
				$errores[] = 'El nombre es muy corto.';
			}
			if ( mb_strlen($datos['apellido']) < 2 ) {
				$ok = false;
				$errores[] = 'El apellido es muy corto.';
			}
			if ( mb_strlen($datos['telefono']) < 8 ) {
				$ok = false;
				$errores[] = 'Ingresa un teléfono válido.';
			}
			if ( mb_strlen($datos['direccion']) < 4 ) {
				$ok = false;
				$errores[] = 'La dirección no parece ser correcta.';
			}
			if ( preg_match("/[a-zA-Z0-9.!#$%&'*+-\/=?\^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*/",trim($datos['email'])) === 0 ) {
				$ok = false;
				$errores[] = 'Tu dirección de email no parece válida.';
			}
			if ( model_user::getByEmail(trim($datos['email'])) ) {
				$ok = false;
				$errores[] = 'Ya existe un usuario registrado con el email '.trim($datos['email']).'.';
			}
		}

		if ( ! model_recorrido::getFechaDisponible($datos['fecha_entrega'], $datos['horario_id'], $datos['barrio_id']) ) {
			$ok = false;
			$errores[] = 'El horario o fecha no esta disponible.';
		}

		return array( $ok, $errores);
	}


	public function confirmar ( $id ) {
		$view = Flight::View();
		$pedido = model_pedido::getById($id);

		if ( $pedido && $pedido->checkChallenge($_GET['c']) && !$pedido->expiro()) {
			$pedido->confirmar();
			if ( $pedido->getUser()->sinPassword() ) {
				$view->set('pedirpassword',true);
			}
			$view->set('pedido',$pedido);
			Flight::render('pedido_confirmar',null,'layout');
		} else {
			Flight::set('errores',array('Pedido expirado o codigo de validación incorrecto.'));
			Flight::render('pedido_error',null,'layout');
		}
	}
}
