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
		<h1 style="height:40px; background:url('assets/img/camion.jpg') 0px -5px no-repeat; padding:0; margin:0;">Entrega a domicilio</h1>
		<div class="ecobolsa">ECOBOLSA<br><br><br><span style="color:#e3ea90; font-size:20px; line-height:20px;">La comodidad de recibir<br>productos de calidad<br>en su casa</span></div>
	</div>

</div>
