<?php

class controller_user {
	public function datos() {
		$view = Flight::View();
		if ( auth::isLoggedIn() ) {
			$user = model_auth::getCurrent()->getUser();
			if ( $datos =  Flight::flash('datos') ) {
				$datos = array_pop($datos);
				$view->set('datos',$datos);
				Flight::clearFlash('datos');
			} else {
				$view->set('datos',$user->as_array());
			}
			$view->set('update',true);
			Flight::render('user_update',null,'layout');
		} else {
			Flight::flash('message',array('type'=>'error','text'=>'Tienes que entrar antes de cambiar tus datos'));
			Flight::redirect('/');
		}
	}

	public function update() {
		$view = Flight::View();
		if ( auth::isLoggedIn() ) {
			$datos = Flight::request()->data;
			list( $valido, $errores ) = user::validar($datos);
			if ( $valido ) {
				$user = model_auth::getCurrent()->getUser();
				$user->cargarDatos($datos);
				$user->save();
				Flight::flash('message',array('type'=>'success','text'=>'Datos actualizados.'));
				Flight::redirect('/pedido');
			} else {
				foreach ( $errores as $err ) {
						Flight::flash('message',array('type'=>'error','text'=>$err));
				}
				Flight::flash('datos',$datos);
				Flight::redirect('/user/datos');
			}
		} else {
			Flight::flash('message',array('type'=>'error','text'=>'Tienes que entrar antes de cambiar tus datos'));
			Flight::redirect('/');
		}
	}
}
