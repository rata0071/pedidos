<div class="row-fluid">

<div class="span8">

<form action="<?= View::makeUri('/contacto') ?>" method="post" />

<div class="input-prepend controls">
	<span class="add-on control-label"><i class="icon-user"></i> Nombre</span>
	<input type="text" value="" data-validation-required-message="Por favor ingresa tu nombre." data-validation-minlength-message="El nombre es demasiado corto" minlength="3" required="" name="nombre" aria-invalid="false">
</div>
<p class="help-block"></p>

<div class="input-prepend controls">
	<span class="add-on control-label"><i class="icon-envelope"></i> Email</span>
	<input type="email" value="" name="email" required="" data-validation-required-message="Por favor ingresa un email." data-validation-email-message="Por favor ingresa un email válido." aria-invalid="false">
</div>
<p class="help-block"></p>

<textarea name="mensaje" style="height:150px; width:90%">
</textarea>

<br />
<button class="btn btn-primary">Enviar</button>

</form>

</div>
<div class="span4">
	<span style="font-size:22px">
		<p>Teléfono (011) 4822-6806</p>
		<p>Mansilla 3500, Palermo <br /><small style="font-size:12px">Lunes a Viernes de 9 a 21. Sábados de 10 a 15.</small></p>
		<p><img src="http://maps.googleapis.com/maps/api/staticmap?center=Mansilla+3500,+Palermo,+Ciudad+Autónoma+de+Buenos+Aires,+Argentina&zoom=13&size=280x260&maptype=roadmap&markers=color:green%7Clabel:V%7C-34.591822,-58.41374&sensor=false" alt="ViveVerde Mansilla 3500, Palermo" ></p>
	</span>

	<div class="fb-like-box" data-href="https://www.facebook.com/pages/Viveverde/149137775245548" data-width="284" data-height="220" data-show-faces="true" data-stream="false" data-border-color="#BACB45" data-header="false"></div>
</div>
</div>
