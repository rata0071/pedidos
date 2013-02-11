<?php

class controller_producto {

	public function home() {
		$view = Flight::View();
		$view->set('productos',model_producto::getAll());
		Flight::render('home',null,'layout');
	}
}
