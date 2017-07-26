
<div class="columna">
<h1>Esta semana te ofrecemos:</h1>
<?php $ecobolsa = model_producto::getById(2) ?>
<h2><?= $ecobolsa->nombre ?></h2>
<?= $ecobolsa->descripcion ?>
<br />
<a href="<?= View::makeUri('/ecobolsa') ?>">Ver más ecobolsas <i class="icon-double-angle-right"></i></a>
</div>
<div class="columna">
<div class="columnacentral"><div class="preciotapa">Por sólo<br><span style="color:#bacb45; font-size:72px;">$<?= $ecobolsa->precio ?></span></div></div>
<a href="<?= View::makeUri('/pedido?p[2]=1') ?>" class="pedido"/>Pedila ahora >>></a>
</div>
<div class="columna" style="margin:0;">
	<h1 style="height:40px; background:url('assets/img/camion.jpg') 0px -5px no-repeat; padding:0; margin:0;">Entrega a domicilio</h1>
	<div class="ecobolsa">ECOBOLSA<br><br><br><span style="color:#e3ea90; font-size:20px; line-height:20px;">La comodidad de recibir<br>productos de calidad<br>en su casa</span></div>
</div>
<script src="<?= View::makeUri('/assets/js/main.js') ?>"></script>
