<h1>Actualiza tus datos personales</h1>

<form action="<?= View::e(View::makeUri('/user/update')) ?>" method="post">

<?php include('_user_form.php') ?>

<input class="btn submit" type="submit" value="Guardar" />
</form>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>//<!--
<?php
		$horarios = model_horario::getAllJson();
		$barrios = model_barrio::getAllJson();
		$recorridos = model_recorrido::getAllJson();
?>
var barrios = <?= $barrios ?>,
	horarios = <?= $horarios ?>,
	recorridos = <?= $recorridos ?>;
//--></script>
