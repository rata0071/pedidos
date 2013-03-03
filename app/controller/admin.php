<?php

class controller_admin {

	public function pedidos() {
		$view = Flight::View();
		if ( auth::isLoggedIn() && model_auth::getCurrent()->isAdmin() ) {
			if ( $_GET['q'] ) {
				$q = $_GET['q'];
			} else {
				$q = array('fecha_entrega'=>date('Y-m-d'), 'estado'=>array('confirmado','sinconfirmar','enviaje'));
			}
			$pedidos = model_pedido::search($q);
			$view->set('pedidos',$pedidos);
			$view->set('q',$q);
			Flight::render('admin_pedidos',null,'layout');
		} else {
			Flight::redirect('/');
		}
	}

}
