<div class="alert alert-info"><i class="icon-lightbulb icon-large"></i> Elije una contraseña. Te servira para revisar el estado de tus pedidos y hacer nuevos pedidos más facilmente.</div>

<form action="<?= View::makeUri('auth/newpassword') ?>" method="post">

<div class="row-fluid">
<div class="input-prepend span4"><span class="add-on"><i class="icon-lock"></i> Contraseña </span> <input type="password" name="password" id="password" /></div>
</div>

<div class="row-fluid">
<div class="input-prepend span4"><span class="add-on"><i class="icon-lock"></i> Repetir </span> <input type="password" name="repeat" id="repeat" /></div>
</div>

<input type="hidden" name="csrftoken" value="<?= $auth->getCSRFToken() ?>" />

<button class="btn">Guardar Contraseña</button>
</form>

