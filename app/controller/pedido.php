<?php

class controller_pedido {

	// Queremos crear un nuevo pedido
	public function nuevo() {
		$view = Flight::View();

		// Si ya tenemos datos los cargamos
		if ( $datos =  Flight::flash('datos') ) {
			$datos = array_pop($datos);
			$view->set('datos',$datos);
			Flight::clearFlash('datos');	
		}

		// Si esta logueado traemos los pedidos
		$auth = model_auth::getCurrent();
		if ( auth::isLoggedIn() ) {
			$pedidos = $auth->getUser()->getUltimosPedidos();
			$view->set('pedidos',$pedidos);
		}

		$view->set('token',$auth->getCSRFToken());
		$view->set('cantidades',$_GET['p']);
		$view->set('productos',model_producto::getAll());
		Flight::render('pedido_form',null,'layout');
	}


	// Creamos un pedido
	public function encargar() {
		$view = Flight::View();
		$datos = Flight::request()->data;

		// Validaciones
		list( $valido, $errores ) = pedido::validar($datos);

		if ( ! auth::isLoggedIn() ) {
			list( $userValido, $userErrores ) = user::validar($datos);
			$valido = $valido && $userValido;
			$e = array_merge($errores, $userErrores);
			$errores = $e;
		}


		if ( $valido ) { // Si el pedido es valido
			// Creo el usuario o cargo los datos del usuario actual
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
			} else {
				$auth = model_auth::getCurrent();
				$user = $auth->getUser();
			}

			// Cargo los datos del pedido
			$pedido = Model::factory('pedido')->create();
			$pedido->estado = 'sinconfirmar';
			$pedido->user_id = $user->id;
			$pedido->fecha_entrega = $datos['fecha_entrega'];
			$recorrido = model_recorrido::getFechaDisponible($datos['fecha_entrega'], $datos['horario_id'], $datos['barrio_id']);
			$pedido->recorrido_id = $recorrido->id;
			$pedido->observaciones = $datos['observaciones'];
			$pedido->save();

			// Cargo los productos y cantidades
			foreach ( $datos['p'] as $producto_id => $cantidad ) {
				if ( $cantidad > 0 ) {
					$item = Model::factory('item')->create();
					$item->pedido_id = $pedido->id;
					$item->producto_id = $producto_id;
					$item->cantidad = $cantidad;
					$item->save();
				}
			}

			// Enviamos la confirmacion y mostramos los mensajes
			list ( $enviado, $error ) = $pedido->enviarConfirmacion();

			if ( ! $enviado ) {
				Flight::flash('message',array('type'=>'error','text'=>$error));
			} else {
				Flight::flash('message',array('type'=>'success','text'=>'Revisa tu correo y confirma tu pedido','icon'=>'envelope'));
			}

			Flight::redirect('/');

		} else {
			foreach ( $errores as $err ) {
				Flight::flash('message',array('type'=>'error','text'=>$err));
			}
			Flight::flash('datos',$datos);
			Flight::redirect('/pedido');
		}
	}

	public function confirmar ( $id ) {
		$view = Flight::View();
		$pedido = model_pedido::getById($id);

		if ( $pedido && $pedido->getUser()->getAuth()->checkChallenge($_GET['c']) && !$pedido->expiro()) {
			$pedido->confirmar();
			if ( $pedido->getUser()->sinPassword() ) {
				$view->set('pedirpassword',true);
				$pedido->getUser()->getAuth()->login();
				$view->set('auth',$pedido->getUser()->getAuth());
			}
			if ( $pedido->getUser()->sinConfirmar() ) {
				$pedido->getUser()->confirmar();
			}
			Flight::render('pedido_confirmar',null,'layout');
		} else {
			Flight::flash('message',array('type'=>'error','text'=>'Pedido expirado o código de validación incorrecto.'));
			Flight::redirect('/');
		}
	}

	public function cancelar( $id ) {
		$pedido = model_pedido::getById($id);
		$auth = model_auth::getCurrent();
		if ( $pedido && auth::isLoggedIn() && $pedido->getUser()->id == $auth->user_id && $auth->checkCSRFToken($_GET['csrftoken']) ) {
			$pedido->estado = 'cancelado';
			$pedido->save();
			Flight::flash('message',array('type'=>'success','text'=>'El pedido ha sido cancelado.'));
		} else {
			Flight::flash('message',array('type'=>'error','text'=>'No puedes cancelar ese pedido.'));
		}
		Flight::redirect(View::makeUri('/pedido'));
	}
}
