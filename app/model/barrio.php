<?php

class model_barrio {

	public static function getById( $id ) {
		return Model::factory('barrio')->where('id', $id)->find_one();
	}
	public static function getAll() {
		return Model::factory('barrio')->find_many();
	}
	public static function getAllJson() {
		$barrios = self::getAll();
		$a = array();
		foreach ( $barrios as $barrio ) {
			$a[$barrio->id] = $barrio->nombre;
		}
		return json_encode($a);
	}
}

class barrio extends Model {
}
