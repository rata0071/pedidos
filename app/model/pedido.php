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
	private $user = false;

	public function enviarConfirmacion() {
		require( MAILER_PATH."/class.phpmailer.php" );
		$mail = new PHPMailer();

		$mail->From = "pedidos@viveverde.com.ar";
		$mail->FromName = "Vive Verde";
		$mail->AddAddress($this->getUser()->email);
		$link = $this->getConfirmacionLink();
		$_link = View::e( $link );

		$mail->Subject = "Confirma tu pedido - Vive Verde";
		$mail->Body = 'Por favor confirma que los datos de este pedido son correctos haciendo <a href="'.$_link.'" target="_blank">click aqui</a> o ingresando a esta dirección: '.$_link;
		$mail->IsHTML(true);
		$mail->AltBody = 'Por favor confirma que los datos de este *pedido son correctos* ingresando a esta direccion: '.$link;

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
		return strtotime($this->fecha_entrega) > time();
	}

	public function checkChallenge($c) {
		return $this->getUser()->getAuth()->challenge == trim($c);
	}

	public function confirmar() {
		$this->estado = 'confirmado';
		$this->save();

		$this->getUser()->getAuth()->resetChallenge();
	}
}
