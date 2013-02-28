<form action="<?= View::makeUri('/auth/password') ?>" method="post">
	<div class="input-prepend"><span class="add-on"><i class="icon-lock"></i> Contraseña actual </span><input type="password" name="password" placeholder="********" /></div>
	<br />
	<div class="input-prepend"><span class="add-on"><i class="icon-lock"></i> Nueva contraseña </span><input type="password" name="newpassword" placeholder="********" /></div>
	<div class="input-prepend"><span class="add-on"><i class="icon-lock"></i> Repetir </span><input type="password" name="repeatpassword" placeholder="********" /></div>
	<button type="submit" class="btn">Cambiar contraseña</button>
</form>
