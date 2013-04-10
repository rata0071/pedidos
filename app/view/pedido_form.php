<?php if ( auth::isLoggedIn() ) : ?>
<h2>Tus últimos pedidos</h2>

<table class="table table-hover">
<thead>
<tr>
<th>Fecha de entrega</th>
<th>Productos</th>
<th>Estado</th>
</tr>
</thead>
<tbody>
<?php foreach ( $pedidos as $p ) : ?>
	<tr>
		<td class="span2"><?= View::e($p->fecha_entrega) ?></td>
		<td class="span6">
		<ul>
		<?php foreach ( $p->items()->find_many() as $item ) : ?>
			<li><?= View::e('('.$item->cantidad.') '.$item->getProducto()->nombre) ?></li>
		<?php endforeach ?>
		</ul>
		</td>
		<td class="span4">
			<?php if ( $p->estado == 'sinconfirmar' ) : ?>
				<span class="label label-warning"><i class="icon-check-empty"></i> Sin confirmar</span>
			<?php elseif ( $p->estado == 'confirmado' ) : ?>
				<span class="label label-info"><i class="icon-check"></i> Confirmado</span>
			<?php elseif ( $p->estado == 'enviaje' ) : ?>
				<span class="label label-info"><i class="icon-truck"></i> En viaje</span>
			<?php elseif ( $p->estado == 'entregado' ) : ?>
				<span class="label label-success"><i class="icon-home"></i> Entregado</span>
			<?php else : 
				echo View::e($p->estado);
			 endif ?>
			<?php if ( $p->puedeCancelar() ) : ?>
			<a href="<?= View::makeUri('/pedido/'.$p->id.'/cancel?csrftoken='.$token ) ?>" class="btn btn-danger btn-small pull-right"><i class="icon-remove-sign icon-large"></i> Cancelar</a>
			<?php endif ?>
		</td>
	</tr>
<?php endforeach ?>
</tbody>
</table>
<?php endif ?>

<h1>Arma tu pedido</h1>

<form action="<?= View::makeUri('/pedido') ?>" method="post">

<div class="row-fluid">
<div class="span5">
¿Te lo llevamos o lo pasas a buscar?
<select name="tipo" id="tipo-pedido">
	<option value="entrega" id="tipo-entrega">Entrega a domicilio</option>
	<option value="retiro" id="tipo-retiro">Retirar por local</option>
</select>
</div>
<div class="span3"></div>
<div class="span4">
<h1>Radio de entrega</h1>

<p><img src="/assets/img/radio.png" alt="Radio de entrega ecobolsa Viveverde" /></p>

<div class="alert alert-block alert-warning" id="fuera-del-radio" style="display:none">Lo sentimos, aún no estas dentro del radio de entrega. Revisa la dirección ingresada.</div>

</div>
</div>

<hr />

<h2>Productos</h2>
<?php foreach ( $productos as $producto ) : ?>
<div class="row-fluid">
	<div class="span4"><?= View::e($producto->nombre) ?></div>
	<div class="span4"><input class="input-smallest" type="number" value="<?= $datos ? (int)$datos['p'][$producto->id] : (int)$cantidades[$producto->id] ?>" name="p[<?= $producto->id ?>]"/></div>
</div>
<?php endforeach ?>

<hr />

<h2>A donde enviarlo</h2>

<?php if ( ! auth::isLoggedIn() ) : ?>
	<?php include('_user_form.php') ?>
<?php else : ?>
	<?php $user = model_auth::getCurrent()->getUser() ?>
<div class="row-fluid">
	<div class="input-prepend span5"><span class="add-on"><i class="icon-user"></i> Nombre </span> <input type="text" name="nombre" value="<?= View::e($user->nombre) ?>" disabled="disabled" /></div>
	<div class="input-prepend span5"><span class="add-on"><i class="icon-user"></i> Apellido </span> <input type="text" name="apellido" value="<?= View::e($user->apellido)  ?>" disabled="disabled" /></div>
</div>

<div class="row-fluid">
	<div class="input-prepend span5"><span class="add-on"><i class="icon-home"></i> Dirección </span> <input type="text" name="direccion" id="direccion" value="<?= View::e($user->direccion) ?>" disabled="disabled" /></div>
	<input type="hidden" name="barrio_id" id="barrio_id" value="<?= View::e($user->barrio_id) ?>" />
	<div class="input-prepend span3"><span class="add-on"><i class="icon-home"></i> Piso </span> <input type="text" class="input-small" name="piso" value="<?= View::e($user->piso) ?>" disabled="disabled" /></div>
	<div class="input-prepend span2"><span class="add-on"><i class="icon-home"></i> Depto</span> <input type="text" class="input-small" name="depto" value="<?= View::e($user->depto) ?>" disabled="disabled" /></div>
</div>

<div class="row-fluid">
	<div class="input-prepend span5"><span class="add-on"><i class="icon-phone"></i> Telefono </span> <input type="text" name="telefono" value="<?= View::e($user->telefono) ?>" disabled="disabled" /></div>
	<div class="input-prepend span5"><span class="add-on"><i class="icon-envelope"></i> Email </span> <input type="text" name="email" value="<?= View::e($user->email) ?>" disabled="disabled" /></div>
</div>
<small class="row-fluid"><a href="<?= View::makeUri('/user/datos') ?>"><i class="icon-cog"></i> Cambiar datos personales</a></small>
<?php endif ?>

<hr />

<h2>Cuando entregarlo</h2>

<div class="row-fluid">
	<div class="span5" id="calendar"></div>
	<div class="span6"><div class="row-fluid" id="horarios_disponibles"></div></div>
	<input type="hidden" name="fecha_entrega" id="fecha_entrega" value="<?= $datos ? View::e($datos['fecha_entrega']) : '' ?>" />
	<input type="hidden" name="selected_horario_id" id="selected_horario_id" value="<?= $datos ? View::e($datos['horario_id']) : '' ?>" />
	<div class="clear"> </div>
</div>
<input type="hidden" name="csrftoken" value="<?= $token ?>" />
<br />
<button class="btn btn-large submit"><i class="icon-thumbs-up"></i> Hacer Pedido</i></button>

<hr />
<div class="row-fluid">
	<div class="span12">
		<p><i class="icon-pencil"></i> Observaciones, codigo de promoción, etc.</p>
		<textarea rows="3" class="input-block-level" name="observaciones"><?= $datos ? View::e($datos['observaciones']) : '' ?></textarea>
	</div>
	<div class="clear"> </div>
</div>

</form>

<script src="http://servicios.usig.buenosaires.gob.ar/usig-js/dev/usig.AutoCompleterFull.min.js"></script>
<script src="<?= View::makeUri('/assets/js/main.js') ?>"></script>
<script src="<?= View::makeUri('/assets/js/validation.js') ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>//<!--
var barrios = <?= model_barrio::getAllJson() ?>,
	horarios = <?= model_horario::getAllJson() ?>;
	var recorridos = {};
	recorridos[0] = {
		"1": {"domingo":0,"lunes":1,"martes":1,"miercoles":1,"jueves":1,"viernes":1,"sabado":0}, 
		"2": {"domingo":0,"lunes":1,"martes":1,"miercoles":1,"jueves":1,"viernes":1,"sabado":1}, 
		"3": {"domingo":0,"lunes":1,"martes":1,"miercoles":1,"jueves":1,"viernes":1,"sabado":1}, 
		"4": {"domingo":0,"lunes":1,"martes":1,"miercoles":1,"jueves":1,"viernes":1,"sabado":1}, 
		"5": {"domingo":0,"lunes":1,"martes":1,"miercoles":1,"jueves":1,"viernes":1,"sabado":0}, 
		"6": {"domingo":0,"lunes":1,"martes":1,"miercoles":1,"jueves":1,"viernes":1,"sabado":0},
		"7": {"domingo":0,"lunes":1,"martes":1,"miercoles":1,"jueves":1,"viernes":1,"sabado":0}, 
		"8": {"domingo":0,"lunes":1,"martes":1,"miercoles":1,"jueves":1,"viernes":1,"sabado":0}
		};
	var myLat = <?= json_encode(LAT) ?>,
	myLng = <?= json_encode(LNG) ?>, 
	maxRadius = <?= json_encode(RADIUS) ?>;
//--></script>
