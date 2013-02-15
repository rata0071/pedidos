<?php

class model_horario {

	public static function getById( $id ) {
		return Model::factory('horario')->where('id', $id)->find_one();
	}
	public static function getAll() {
		return Model::factory('horario')->find_many();
	}
	public static function getAllJson() {
		$horarios = self::getAll();
		foreach ( $horarios as $horario ) {
			$a[$horario->id] = $horario->descripcion;
		}
		return json_encode($a);
	}
}

class horario extends Model {
}
