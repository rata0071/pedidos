<?php

class controller_admin {

	public function pedidos() {
		$view = Flight::View();
		if ( auth::isLoggedIn() && model_auth::getCurrent()->isAdmin() ) {

			if ( $_GET['q'] ) {
				$q = $_GET['q'];
				Flight::clearFlash('q');
				Flight::flash('q',$q);
			} elseif ( Flight::flash('q') ) {
				$q = Flight::flash('q');
				$q = array_pop($q);
			} else {
				$q = array('fecha_entrega'=>date('Y-m-d'), 'estado'=>array('confirmado','sinconfirmar','enviaje'), 'horario'=>model_horario::getAllIds());
			}

			$pedidos = model_pedido::search($q);
			$view->set('pedidos',$pedidos);
			$view->set('q',$q);
			Flight::render('admin_pedidos',null,'layout');
		} else {
			Flight::redirect('/');
		}
	}

	public function actualizar() {
		if ( auth::isLoggedIn() && model_auth::getCurrent()->isAdmin() ) {

			switch ( $_POST['action'] ) {
				case 'confirmar':
					self::confirmar();
					break;
				case 'enviar':
					self::enviar();
					break;
				case 'entregado':
					self::entregado();
					break;
				case 'cancelar':
					self::cancelar();
					break;
				default:
					Flight::flash('message',array('type'=>'warning','text'=>'No seleccionaste ninguna acción.'));
					break;
			}

			Flight::redirect('/admin/pedidos');
		} else {
			Flight::redirect('/');
		}
	}

	public function enviar() {
		foreach ( $_POST['pedido'] as $pedido_id ) {
			$pedido = model_pedido::getById($pedido_id);
			$pedido->enviar();
		}
		Flight::flash('message',array('type'=>'success','text'=>count($_POST['pedido']).' pedidos enviados.'));
	}

	public function entregado() {
		foreach ( $_POST['pedido'] as $pedido_id ) {
			$pedido = model_pedido::getById($pedido_id);
			$pedido->entregado();
		}
		Flight::flash('message',array('type'=>'success','text'=>count($_POST['pedido']).' pedidos entregados.'));
	}

	public function confirmar() {
		foreach ( $_POST['pedido'] as $pedido_id ) {
			$pedido = model_pedido::getById($pedido_id);
			$pedido->confirmar();
		}
		Flight::flash('message',array('type'=>'success','text'=>count($_POST['pedido']).' pedidos confirmados.'));
	}

	public function cancelar() {
		foreach ( $_POST['pedido'] as $pedido_id ) {
			$pedido = model_pedido::getById($pedido_id);
			$pedido->cancelar();
		}
		Flight::flash('message',array('type'=>'success','text'=>count($_POST['pedido']).' pedidos cancelados.'));
	}
}
