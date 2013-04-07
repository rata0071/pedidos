<h1>Ecobolsa de la semana</h1>

<div class="row-fluid">

	<div class="span8">
	<p><strong>Disfruta cada semana de los productos más frescos, ricos y saludables</strong></p>

	<?php 
	$ecobolsa = model_producto::getById(1);
	echo $ecobolsa->descripcion;
	?>
	</div>

	<div class="span4">
		<div class="columnacentral"><div class="preciotapa">Por sólo<br><span style="color:#bacb45; font-size:72px;">$<?= $ecobolsa->precio ?></span></div></div>
		<a href="<?= View::makeUri('/pedido?p[1]=1') ?>" class="pedido"/>Pedila ahora >>></a>
	</div>

</div>
<script src="<?= View::makeUri('/assets/js/main.js') ?>"></script>
