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

	public function getUltimosPedidos() {
		$pedidos = Model::factory('pedido')->where('user_id',$this->id)->where_in('estado',array('sinconfirmar','confirmado','entregado'))->order_by_desc('created')->limit(5)->find_many();
		return $pedidos;
	}

	public static function validar($datos) {
		$ok = true;
		$errores = array();

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
		$u = model_user::getByEmail(trim($datos['email']));
		if ( $u && $u->id != $datos['id'] ) {
			$ok = false;
			$errores[] = 'Ya existe un usuario registrado con el email '.trim($datos['email']).'.';
		}
		if ( ! isset($datos['id']) && preg_match("/[a-zA-Z0-9.!#$%&'*+-\/=?\^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*/",trim($datos['email'])) === 0 ) {
			$ok = false;
			$errores[] = 'Tu dirección de email no parece válida.';
		}
		return array($ok,$errores);
	}
}
