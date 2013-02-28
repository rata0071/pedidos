<?php

class mail {

	public static function newmail() {
		require_once( MAILER_PATH."/class.phpmailer.php" );
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';
		$mail->From = "info@viveverde.com.ar";
		$mail->FromName = SITE;
		$mail->AddReplyTo("info@viveverde.com.ar", SITE);
		$mail->WordWrap = 70;

		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->Host = "mail.viveverde.com.ar"; 
		$mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = "info@viveverde.com.ar"; 
        $mail->Password = "todalavibra";

		return $mail;
	}
}
