<?php

class controller_layout {

	public function ecobolsa() {
		Flight::render('ecobolsa',null,'layout');
	}

	public function comocomprar() {
		Flight::render('comocomprar',null,'layout');
	}

	public function quienessomos() {
		Flight::render('quienessomos',null,'layout');
	}

	public function contacto() {
		Flight::render('contacto',null,'layout');
	}
}
