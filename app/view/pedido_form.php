<h1>Arma tu pedido</h1>

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

<form action="<?= View::makeUri('/pedido') ?>" method="post">

<h2>Productos</h2>
<?php foreach ( $productos as $producto ) : ?>
<span class="row-fluid">
	<span class="span4"><?= View::e($producto->nombre) ?></span>
	<span class="span4"><input class="input-smallest" type="number" value="<?= $datos ? (int)$datos['p'][$producto->id] : (int)$cantidades[$producto->id] ?>" name="p[<?= $producto->id ?>]"/></span>
</span>
<?php endforeach ?>

<h2>A donde enviarlo</h2>

<?php if ( ! auth::isLoggedIn() ) : ?>
	<?php include('_user_form.php') ?>
<?php else : ?>
	<?php $user = model_auth::getCurrent()->getUser() ?>
<span class="row-fluid">
	<div class="input-prepend span4"><span class="add-on"><i class="icon-user"></i> Nombre </span> <input type="text" name="nombre" value="<?= View::e($user->nombre) ?>" disabled="disabled" /></div>
	<div class="input-prepend span4"><span class="add-on"><i class="icon-user"></i> Apellido </span> <input type="text" name="apellido" value="<?= View::e($user->apellido)  ?>" disabled="disabled" /></div>
</span>

<span class="row-fluid">
	<div class="input-prepend span4"><span class="add-on"><i class="icon-home"></i> Dirección </span> <input type="text" name="direccion" id="direccion" value="<?= View::e($user->direccion) ?>" disabled="disabled" /></div>
	<input type="hidden" name="barrio_id" id="barrio_id" value="<?= View::e($user->barrio_id) ?>" />
	<div class="input-prepend span2"><span class="add-on"><i class="icon-home"></i> Piso </span> <input type="text" class="input-small" name="piso" value="<?= View::e($user->piso) ?>" disabled="disabled" /></div>
	<div class="input-prepend span2"><span class="add-on"><i class="icon-home"></i> Depto</span> <input type="text" class="input-small" name="depto" value="<?= View::e($user->depto) ?>" disabled="disabled" /></div>
</span>

<span class="row-fluid">
	<div class="input-prepend span4"><span class="add-on"><i class="icon-phone"></i> Telefono </span> <input type="text" name="telefono" value="<?= View::e($user->telefono) ?>" disabled="disabled" /></div>
	<div class="input-prepend span4"><span class="add-on"><i class="icon-envelope"></i> Email </span> <input type="text" name="email" value="<?= View::e($user->email) ?>" disabled="disabled" /></div>
</span>
<small class="row-fluid"><a href="<?= View::makeUri('/user/datos') ?>"><i class="icon-cog"></i> Cambiar datos personales</a></small>
<?php endif ?>
<br />
<span class="row-fluid">
	<div class="span8">
		<p><i class="icon-pencil"></i> Observaciones, codigo de promoción, etc.</p>
		<textarea rows="3" class="input-block-level" name="observaciones"><?= $datos ? View::e($datos['observaciones']) : '' ?></textarea>
	</div>
</span>

<h2>Cuando entregarlo</h2>

<span class="row-fluid">
	<span class="span3" id="calendar"></span>
	<span class="span3" id="horarios_disponibles"></span>
	<input type="hidden" name="fecha_entrega" id="fecha_entrega" value="<?= $datos ? View::e($datos['fecha_entrega']) : '' ?>" />
	<input type="hidden" name="selected_horario_id" id="selected_horario_id" value="<?= $datos ? View::e($datos['horario_id']) : '' ?>" />
</span>
<input type="hidden" name="csrftoken" value="<?= $token ?>" />
<br />
<input type="submit" value="Hacer pedido" class="btn submit" />
</form>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>//<!--
<?php
		$horarios = model_horario::getAllJson();
		$barrios = model_barrio::getAllJson();
		$recorridos = model_recorrido::getAllJson();
?>
var barrios = <?= $barrios ?>,
	horarios = <?= $horarios ?>,
	recorridos = <?= $recorridos ?>;
//--></script>
