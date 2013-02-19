<?php

class model_user {

	public static function getByEmail( $email ) {
		return Model::factory('user')->where('email', $email)->find_one();
	}

	public static function getById( $id ) {
		return Model::factory('user')->where('id', $id)->find_one();
	}

}

class user extends Model {
	private $auth = false;

	public function getAuth() {
		if ( ! $this->auth ) { 
			$this->auth = Model::factory('auth')->where('user_id',$this->id)->find_one();
		}
		return $this->auth;
	}

	public function cargarDatos( $datos ) {
		$this->nombre = trim($datos['nombre']);
		$this->apellido = trim($datos['apellido']);
		$this->telefono = trim($datos['telefono']);
		$this->calle = trim($datos['calle']);
		$this->numero = trim($datos['numero']);
		$this->direccion = trim($datos['direccion']);
		$this->piso = trim($datos['piso']);
		$this->depto = trim($datos['depto']);
		$this->barrio_id = (int)$datos['barrio_id'];
		return;
	}

	public function sinPassword() {
		return is_null($this->getAuth()->password);
	}

	public function sinConfirmar() {
		return $this->estado == 'sinconfirmar';
	}

	public function confirmar() {
		$this->estado = 'confirmado';
		$this->save();
	}
}
