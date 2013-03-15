<?php

class model_horario {

	public static function getById( $id ) {
		return Model::factory('horario')->where('id', $id)->find_one();
	}
	public static function getAll() {
		return Model::factory('horario')->find_many();
	}
	public static function getAllIds() {
		$horarios = ORM::for_table('horario')->select('id')->find_many();
		$ids = array();
		foreach ( $horarios as $horario ) {
			$ids[] = $horario->id;
		}
		return $ids;
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
