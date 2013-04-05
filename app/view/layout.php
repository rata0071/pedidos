<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<title><?= SITE ?></title>
	<meta name="description" content="Disfruta cada semana de las comidas y alimentos más frescos, ricos y saludables." />

	<script src="<?= View::makeUri('/assets/js/jquery.js') ?>"></script>
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/bootstrap.min.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/font-awesome.min.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/ui-lightness/jquery-ui-1.10.0.custom.min.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/style.css') ?>" />
</head>
<body>


	<div id="todo">
    	<div id="header">
        <a href="<?= View::makeUri('/') ?>" title="ViveVerde"><img src="/assets/img/botontrsansp.png" alt="inicio" width="410" height="298" class="botontransp"/></a>

		<div class="span3 pull-right topbtn">
		<div class="row-fluid">
		<div class="span4">
			<div class="fb-like" data-href="https://www.facebook.com/pages/Viveverde/149137775245548" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false"></div>
		</div>

		<div class="span8">
		<?php if ( auth::isLoggedIn() ) : ?>
			<?php if ( model_auth::getCurrent()->isAdmin() ) : ?>
			<div class="btn-group inline pull-right">
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-lock"></i> Admin </a>
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?= View::makeUri('/admin/pedidos') ?>"><i class="icon-truck"></i> Pedidos</a></li>
					<li class="divider"></li>
					<li><a href="<?= View::makeUri('/auth/password') ?>"><i class="icon-lock"></i> Cambiar contraseña</a></li>
					<li class="divider"></li>
					<li><a href="<?= View::makeUri('/auth/logout') ?>"><i class="icon-signout"></i> Salir</a></li>
				</ul>
			</div>
			<?php else : ?>
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
			<?php endif ?>
		<?php else : ?>
		<div class="btn-group inline pull-right">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-signin"></i> Entrar</a>
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
			<ul class="dropdown-menu" style="padding: 10px">
				<form action="<?= View::makeUri('/auth/login') ?>" method="post">
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span> <input type="text" name="email" placeholder="Email" /></div> <br />
				<div class="input-prepend"><span class="add-on"><i class="icon-lock"></i></span> <input type="password" name="password" placeholder="**********" /></div> <br />

				<small><a href="<?= View::makeUri('/auth/forgotpassword') ?>">¿Olvidaste tu contraseña?</a></small> <br />

				<button type="submit" class="btn pull-right">Entrar</button>
				</form>
			</ul>
		</div>
		<?php endif ?>
		</div>
		</div>
</div>
            	<ul class="menuprincipal">
            	<li><a href="<?= View::makeUri('/ecobolsa') ?>">ECOBOLSA DE LA SEMANA</a></li>
                <li><a href="<?= View::makeUri('/como-comprar') ?>">¿CÓMO COMPRAR?</a></li>
                <li><a href="<?= View::makeUri('/quienes-somos') ?>">QUIENES SOMOS</a></li>
                <li style="margin:0;" ><a href="<?= View::makeUri('/contacto') ?>">CONTACTO</a></li>
            	</ul>
		</div>

		<div class="content">
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

 		<footer id="footer">
			<div id="copyright">© Viveverde 2013. Todos los derechos reservados. </div>
			<div id="footerlinks">
				<a href="<?= View::makeUri('/ecobolsa') ?>" style="border-left:1px solid #d9b26f;">Ecobolsa de la semana</a>
				<a href="<?= View::makeUri('/como-comprar') ?>">¿Como comprar?</a>
				<a href="<?= View::makeUri('/quienes-somos') ?>">Quienes somos</a>
				<a href="<?= View::makeUri('/contacto') ?>">Contacto</a>
			</div>

<style>a.gangastyle { opacity:0.7; position:relative; top:84px; left:486px; } a.gangastyle:hover { opacity:1 }</style>
<a class="gangastyle" href="http://gangastyle.com.ar" title="GangaStyle - Pedidos y delivery por Internet"><img src="http://gangastyle.com.ar/assets/img/gangastyle.png" alt="GangaStyle"></a>

		</footer>

	<script src="<?= View::makeUri('/assets/js/jqBootstrapValidation.js') ?>"></script>
	<script>$(document).ready(function(){$('.dropdown-menu').find('form').click(function(e){e.stopPropagation();});});</script>
	<script src="<?= View::makeUri('/assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?= View::makeUri('/assets/js/jquery-ui.js') ?>"></script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>
