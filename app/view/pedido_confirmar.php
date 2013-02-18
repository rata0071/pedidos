
<div class="alert alert-success"><i class="icon-thumbs-up icon-large"></i> Tu pedido ha sido confirmado, ¡gracias!.</div>

<?php if ( $pedirpassword ) : ?>
<div class="alert alert-notice"><i class="icon-lightbulb icon-large"></i> Elije una contraseña. Te servira para revisar el estado de tus pedidos y hacer nuevos pedidos más facil.</div>
<form action="<?= View::makeUri('auth/newpassword') ?>" method="post">

<input type="password" name="password" />
<input type="password" name="repeat" />

<button class="btn">Guardar Contraseña</button>
</form>
<?php endif ?>
