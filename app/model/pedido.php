<?php

class model_pedido {

	public static function getById( $id ) {
		return Model::factory('pedido')->find_one( $id );
	}

	public static function getAll() {
		return Model::factory('pedido')->find_many();
	}

	public static function search($q) {
		$search = ORM::for_table('pedido')->select('pedido.id')->
			join('user',array('user.id','=','pedido.user_id'))->
			join('recorrido',array('recorrido.id','=','pedido.recorrido_id'));

		if ( $q['fecha_entrega'] ) {
			$search = $search->where('pedido.fecha_entrega',$q['fecha_entrega']);
		}

		if ( is_array($q['estado']) && count($q['estado']) ) {
			$search = $search->where_in('pedido.estado',$q['estado']);
		}

		if ( $q['cliente'] ) {
			$cliente = '%'.$q['cliente'].'%';
			$search = $search->where_raw('(user.nombre LIKE ? OR user.apellido LIKE ? OR user.email LIKE ?)', array($cliente,$cliente,$cliente));
		}

		if ( is_array($q['horario']) && count($q['horario']) ) {
			$search = $search->where_in('recorrido.horario_id',$q['horario']);
		}
	
		$return = array();
		foreach ( $search->find_many() as $pedido ) {
			$return[] = Model::factory('pedido')->find_one($pedido->id);
		}

		return $return;
	}
}

class pedido extends Model {
	private $user = false, $horario = false;

	public function items() {
		return $this->has_many('item');
	}

	public function getHorario() {
		if ( ! $this->horario ) {
			$recorrido = model_recorrido::getById($this->recorrido_id);
			$this->horario = $recorrido->getHorario();
		}
		return $this->horario;
	}

	public function enviarConfirmacion() {
		$mail = mail::newmail();
		$mail->AddAddress($this->getUser()->email, $this->getUser()->nombre);

		$this->getUser()->getAuth()->resetChallenge();
		$link = $this->getConfirmacionLink();
		$_link = View::e( $link );

		$mail->IsHTML(true);
		$mail->Subject = "Confirma tu pedido - ".SITE;
		$mail->Body = 'Por favor confirma que los datos de tu pedido son correctos haciendo <a href="'.$_link.'" target="_blank">click aqui</a> o ingresando a esta dirección: '.$_link;
		$mail->AltBody = 'Por favor confirma que los datos de tu pedido son correctos ingresando a esta direccion: '.$link;

		if(!$mail->Send()) {
			error_log('Mailer error: '.$mail->ErrorInfo);
			return array(false,'Mailer error: '.$mail->ErrorInfo);
		} else {
			return array(true,'');
		}
	}

	public function getUser() {
		if ( ! $this->user ) {
			$this->user = model_user::getById($this->user_id);
		}
		return $this->user;
	}

	public function getConfirmacionLink() {
		return View::makeUri('pedido/'.$this->id.'/confirmar?c='.$this->getUser()->getAuth()->challenge);
	}

	public function expiro() {
		return (strtotime($this->fecha_entrega) + (8*3600)) < time();
	}

	public function puedeCancelar() {
		return (strtotime($this->fecha_entrega) + (8*3600)) > time();
	}

	public static function validar($datos) {
		$errores = array();
		$ok = true;
		if ( array_sum($datos[p]) < 1 ) {
			$ok = false;
			$errores[] = 'No seleccionaste ningún producto.';
		}

		if ( $datos['tipo'] == 'entrega' && ! model_recorrido::getFechaDisponible($datos['fecha_entrega'], $datos['horario_id'], $datos['barrio_id']) ) {
			$ok = false;
			$errores[] = 'El horario o fecha no esta disponible.';
		}

		return array( $ok, $errores);
	}

	public function confirmar() {
		$this->estado = 'confirmado';
		$this->save();

	}

	public function enviar() {
		$this->estado = 'enviaje';
		$this->save();
	}

	public function entregado() {
		$this->estado = 'entregado';
		$this->save();
	}

	public function cancelar() {
		$this->estado = 'cancelado';
		$this->save();
	}
}
