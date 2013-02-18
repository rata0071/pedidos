<?php

class model_recorrido {

	public static function getById( $id ) {
		return Model::factory('recorrido')->where('id', $id)->find_one();
	}
	public static function getAll() {
		return Model::factory('recorrido')->find_many();
	}

	public static function getAllJson() {
		$recorridos = self::getAll();
		$a = array();
		foreach ( $recorridos as $recorrido ) {
			if ( ! isset( $a[$recorrido->barrio_id] ) ) {
				$a[$recorrido->barrio_id] = array();
			}
			if ( ! isset( $a[$recorrido->barrio_id][$recorrido->horario_id] ) ) {
				$a[$recorrido->barrio_id][$recorrido->horario_id] = array('domingo'=>0,'lunes'=>0,'martes'=>0,'miercoles'=>0,'jueves'=>0,'viernes'=>0,'sabado'=>0);
			}
			$a[$recorrido->barrio_id][$recorrido->horario_id]['domingo'] += $recorrido->domingo;
			$a[$recorrido->barrio_id][$recorrido->horario_id]['lunes'] += $recorrido->lunes;
			$a[$recorrido->barrio_id][$recorrido->horario_id]['martes'] += $recorrido->martes;
			$a[$recorrido->barrio_id][$recorrido->horario_id]['miercoles'] += $recorrido->miercoles;
			$a[$recorrido->barrio_id][$recorrido->horario_id]['jueves'] += $recorrido->jueves;
			$a[$recorrido->barrio_id][$recorrido->horario_id]['viernes'] += $recorrido->viernes;
			$a[$recorrido->barrio_id][$recorrido->horario_id]['sabado'] += $recorrido->sabado;
		}
		return json_encode($a);
	}

	public static function getFechaDisponible($fecha_entrega, $horario_id, $barrio_id) {
		$dias = array('domingo','lunes','martes','miercoles','jueves','viernes','sabado');
		$dw = date('w',strtotime($fecha_entrega));
		$dia = $dias[$dw];
		$recorrido = Model::factory('recorrido')->where('barrio_id',$barrio_id)->where('horario_id',$horario_id)->where($dia,'1')->find_one();
		return $recorrido;
	}
}

class recorrido extends Model {
}
