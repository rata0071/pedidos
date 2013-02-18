$(document).ready(function(){

var d = new Date();

// Si estamos en la pagina de pedidos
if ( $('#calendar').length != 0 ) {

var barrioId = $('#barrio_id').val();
var semana = [0,0,0,0,0,0,0];
var nombreDias = ['domingo','lunes','martes','miercoles','jueves','viernes','sabado'];

var mostrarDia = function ( date ) {
	if ( barrioId == 0 ) {
		return {0:false};
	} else if ( semana[date.getDay()] > 0 ) {
		return {0:true}; 
	} else {
		return {0:false};
	}
}

var cargarHorarios = function ( date ) {
	$('#horarios_disponibles').html('');
	diaSeleccionado = date.getDay();
	barrioId = $('#barrio_id').val();

	r = recorridos[barrioId];
	for ( horario in r ) {
	if (r.hasOwnProperty(horario)) {
		if ( r[horario][nombreDias[diaSeleccionado]] > 0 ) {
			$('#horarios_disponibles').append(horarios[horario] + ' <input type="radio" name="horario_id" value="'+horario+'" />');
		}
	}
	}
}

var seleccionarDia = function(dateText, inst) {
	$('#fecha_entrega').val(dateText);
	cargarHorarios( $(this).datepicker('getDate') );
}

$("#calendar").datepicker( { 
	monthNames:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"], 
	dayNames: ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"], 
	dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
	dateFormat: "yy-mm-dd",
	beforeShowDay: mostrarDia,
	onSelect: seleccionarDia,
	minDate: "+1d",
});

var reloadCalendar = function () {
	barrioId = $('#barrio_id').val();
	semana = [0,0,0,0,0,0,0];
	// sumamos los dias de recorridos de todos los horarios
	r = recorridos[barrioId];
	for ( horario in r ) {
	if (r.hasOwnProperty(horario)) {
		semana[0] += r[horario]['domingo'];
		semana[1] += r[horario]['lunes'];
		semana[2] += r[horario]['martes'];
		semana[3] += r[horario]['miercoles'];
		semana[4] += r[horario]['jueves'];
		semana[5] += r[horario]['viernes'];
		semana[6] += r[horario]['sabado'];
	}
	}
	$('#calendar').datepicker("refresh");
	cargarHorarios( $('#calendar').datepicker('getDate') );
}

var geocoder = new google.maps.Geocoder();

var getBarrioId = function ( barrio ) {
	for ( id in barrios ) {
		if ( barrios[id] == barrio ) {
			return id;
		}
	}
}

var cargarBarrio = function () {
	direccion = $('#direccion').val() + ', Ciudad Autónoma de Buenos Aires, Argentina';
	geocoder.geocode( { 'address': direccion }, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {

			if ( results[0].geometry.location_type == google.maps.GeocoderLocationType.ROOFTOP || results[0].geometry.location_type == google.maps.GeocoderLocationType.RANGE_INTERPOLATED ) {
				$('#lat').val(results[0].geometry.location.lat());
				$('#lng').val(results[0].geometry.location.lng());
			}

			$(results[0].address_components).each(function(index,element){
				if ( element.types.indexOf('neighborhood') != -1 ) {
					barrio_id = getBarrioId(element.long_name);
			
					if ( barrio_id ) {
						$('#barrio').val(element.long_name);
						$('#barrio_id').val(barrio_id);
						reloadCalendar();
						return;
					} else {
						// El barrio no esta en la aplicacion
					}
				}
			});
		} else {
		// La direccion es incorrecta o no la reconoce GMAPS
		// No sabemos el barrio
		}
	});

}

// Revisamos los datos del pedido cuando carga la pagina
if ( typeof($('#direccion').val()) != 'undefined' ) {
	barrio_id = $('#barrio_id').val();
	if ( barrio_id != 0 ) {
		reloadCalendar();
	} else {
		cargarBarrio();
	}
}

$('#direccion').on('change',cargarBarrio);

var ac = new usig.AutoCompleter('direccion', {
        afterSelection: function(option) {
        if (option instanceof usig.Direccion || option instanceof usig.inventario.Objeto) {
        	$('#calle').val(option.getCalle().nombre);
        	$('#numero').val(option.getAltura());
		cargarBarrio();
        } else {
	// La direccion es incorrecta o no la reconoce el USIG
	// No sabemos la calle y numero!!
	// Cargamos el barrio igual!!
		cargarBarrio();
	}
        }
}); // autocompleter


} // if en pagina de pedido


}); // ready
