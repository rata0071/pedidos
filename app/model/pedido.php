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
	public function enviarConfirmacion() {
		require( MAILER_PATH."/class.phpmailer.php" );
		$mail = new PHPMailer();

		$mail->From = "aza@example.com";
		$mail->AddAddress("rata0071@gmail.com");

		$mail->Subject = "Confirma tu pedido - Vive Verde";
		$mail->Body = 'Por favor confirma que los datos de este <strong>pedido son correctos</strong> haciendo <a href="'.View::makeUri('pedido/'.$this->id.'/confirmar').'">click aqui</a> o ingresando a esta dirección: '.View::makeUri('pedido/'.$this->id.'/confirmar');
		$mail->IsHTML(true);
		$mail->AltBody = 'Por favor confirma que los datos de este *pedido son correctos* ingresando a esta direccion '.View::makeUri('pedido/'.$this->id.'/confirmar');
		if(!$mail->Send()) {
			error_log('Mailer error: '.$mail->ErrorInfo);
			return array(false,'Mailer error: '.$mail->ErrorInfo);
		} else {
			return array(true,'');
		}
	}

	public function getUser() {
		return model_user::getById($this->user_id);
	}
}
