

<ul class="nav nav-tabs">
	<li><a href="#filtro" data-toggle="tab">Filtros</a></li>
	<li><a href="#mapa" data-toggle="tab" id="tab-mapa">Mapa</a></li>
</ul>
<div class="tab-content">

<div class="tab-pane" id="filtro">
<form action="<?= View::makeUri('/admin/pedidos') ?>" method="get">
<div class="row-fluid">
	<div class="span2">
		<div class="input-prepend"><span class="add-on"><i class="icon-calendar"></i></span> <input class="input-medium" id="filtro_fecha_entrega" type="text" name="q[fecha_entrega]" value="<?= View::e($q['fecha_entrega']) ?>" /></div>
	</div>

	<div class="span2">
		<input type="checkbox" name="q[estado][]" <?= in_array('sinconfirmar',$q['estado']) ? 'checked' : '' ?> value="sinconfirmar"/>
		<span class="label label-warning"><i class="icon-check-empty"></i> Sin confirmar</span><br />

		<input type="checkbox" name="q[estado][]" <?= in_array('confirmado',$q['estado']) ? 'checked' : '' ?> value="confirmado" />
		<span class="label label-info"><i class="icon-check"></i> Confirmado</span><br />

		<input type="checkbox" name="q[estado][]" <?= in_array('enviaje',$q['estado']) ? 'checked' : '' ?> value="enviaje" />
		<span class="label label-info"><i class="icon-truck"></i> En viaje</span><br />

		<input type="checkbox" name="q[estado][]" <?= in_array('entregado',$q['estado']) ? 'checked' : '' ?> value="entregado" />
		<span class="label label-success"><i class="icon-home"></i> Entregado</span><br />

		<input type="checkbox" name="q[estado][]" <?= in_array('cancelado',$q['estado']) ? 'checked' : '' ?> value="cancelado" />
		<span class="label label-important"><i class="icon-remove-sign"></i> Cancelado</span><br />
	</div>

	<div class="span2">
		<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input class="input-medium" type="text" name="q[cliente]" value="<?= View::e($q['cliente']) ?>" /></div>
		<small><i class="icon-info-sign"></i> Busca nombre, apellido o mail.</small>
	<div>
	<div class="span2">
		<input type="submit" value="Filtrar" class="btn submit" />
	</div>
</div>
</form>
</div>

<div class="tab-pane" id="mapa">
<div class="row-fluid">
	<div class="span12" style="height:350px" id="map_canvas">
	</div>
</div>
</div>

<form action="<?= View::makeUri('/admin/actualizar') ?>" method="post">
<div class="row-fluid">
	<div class="offset9 span2">
		<div class="input-prepend"><span class="add-on"><i class="icon-cog"></i></span>
		<select name="action" class="input-medium">
			<option>-- acciones --</option>
			<option value="enviar">Enviar</option>
			<option value="entregado">Entregado</option>
		</select>
		</div>
	</div>
	<div class="span1">
	<input type="submit" value="Aplicar" class="btn submit btn-danger" />
	</div>
</div>
<table class="table table-hover">
<thead>
<tr>
<th class="span2">Fecha de entrega</th>
<th class="span2">Horario</th>
<th class="span2">Cliente</th>
<th class="span2">Dirección</th>
<th class="span2">Productos</th>
<th class="span2">Estado</th>
</tr>
</thead>
<tbody>
<?php foreach ( $pedidos as $p ) : ?>
	<tr>
		<td><?= $p->fecha_entrega == date('Y-m-d') ? 'Hoy' : View::e($p->fecha_entrega) ?></td>
		<td><?= View::e($p->getHorario()->descripcion) ?></td>
		<td><?= View::e($p->getUser()->nombre.' '.$p->getUser()->apellido) ?></td>
		<td><?= View::e($p->getUser()->direccion) ?></td>
		<td>
		<ul>
		<?php foreach ( $p->items()->find_many() as $item ) : ?>
			<li><?= View::e('('.$item->cantidad.') '.$item->getProducto()->nombre) ?></li>
		<?php endforeach ?>
		</ul>
		</td>
		<td>
			<?php if ( $p->estado == 'sinconfirmar' ) : ?>
				<span class="label label-warning"><i class="icon-check-empty"></i> Sin confirmar</span>
			<?php elseif ( $p->estado == 'confirmado' ) : ?>
				<span class="label label-info"><i class="icon-check"></i> Confirmado</span>
			<?php elseif ( $p->estado == 'enviaje' ) : ?>
				<span class="label label-info"><i class="icon-truck"></i> En viaje</span>
			<?php elseif ( $p->estado == 'entregado' ) : ?>
				<span class="label label-success"><i class="icon-home"></i> Entregado</span>
			<?php elseif ( $p->estado == 'cancelado' ) : ?>
				<span class="label label-important"><i class="icon-remove-sign"></i> Cancelado</span>
			<?php else : 
				echo View::e($p->estado);
			 endif ?>
			 <input class="pull-right" type="checkbox" name="pedido[]" value="<?= $p->id ?>" />
		</td>
	</tr>
<?php endforeach ?>
</tbody>
</table>

</form>

<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="<?= View::makeUri('/assets/js/admin.js') ?>"></script>
