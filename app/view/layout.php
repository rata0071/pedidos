<!doctype html>
<html land="es">
<head>
	<meta charset="UTF-8" />
	<title>Vive Verde</title>
	<meta name="description" content="Frutas y verduras a tu puerta, elegilas online." />

	<script src="<?= View::makeUri('/assets/js/jquery.js') ?>"></script>
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/bootstrap.min.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/font-awesome.min.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/ui-lightness/jquery-ui-1.10.0.custom.min.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/main.css') ?>" />
</head>
<body>
	<header class="navbar navbar-fixed-top">
		<div class='navbar-inner'>
		<div class="container">
		<a href="<?= View::makeUri('/') ?>">Inicio</a>
		<a href="<?= View::makeUri('/pedido') ?>">Hacer pedido</a>
		<?php if ( auth::isLoggedIn() ) : ?>
			<?php if ( model_auth::getCurrent()->isAdmin() ) : ?>
			<div class="btn-group inline pull-right">
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-lock"></i> Admin </a>
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?= View::makeUri('/admin/pedidos') ?>"><i class="icon-truck"></i> Pedidos</a></li>
				</ul>
			</div>
			<?php endif ?>
		<div class="btn-group inline pull-right">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user"></i> <?= View::e(model_auth::getCurrent()->getUser()->nombre) ?></a>
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
			<ul class="dropdown-menu">
				<li><a href="<?= View::makeUri('/pedido') ?>"><i class="icon-truck"></i> Ver pedidos</a></li>
				<li class="divider"></li>
				<li><a href="<?= View::makeUri('/user/datos') ?>"><i class="icon-cog"></i> Cambiar datos</a></li>
				<li><a href="<?= View::makeUri('/auth/password') ?>"><i class="icon-lock"></i> Cambiar contraseña</a></li>
				<li class="divider"></li>
				<li><a href="<?= View::makeUri('/auth/logout') ?>"><i class="icon-signout"></i> Salir</a></li>
			</ul>
		</div>
		<?php else : ?>
		<div class="btn-group inline pull-right">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-signin"></i> Entrar</a>
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
			<ul class="dropdown-menu" style="padding: 10px">
				<form action="<?= View::makeUri('/auth/login') ?>" method="post">
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span> <input type="text" name="email" placeholder="Email" /></div>
				<div class="input-prepend"><span class="add-on"><i class="icon-lock"></i></span> <input type="password" name="password" placeholder="**********" /></div>
				<small><a href="<?= View::makeUri('/auth/forgotpassword') ?>">¿Olvidaste tu contraseña?</a></small>
				<button type="submit" class="btn pull-right">Entrar</button>
				</form>
			</ul>
		</div>
		<?php endif ?>
		</div>
		</div>
	</header>

	<div class="container">
		<content>
		<?php foreach ( Flight::flash('message') as $message ) : ?>
			<div class="alert alert-<?= View::e($message['type']) ?>">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<i class="<?= isset($message['icon']) ? View::e('icon-'.$message['icon']) : 'icon-exclamation-sign' ?>"></i> <?= View::e($message['text']) ?>
			</div>
		<?php endforeach ?>
		<?php Flight::clearFlash('message') ?>
		<?= $content ?>
		</content>
	</div>

	<footer>
	</footer>

	<script src="<?= View::makeUri('/assets/js/jqBootstrapValidation.js') ?>"></script>
	<script>$(document).ready(function(){$('.dropdown-menu').find('form').click(function(e){e.stopPropagation();});});</script>
	<script src="<?= View::makeUri('/assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?= View::makeUri('/assets/js/jquery-ui.js') ?>"></script>
</body>
</html>
