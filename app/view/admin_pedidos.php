
<ul class="nav nav-tabs">
	<li class="active"><a href="#filtro" data-toggle="tab"><i class="icon-eye-open"></i> Filtros</a></li>
	<li><a href="#mapa" data-toggle="tab" id="tab-mapa"><i class="icon-map-marker"></i> Mapa</a></li>
	<li><a href="#hide" data-toggle="tab"><i class="icon-caret-up"></i> Esconder</a></li>
</ul>

<div class="tab-content">

<div class="tab-pane" id="hide">
</div>

<div class="tab-pane active" id="filtro">
<div class="row-fluid">
<form action="<?= View::makeUri('/admin/pedidos') ?>" method="get">
	<div class="span3">
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
		<?php foreach ( model_horario::getAll() as $horario ) : ?>
		<input type="checkbox" name="q[horario][]" value="<?= $horario->id ?>" <?= in_array($horario->id,$q['horario']) ? 'checked' : '' ?> />
		<span class="label"><i class="icon-time"></i> <?= $horario->descripcion ?></span><br />
		<?php endforeach ?>
	</div>
	<div class="span3">
		<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input class="input-large" type="text" name="q[cliente]" value="<?= View::e($q['cliente']) ?>" /></div><br />
		<small><i class="icon-info-sign"></i> Busca nombre, apellido o mail.</small>
	</div>
	<div class="span2">
		<input type="submit" value="Filtrar" class="btn submit pull-right" />
	</div>
</form>
</div>
</div>

<div class="tab-pane" id="mapa">
<div class="row-fluid">
	<div class="span12" style="height:480px" id="map_canvas">
	</div>
</div>
</div>

</div>

<br />

<!-- end tabs -->
<form action="<?= View::makeUri('/admin/actualizar') ?>" method="post" id="accion-form">
<div class="row-fluid">
	<div class="offset8 span3">
		<div class="input-prepend"><span class="add-on"><i class="icon-cog"></i></span>
		<select name="action" class="input-medium" id="accion-select">
			<option>-- acciones --</option>
			<option value="confirmar">Confirmar</option>
			<option value="enviar">Enviar</option>
			<option value="entregado">Entregado</option>
			<option value="cancelar">Cancelar</option>
		</select>
		</div>
	</div>
	<div class="span1">
	<input type="submit" value="Aplicar" id="boton-aplicar" class="btn submit btn-danger" />
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
			 <input class="pull-right pedido-checkbox" type="checkbox" name="pedido[]" id="pedido-<?= $p->id ?>-check" value="<?= $p->id ?>" />
		</td>
	</tr>
<?php endforeach ?>
</tbody>
</table>

</form>


<div id="modal-confirmar" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Confirma la acción</h3>
    </div>
    <div class="modal-body">
      <p>Seleccionaste la siguiente acción: <strong id="accion-seleccionada"></strong></p>
      <p>¿Queres seguir?</p>
    </div>
    <div class="modal-footer">
      <a href="#" id="accion-submit" class="btn btn-danger">Si</a>
      <a href="#" id="accion-cancel" class="btn">No</a>
    </div>
</div>

<script>//<!--
var markers = [
<?php foreach ( $pedidos as $p ) : ?>
<?php if ( $p->getUser()->lat && $p->getUser()->lng ) : ?>
<?= '{id:'.$p->id.', lat: '.$p->getUser()->lat.', lng: '.$p->getUser()->lng.'},' ?>
<?php endif ?>
<?php endforeach ?>
];
//-->
</script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="<?= View::makeUri('/assets/js/admin.js') ?>"></script>
