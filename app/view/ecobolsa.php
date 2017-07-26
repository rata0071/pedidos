<h1>Ecobolsas de la semana</h1>
<p><strong>Disfruta cada semana de los productos más frescos, ricos y saludables</strong></p>

<?php foreach ( model_producto::getAll() as $ecobolsa ) : ?>
<div class="row-fluid">

	<div class="span8">
	<h2><?= View::e($ecobolsa->nombre)  ?></h2>
	<?= $ecobolsa->descripcion ?>
	</div>

	<div class="span4">
		<div class="columnacentral"><div class="preciotapa">Por sólo<br><span style="color:#bacb45; font-size:72px;">$<?= $ecobolsa->precio ?></span></div></div>
		<a href="<?= View::makeUri('/pedido?p['.$ecobolsa->id.']=1') ?>" class="pedido"/>Pedila ahora >>></a>
	</div>

</div>
<?php endforeach ?>

<script src="<?= View::makeUri('/assets/js/main.js') ?>"></script>
