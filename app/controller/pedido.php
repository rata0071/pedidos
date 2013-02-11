<?php

class controller_pedido {

	public function nuevo() {
		$view = Flight::View();
		$view->set('productos',model_producto::getAll());
		$view->set('cantidades',$_GET['p']);
		Flight::render('pedido_form',null,'layout');
	}


	public function encargar() {
		var_dump($_POST);	
	}
}
