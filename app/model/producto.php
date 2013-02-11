<?php

class model_producto {

	public static function getById( $id ) {
		$producto = Model::factory('producto')->where('id', $id)->find_one();
		return $producto;
	}

	public static function getAll() {
		return Model::factory('producto')->find_many();
	}
}

class producto extends Model {
}
