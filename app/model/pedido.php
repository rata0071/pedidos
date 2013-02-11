<?php

class model_pedido {

	public static function getById( $id ) {
		$pedido = Model::factory('pedido')->where('id', $id)->find_one();
		return $pedido;
	}
	public static function getAll() {
		return Model::factory('pedido')->find_many();
	}
}

class pedido extends Model {
}
