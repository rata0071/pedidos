<?php

class controller_auth {

	public function login() {
		$data = Flight::request()->data;
		$user = model_user::getByEmail($data['email']);
		if ( $user ) {
			$auth = model_auth::getByUserId($user->id);
			if ( $auth->checkPassword($data['password']) ) {
				$auth->login();
				model_auth::clearFailed($user->id);
				Flight::redirect(View::makeUri('/'));
			} else {
				Flight::flash('message',array('type'=>'error','text'=>'Email o contraseña incorrecta.'));
				model_auth::increaseFailed($user->id);
			}
		} else {
			Flight::flash('message',array('type'=>'error','text'=>'Email o contraseña incorrecta.'));
		}

		Flight::render('auth_login',null,'layout');
	}

	public function logout() {
		session_start();
		session_unset();
		session_destroy();
		session_write_close();
		session_regenerate_id(true);
		Flight::render('auth_logout',null,'layout');
	}

	public function changeForm() {
		Flight::render('auth_change',null,'layout');
	}

	public function change() {
		$data = Flight::request()->data;
		$auth = model_auth::getCurrent();

		if ( $auth->checkPassword($data['password']) && $data['newpassword'] == $data['repeatpassword'] ) {
			Flight::flash('message',array('type'=>'success','text'=>'Cambiesta tu contraseña con éxito ¡No la olvides!'));
			$auth->changePassword($data['newpassword']);
			Flight::redirect(View::makeUri('/'));

		} else {
			Flight::flash('message',array('type'=>'error','text'=>'Error al cambiar la contraseña.'));
			Flight::render('auth_change',null,'layout');
		}
	}

	public function newpassword() {
		$view = Flight::View();
		$data = Flight::request()->data;
		$auth = model_auth::getCurrent();

		if ( $auth->checkCSRFToken($data['csrftoken']) && $data['password'] == $data['repeat'] ) {
			Flight::flash('message',array('type'=>'success','text'=>'Cambiesta tu contraseña con éxito ¡No la olvides!'));
			$auth->changePassword($data['password']);
			Flight::redirect(View::makeUri('/pedido'));

		} else {
			$view->set('auth',$auth);
			Flight::flash('message',array('type'=>'error','text'=>'Error al crear la contraseña.'));
			Flight::render('auth_set',null,'layout');
		}
	}


	public function forgotPassword() {
		Flight::render('auth_forgot',null,'layout');
	}

	public function sendPassword() {
		$data = Flight::request()->data;
		$user = model_user::getByEmail($data['email']);

		if ( $user ) {
			list ( $sent, $err ) = $user->getAuth()->sendPasswordEmail();
			if ( $sent ) {
				Flight::flash('message',array('type'=>'success','text'=>'Revisa tu correo y crea tu nueva contraseña.'));
				Flight::redirect(View::makeUri('/'));

			} else {	
				Flight::flash('message',array('type'=>'error','text'=>$err));
				Flight::redirect(View::makeUri('/auth/forgotpassword'));
			}
		} else {
			Flight::flash('message',array('type'=>'error','text'=>'La dirección '.$data['email'].' no esta registrada en el sistema.'));
			Flight::render('auth_forgot',null,'layout');
		}
	}

	public function setPassword( $id, $c ) {
		$view = Flight::View();
		$user = model_user::getById( $id );
		if ( $user ) {
			$auth = $user->getAuth();
			if ( $auth->checkChallenge($c) ) {
				$auth->login();
				$view->set('auth',$auth);
				Flight::render('auth_set',null,'layout');
				return;
			} 
		}

		Flight::flash('message',array('type'=>'error','text'=>'Oops... El link ha expirado prueba otra vez.'));
		Flight::redirect(View::makeUri('/'));
	}
}
