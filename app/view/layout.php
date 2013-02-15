<!doctype html>
<html land="es">
<head>
	<meta charset="UTF-8" />
	<title>Vive Verde</title>
	<meta name="description" content="Frutas y verduras a tu puerta, elegilas online." />

	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/bootstrap.min.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/font-awesome.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/ui-lightness/jquery-ui-1.10.0.custom.min.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/main.css') ?>" />
</head>
<body>
	<header class="navbar navbar-fixed-top">
		<div class='navbar-inner'>
		<div class="container">
		<a href="<?= View::makeUri('/') ?>">Inicio</a>
		<a href="<?= View::makeUri('/pedido') ?>">Hacer pedido</a>

		</div>
		</div>
	</header>

	<div class="container">
		<content>
		<?php if ( Flight::get('error') ) : ?><span class="red"><i class="icon-exclamation-sign"></i> <?= Flight::get('error') ?></span><?php endif ?>
		<?php foreach ( Flight::get('errores') as $error ) : ?>
			<div class="alert alert-error"><i class="icon-exclamation-sign"></i> <?= View::e($error) ?></div>
		<?php endforeach ?>
		<?php if ( Flight::get('notice') ) : ?><span><i class="icon-exclamation-sign"></i> <?= Flight::get('notice') ?></span><?php endif ?>
		<?= $content ?>
		</content>
	</div>

	<footer>
	</footer>

	<script src="<?= View::makeUri('/assets/js/jquery.js') ?>"></script>
	<script>$(document).ready(function(){$('.dropdown-menu').find('form').click(function(e){e.stopPropagation();});});</script>
	<script src="<?= View::makeUri('/assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?= View::makeUri('/assets/js/jquery-ui.js') ?>"></script>
	<script src="http://servicios.usig.buenosaires.gob.ar/usig-js/dev/usig.AutoCompleterFull.min.js" type="text/javascript"></script>
	<script src="<?= View::makeUri('/assets/js/main.js') ?>"></script>
</body>
</html>
