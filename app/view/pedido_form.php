<h1>Armá tu pedido</h1>

<form action="<?= View::makeUri('/pedido') ?>" method="post">

<h2>Productos</h2>
<?php foreach ( $productos as $producto ) : ?>
<span class="row-fluid">
	<span class="span4"><?= View::e($producto->nombre) ?></span>
	<span class="span4"><input class="input-smallest" type="number" value="<?= (int)$cantidades[$producto->id] ?>" name="p[<?= $producto->id ?>]"/></span>
</span>
<?php endforeach ?>

<h2>A donde enviarlo</h2>

<span class="row-fluid">
	<div class="input-prepend span4"><span class="add-on"><i class="icon-user"></i> Nombre </span> <input type="text" name="nombre" /></div>
	<div class="input-prepend span4"><span class="add-on"><i class="icon-user"></i> Apellido </span> <input type="text" name="apellido" /></div>
</span>

<span class="row-fluid">
	<div class="input-prepend span4"><span class="add-on"><i class="icon-home"></i> Dirección </span> <input type="text" name="direccion" id="direccion"/></div>
	<input type="hidden" name="calle" id="calle" />
	<input type="hidden" name="numero" id="numero" />
	<input type="hidden" name="barrio" id="barrio" />
	<div class="input-prepend span2"><span class="add-on"><i class="icon-home"></i> Piso </span> <input type="text" class="input-small" name="piso" /></div>
	<div class="input-prepend span2"><span class="add-on"><i class="icon-home"></i> Depto</span> <input type="text" class="input-small" name="depto" /></div>
</span>

<span class="row-fluid">
	<div class="input-prepend span4"><span class="add-on"><i class="icon-phone"></i> Telefono </span> <input type="text" name="telefono" /></div>
	<div class="input-prepend span4"><span class="add-on"><i class="icon-envelope"></i> Email </span> <input type="text" name="email" /></div>
</span>

<span class="row-fluid">
	<div class="span8">
		<p><i class="icon-pencil"></i> Observaciones, codigo de promoción, etc.</p>
		<textarea rows="3" class="input-block-level" name="observaciones"></textarea>
	</div>
</span>

<h2>Cuando entregarlo</h2>

<span class="row-fluid">
	<span class="span2" id="calendar"></span>
</span>

<br />
<button class="btn submit">Hacer pedido</button>

</form>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
