$(document).ready(function(){

// Configura y carga el calendar
$("#filtro_fecha_entrega").datepicker( { 
	monthNames:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"], 
	dayNames: ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"], 
	dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
	dateFormat: "yy-mm-dd",
});

var mapCenter = new google.maps.LatLng(-34.5917346, -58.413742100000036);

var mapOptions = {
  center: mapCenter,
  zoom: 14,
  mapTypeId: google.maps.MapTypeId.ROADMAP,
  streetViewControl: false,
  mapTypeControl: false,
};

var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

var loadMarkers = function() {
	var bounds = map.getBounds();
	if ( typeof ( bounds ) != 'undefined' ) {

	var	nelat = bounds.getNorthEast().lat(),
		nelng = bounds.getNorthEast().lng(),
		swlat = bounds.getSouthWest().lat(),
		swlng = bounds.getSouthWest().lng();

	for ( var i=0; i < markers.length; i++ ) {
		if ( markers[i].lat < nelat && markers[i].lng < nelng &&
			markers[i].lat > swlat && markers[i].lng > swlng && !markers[i].shown ) {
			
			latlng = new google.maps.LatLng(markers[i].lat, markers[i].lng);
			markers[i].mk = new google.maps.Marker({ position: latlng, map: map });
			markers[i].shown = 1;
			markers[i].mk.id = markers[i].id;
			$('#pedido-'+markers[i].id+'-check').data('custom-i',i);
			google.maps.event.addListener(markers[i].mk, 'click', function() { 
				$('#pedido-'+this.id+'-check').prop('checked',true).trigger('change');
			});
		}
	}

	}
}


$('#tab-mapa').on('shown', function (e) {
	google.maps.event.trigger(map, 'resize');
	map.setCenter(mapCenter);
});

google.maps.event.addListener(map, 'idle', loadMarkers);


$('.pedido-checkbox').change(function(e){
	if ( $(this).is(':checked') ) {
		$(this).closest('tr').addClass('info');
		markers[$(this).data('custom-i')].mk.setVisible(false);
	} else {
		$(this).closest('tr').removeClass('info');
		markers[$(this).data('custom-i')].mk.setVisible(true);
	}
});


$('#modal-confirmar').on('show',function(){
	$('#accion-seleccionada').text( $('#accion-select option:selected').text() );
});

$('#boton-aplicar').click(function(e){
	e.preventDefault();
	$('#modal-confirmar').modal('show');
});

$('#accion-submit').click(function(e){
	$('#accion-form').submit();
});

$('#accion-cancel').click(function(e){
	$('#modal-confirmar').modal('hide');
});

});
