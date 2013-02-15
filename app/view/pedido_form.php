<h1>Arma tu pedido</h1>

<form action="<?= View::makeUri('/pedido') ?>" method="post">

<h2>Productos</h2>
<?php foreach ( $productos as $producto ) : ?>
<span class="row-fluid">
	<span class="span4"><?= View::e($producto->nombre) ?></span>
	<span class="span4"><input class="input-smallest" type="number" value="<?= $datos ? (int)$datos['p'][$producto->id] : (int)$cantidades[$producto->id] ?>" name="p[<?= $producto->id ?>]"/></span>
</span>
<?php endforeach ?>

<h2>A donde enviarlo</h2>

<span class="row-fluid">
	<div class="input-prepend span4"><span class="add-on"><i class="icon-user"></i> Nombre </span> <input type="text" name="nombre" value="<?= $datos ? View::e($datos['nombre']) : '' ?>" /></div>
	<div class="input-prepend span4"><span class="add-on"><i class="icon-user"></i> Apellido </span> <input type="text" name="apellido" value="<?= $datos ? View::e($datos['apellido']) : '' ?>" /></div>
</span>

<span class="row-fluid">
	<div class="input-prepend span4"><span class="add-on"><i class="icon-home"></i> Dirección </span> <input type="text" name="direccion" id="direccion" value="<?= $datos ? View::e($datos['direccion']) : '' ?>" /></div>
	<input type="hidden" name="calle" id="calle" value="<?= $datos ? View::e($datos['calle']) : '' ?>" />
	<input type="hidden" name="numero" id="numero" value="<?= $datos ? View::e($datos['numero']) : '' ?>" />
	<input type="hidden" name="barrio" id="barrio" value="<?= $datos ? View::e($datos['barrio']) : '' ?>" />
	<input type="hidden" name="barrio_id" id="barrio_id" value="<?= $datos ? View::e($datos['barrio_id']) : '0' ?>" />
	<div class="input-prepend span2"><span class="add-on"><i class="icon-home"></i> Piso </span> <input type="text" class="input-small" name="piso" value="<?= $datos ? View::e($datos['piso']) : '' ?>" /></div>
	<div class="input-prepend span2"><span class="add-on"><i class="icon-home"></i> Depto</span> <input type="text" class="input-small" name="depto" value="<?= $datos ? View::e($datos['depto']) : '' ?>" /></div>
</span>

<span class="row-fluid">
	<div class="input-prepend span4"><span class="add-on"><i class="icon-phone"></i> Telefono </span> <input type="text" name="telefono" value="<?= $datos ? View::e($datos['telefono']) : '' ?>" /></div>
	<div class="input-prepend span4"><span class="add-on"><i class="icon-envelope"></i> Email </span> <input type="text" name="email" value="<?= $datos ? View::e($datos['email']) : '' ?>" /></div>
</span>

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
	<input type="hidden" name="horario_id" id="horario_id" value="<?= $datos ? View::e($datos['horario_id']) : '' ?>" />
</span>

<br />
<button class="btn submit">Hacer pedido</button>

</form>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>//<!--
var barrios = <?= $barrios ?>,
	horarios = <?= $horarios ?>,
	recorridos = <?= $recorridos ?>;
//--></script>
