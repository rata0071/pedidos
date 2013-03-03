<?php

class model_auth {

	public static function getByUserId( $user_id ) {
		$auth = Model::factory('auth')->where('user_id', $user_id)->find_one();
		return $auth;
	}

	public static function getCurrent() {
		if ( isset($_SESSION['user_id']) ) {
			$auth = Model::factory('auth')->where('user_id', $_SESSION['user_id'])->find_one();
		} else {
			$auth = Model::factory('auth')->create();
		}
		return $auth;
	}

	public static function increaseFailed( $user_id ) {
		$auth = self::getByUserId( $user_id );
		$auth->failed = $auth->failed + 1;
		$auth->save();
	}

	public static function clearFailed( $user_id ) {
		$auth = self::getByUserId( $user_id );
		$auth->failed = 0;
		$auth->save();
	}
}

class auth extends Model {
	public function __construct() {
		//@TODO use https
		session_set_cookie_params( 45*60*60, '/', DOMAIN, false, true );
		session_start();
	}

	public function checkPassword($password) {
		if ( ! $this->password && sha1($password) == $this->old_password ) {
			$this->old_password = null;
			$this->changePassword($password);
			return true;
		} else {
			$salt = $this->getSalt();
			$hash = $this->getHash();

			return ($hash == $this->hash($salt,$password));
		}
	}

	public function changePassword($password) {
		$salt = self::genSalt();
		$this->password = $salt.self::hash($salt,$password);
		$this->save();
	}

	public static function hash($salt, $pass) {
		return hash( 'sha256', hash('sha256',$salt) . hash('sha256',$pass) );
	}

	private function getSalt() {
		return substr($this->password,0,16);
	}

	private function getHash() {
		return substr($this->password,16,64);
	}

	public static function genSalt() {
		return substr(uniqid('',true),0,16);
	}

	public function login() {
		$_SESSION['logged'] = true;
		$_SESSION['user_id'] = $this->user_id;
		$this->last_login = date('Y-m-d H:i:s');
		$this->save();
	}

	public static function isLoggedIn() {
		return $_SESSION['logged'];
	}

	public function isAdmin() {
		return (bool)$this->is_admin;
	}

	public function getUser() {
		return model_user::getById($this->user_id);
	}
	public static function newChallenge() {
		return sha1(uniqid());
	}

	public function resetChallenge() {
		$this->challenge = self::newChallenge();
		$this->save();
	}

	public function checkChallenge($c) {
		return $this->challenge == trim($c);
	}

	public static function getCSRFToken() {
		$_SESSION['csrf_token'] = sha1(uniqid());
		return $_SESSION['csrf_token'];
	}

	public static function checkCSRFToken($t) {
		if ( ! is_null($t) && ! empty($t) ) {
			return $t == $_SESSION['csrf_token'];
		} else {
			return false;
		}
	}

	public function sendPasswordEmail() {

		$mail = mail::newmail();
		$mail->AddAddress($this->getUser()->email, $this->getUser()->nombre);

		$this->resetChallenge();
		$link = $this->getChangePasswordLink();
		$_link = View::e( $link );

		$mail->Subject = "¿Olvidaste tu contraseña? - Vive Verde";
		$mail->Body = 'Alguien (probablemente tú) pidio que se te enviara este email, si no quieres cambiar tu contraseña ignora este mensaje. <br /> <br /> Si en realidad olvidaste tu contraseña puedes cambiarla haciendo <a href="'.$_link.'" target="_blank">click aqui</a> o ingresando a esta dirección: '.$_link;
		$mail->IsHTML(true);
		$mail->AltBody = "Alguien (probablemente tú) pidio que se te enviara este email, si no quieres cambiar tu contraseña ifnora este mensaje. \n \n Si en realidad olvidaste tu contraseña puedes cambiarla ingresando a esta dirección: ".$link;

		if(!$mail->Send()) {
			error_log('Mailer error: '.$mail->ErrorInfo);
			return array(false,'Mailer error: '.$mail->ErrorInfo);
		} else {
			return array(true,'');
		}
	}

	public function getChangePasswordLink() {
		return View::makeUri('/auth/'.$this->user_id.'/setpassword/'.$this->challenge);
	}
}
