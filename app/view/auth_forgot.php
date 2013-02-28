<div class="alert alert-info"><i class="icon-lightbulb icon-large"></i> ¿Olvidaste tu contraseña? Ingresa tu email y crea una nueva.</div>

<form action="<?= View::makeUri('auth/forgotpassword') ?>" method="post">

<div class="row-fluid">
<div class="input-prepend span4"><span class="add-on"><i class="icon-envelope"></i> Email </span> <input class="input-large" type="text" name="email"/></div>
</div>

<button class="btn">Enviar</button>
</form>

