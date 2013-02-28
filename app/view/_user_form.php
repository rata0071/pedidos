
<span class="row-fluid">
	<span class="span4 control-group">
		<div class="input-prepend controls">
			<span class="add-on control-label"><i class="icon-user"></i> Nombre </span>
			<input type="text" name="nombre" required minlength="3" data-validation-minlength-message="El nombre es demasiado corto" data-validation-required-message="Por favor ingresa tu nombre."  value="<?= $datos ? View::e($datos['nombre']) : '' ?>" />
		</div>
		<p class="help-block"></p>
	</span>
	<span class="span4 control-group">
		<div class="input-prepend controls">
			<span class="add-on control-label"><i class="icon-user"></i> Apellido </span>
			<input type="text" name="apellido" required minlength="3" data-validation-minlength-message="El apellido es demasiado corto" ddata-validation-required-message="Por favor ingresa tu apellido." value="<?= $datos ? View::e($datos['apellido']) : '' ?>" />
		</div>
		<p class="help-block"></p>
	</span>
</span>

<span class="row-fluid">
	<span class="control-group span4">
		<div class="input-prepend controls">
			<span class="add-on control-label"><i class="icon-home"></i> Dirección </span> 
			<input type="text" name="direccion" id="direccion" required data-validation-required-message="Por favor ingresa la dirección de entrega." value="<?= $datos ? View::e($datos['direccion']) : '' ?>" />
		</div>
		<p class="help-block"></p>
	</span>
	<span class="control-group span2">
		<div class="input-prepend controls">
			<span class="add-on control-label"><i class="icon-home"></i> Piso </span>
			<input type="text" class="input-small" name="piso" value="<?= $datos ? View::e($datos['piso']) : '' ?>" />
		</div>
	</span>
	<span class="control-group span2">	
		<div class="input-prepend controls">
			<span class="add-on control-label"><i class="icon-home"></i> Depto</span> 
			<input type="text" class="input-small" name="depto" value="<?= $datos ? View::e($datos['depto']) : '' ?>" />
		</div>
	</span>

	<input type="hidden" name="calle" id="calle" value="<?= $datos ? View::e($datos['calle']) : '' ?>" />
	<input type="hidden" name="numero" id="numero" value="<?= $datos ? View::e($datos['numero']) : '' ?>" />
	<input type="hidden" name="barrio" id="barrio" value="<?= $datos ? View::e($datos['barrio']) : '' ?>" />
	<input type="hidden" name="barrio_id" id="barrio_id" value="<?= $datos ? View::e($datos['barrio_id']) : '0' ?>" />
	<input type="hidden" name="lat" id="lat" value="<?= $datos ? View::e($datos['lat']) : '0' ?>" />
	<input type="hidden" name="lng" id="lng" value="<?= $datos ? View::e($datos['lng']) : '0' ?>" />
	<?php if ( $update ) : ?>
		<input type="hidden" name="id" value="<?= $datos['id'] ?>" />
	<?php endif ?>
</span>

<span class="row-fluid">
	<span class="control-group span4">
		<div class="input-prepend controls">
			<span class="add-on control-label"><i class="icon-phone"></i> Telefono </span> 
			<input type="text" name="telefono" minlength="8" data-validation-minlength-message="Por favor ingresa un telefono válido" required data-validation-required-message="Por favor ingresa un telefono." value="<?= $datos ? View::e($datos['telefono']) : '' ?>" />
		</div>
		<p class="help-block"></p>
	</span>
	<span class="control-group span4">
		<div class="input-prepend controls">
			<span class="add-on control-label"><i class="icon-envelope"></i> Email </span> 
			<input type="email" <?= $update ? 'disabled' : '' ?> data-validation-email-message="Por favor ingresa un email válido." data-validation-required-message="Por favor ingresa un email." required name="email" value="<?= $datos ? View::e($datos['email']) : '' ?>" />
		</div>
		<p class="help-block"></p>
	</span>
</span>
