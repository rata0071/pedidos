<?php

class controller_auth {

	public function login() {
		$data = Flight::request()->data;
		$user = model_user::getByUsername($data['username']);
		if ( $user ) {
			$auth = model_auth::getByUserId($user->id);
			if ( $auth->checkPassword($data['password']) ) {
				$auth->login();
				model_auth::clearFailed($user->id);
				Flight::redirect(View::makeUri('/'));
			} else {
				Flight::set('errores',array('Email o contraseña incorrecta.'));
				model_auth::increaseFailed($user->id);
			}
		} else {
			Flight::set('errores',array('Email o contraseña incorrecta.'));
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
			$auth->changePassword($data['newpassword']);
			Flight::redirect(View::makeUri('/'));
		} else {
			Flight::set('errores',array('Error al cambiar la contraseña.'));
			Flight::render('auth_change',null,'layout');
		}
	}

	public function newpassword() {
		$view = Flight::View();
		$data = Flight::request()->data;
		$auth = model_auth::getCurrent();
		if ( $auth->checkCSRFToken($data['csrftoken']) && $data['password'] == $data['repeat'] ) {
			$auth->changePassword($data['password']);
			Flight::redirect(View::makeUri('/pedidos'));
		} else {
			$view->set('auth',$auth);
			Flight::set('errores',array('Error al crear la contraseña.'));
			Flight::render('auth_set',null,'layout');
		}
	}
}
