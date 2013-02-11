<h1>Home</h1>

<div class="row-fluid">
<?php foreach ( $productos as $producto ) : ?>
	<span class="span4">
		<h2><?= View::e($producto->nombre) ?></h2>
		<span class="descripcion">
			<?= $producto->descripcion ?>
		</span>
		<a href="/pedido?p[<?= (int)$producto->id ?>]=1" class="btn">Pedir ahora!</a>
	</span>
<?php endforeach ?>
</div>
