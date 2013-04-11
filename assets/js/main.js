$(document).ready(function(){

var d = new Date();

// CALENDARIO

//	traigo la fecha, la convierto a utc, la convierto a utc-3 le sumo 48horas
var mindate = new Date( d.getTime() + (d.getTimezoneOffset() * 60000) - (3600000 * 3) + (3600000 * 48) );

if ( $('.pedido').length > 0) {
	setInterval(function(){
	if ( $('.pedido').hasClass('blink') ) {
		$('.pedido').removeClass('blink');
	} else {
		$('.pedido').addClass('blink');
	}
	},1000);
}

// Si tenemos un campo direccion
if ( $('#direccion').length != 0 ) {

var semana = [0,0,0,0,0,0,0];
var nombreDias = ['domingo','lunes','martes','miercoles','jueves','viernes','sabado'];
var geocoder = new google.maps.Geocoder();
var barrioField = $('#barrio_id');
var horariosDisponiblesField = $('#horarios_disponibles');
var tipoPedidoSeleccionado = $('#tipo-pedido :selected').val(); 

// Devuelve true si hay que mostrar ese dia en el calendar
var mostrarDia = function ( date ) {
	if ( semana[date.getDay()] > 0 ) {
		return {0:true}; 
	} else {
		return {0:false};
	}
}


// Se ejecuta al seleccionar un dia en el calendar
var seleccionarDia = function(dateText) {
	$('#fecha_entrega').val(dateText);
	cargarHorarios( $('#calendar').datepicker('getDate') );
}


// Vuelve a cargar el calendar
var reloadCalendar = function () {
	if ( $('#calendar').length != 0 ) {
		$('#calendar').datepicker("refresh");
		seleccionarDia( $('#calendar').datepicker().val() );
	}
}

// Configura y carga el calendar
$("#calendar").datepicker( { 
	monthNames:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"], 
	dayNames: ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"], 
	dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
	dateFormat: "yy-mm-dd",
	beforeShowDay: mostrarDia,
	onSelect: seleccionarDia,
	minDate: mindate,
});


// HORARIOS

// Carga los horarios disponibles para el dia seleccionado
var cargarHorarios = function ( date ) {
	barrioId = barrioField.val();
	diaSeleccionado = nombreDias[date.getDay()];
	horariosDisponiblesField.html('');

	if ( tipoPedidoSeleccionado == 'retiro' ) {
		r = recorridos[0];
	} else {
		r = recorridos[0]; // <-
		//r = recorridos[barrioId];
	}

	// Para todos los recorridos
	for ( horario in r ) {
	if (r.hasOwnProperty(horario)) {
		if ( r[horario][diaSeleccionado] > 0 ) {
			// Si hay recorrido el dia seleccionado lo agrego
			horariosDisponiblesField.append( '<span class="span6"><input type="radio" name="horario_id" value="'+horario+'" /> <span class="label"><i class="icon-time"/> '+ horarios[horario] +'</span></span>' );
		}
	}
	}
}


// BARRIOS

var loadSemana = function() {
	semana = [0,0,0,0,0,0,0];
	barrioId = barrioField.val();
	r = recorridos[barrioId];
	// sumamos los dias de recorridos de todos los horarios del barrio
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
}
// Guarda el id del barrio en el campo
var setBarrioId = function ( id ) {
	if ( id ) {
		$('#barrio_id').val( id );
		hideBarrios();
	} else {
		$('#barrio_id').val(0);
//		showBarrios(); // <-
	}
}

// Nos devuelve el id interno del barrio devuelto por GMAPS
var getBarrioId = function ( barrio ) {
	for ( id in barrios ) {
		if ( barrios[id] == barrio ) {
			return id;
		}
	}
}

// Mostrar el select de barrios
var showBarrios = function () {
	$('#barrios_select').show();
}
var hideBarrios = function () {
	$('#barrios_select').hide();
}

// Trae el barrio segun la direccion
var cargarBarrio = function () {
	direccion = $('#direccion').val() + ', Ciudad Autónoma de Buenos Aires, Argentina';
	geocoder.geocode( { 'address': direccion }, function(results, status) {
		var barrio_id = 0;

		if (status == google.maps.GeocoderStatus.OK) {

			// Si es una dirección precisa guardo la lat y lng
			if ( results[0].geometry.location_type == google.maps.GeocoderLocationType.ROOFTOP || results[0].geometry.location_type == google.maps.GeocoderLocationType.RANGE_INTERPOLATED ) {
				$('#lat').val(results[0].geometry.location.lat());
				$('#lng').val(results[0].geometry.location.lng());
			} else {
				$('#lat').val(0);
				$('#lng').val(0);
			}

			var total = $(results[0].address_components).length;
			$(results[0].address_components).each(function(index,element){

				if ( element.types.indexOf('neighborhood') != -1 ) {
					barrio_id = getBarrioId(element.long_name);
				}

				// ultimo elemento
				if ( index === total - 1 ) {
					setBarrioId( barrio_id );
				}
			});
		}
	});
}

// Warning!! this function asumes earth is a sphere so adjust it if you are a plain earth weirdo
function getDistanceFromLatLng(lat1,lon1,lat2,lon2) {
  var R = 6378.1; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1); 
  var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2); 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c * 1000; // Distance in m
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}

var estaEnElRadioEntrega = function( lat, lng ) { 
	console.log(getDistanceFromLatLng(myLat,myLng,lat,lng));
	console.log(myLat,myLng,lat,lng);
	if ( getDistanceFromLatLng(myLat,myLng,lat,lng) < maxRadius * 100 ) {
		return true;
	} else {
		return false;
	}
}

var reloadAll = function () {

	if ( $('#direccion').val().length > 0 ) {
		cargarBarrio();
	}

	tipoPedidoSeleccionado = $('#tipo-pedido :selected').val();

	if ( tipoPedidoSeleccionado == 'retiro' ) {
		semana =[0,1,1,1,1,1,1];
		if ( estaEnElRadioEntrega( $('#lat').val(), $('#lng').val() ) ) {	// <-
			$('#fuera-del-radio').hide();
			$('#tipo-entrega').removeAttr('disabled');
			$('#tipo-pedido').val( $('#tipo-entrega').val() );
		}
		reloadCalendar();
	} else if ( $('#direccion').val().length > 0 ) {

	setTimeout(function() {

		// chequear que esta en el radio de entrega
		if ( estaEnElRadioEntrega( $('#lat').val(), $('#lng').val() ) ) {	// <-
			semana = [0,1,1,1,1,1,1]; 
			$('#fuera-del-radio').hide();
			$('#tipo-entrega').removeAttr('disabled');
			$('#tipo-pedido').val( $('#tipo-entrega').val() );
		} else {
			// pongo horarios de retiro
			semana =[0,1,1,1,1,1,1];
			$('#fuera-del-radio').show();
			$('#tipo-entrega').attr('disabled','disabled');
			$('#tipo-pedido').val( $('#tipo-retiro').val() );
		}
		
		/** comment out aplico radio de entrega // <- 
		loadSemana();
		*/

		reloadCalendar();
	},1500);

	}
}



$('#direccion').on('change',reloadAll);

$('#tipo-pedido').on('change',reloadAll);

var ac = new usig.AutoCompleter('direccion', {
	afterSelection: function(option) {
		if (option instanceof usig.Direccion || option instanceof usig.inventario.Objeto) {
			$('#calle').val(option.getCalle().nombre);
			$('#numero').val(option.getAltura());
		}
	}
}); // autocompleter

reloadAll();

} // if #direccion


}); // ready
