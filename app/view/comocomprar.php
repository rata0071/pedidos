<div class="row-fluid">
	<div class="span8">
		<h1>¿Como comprar?</h1>

		<p>Comprar en Vive Verde es muy fácil solo sigue estos simples pasos.</p>
		<p><img alt="Como comprar comida saludable por internet" src="/assets/img/como-comprar.png" border="0" /></p>
		<p>Luego de la primer compra ya puedes entrar con tu "email" y "contraseña" para no volver a cargar tus datos.</p>
		<p>Si tienes alguna duda o sugerencia sobre el funcionamiento del sitio no dudes en escribirnos desde la sección de contacto.</p>

	</div>
<?php $ecobolsa = model_producto::getById(2) ?>
	<div class="span4">
		<div class="columnacentral"><div class="preciotapa">Por sólo<br><span style="color:#bacb45; font-size:72px;">$<?= $ecobolsa->precio ?></span></div></div>
		<a href="<?= View::makeUri('/pedido?p['.$ecobolsa->id.']=1') ?>" class="pedido"/>Pedila ahora >>></a>
	</div>

</div>
<script src="<?= View::makeUri('/assets/js/main.js') ?>"></script>
