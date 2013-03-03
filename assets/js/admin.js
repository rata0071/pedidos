$(document).ready(function(){

// Configura y carga el calendar
$("#filtro_fecha_entrega").datepicker( { 
	monthNames:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"], 
	dayNames: ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"], 
	dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
	dateFormat: "yy-mm-dd",
});

var mapOptions = {
  center: new google.maps.LatLng(-34.5917346, -58.413742100000036),
  zoom: 14,
  mapTypeId: google.maps.MapTypeId.ROADMAP,
  streetViewControl: false,
  mapTypeControl: false,
};

var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

$('#tab-mapa').on('shown', function (e) {
	google.maps.event.trigger(map, 'resize');
})
});
