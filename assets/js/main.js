$(document).ready(function(){

var d = new Date();



if ( $('#calendar').length != 0 ) {

var mostrarDia = function ( date ) {
	if ( date.getDate() > 20 ) {
		return {0:false};
	} else { return {0:true}; }
}

$("#calendar").datepicker( { 
	monthNames:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"], 
	dayNames: ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"], 
	dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
	beforeShowDay: mostrarDia,
	minDate: "+1d",
});

var geocoder = new google.maps.Geocoder();

var ac = new usig.AutoCompleter('direccion', {
        afterSelection: function(option) {
        if (option instanceof usig.Direccion || option instanceof usig.inventario.Objeto) {
        	$('#calle').val(option.getCalle().nombre);
        	$('#numero').val(option.getAltura());
		direccion = $('#direccion').val() + ', Ciudad Autónoma de Buenos Aires, Argentina';
		geocoder.geocode( { 'address': direccion }, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				$(results[0].address_components).each(function(index,element){
					if ( element.types.indexOf('neighborhood') != -1 ) {
						$('#barrio').val(element.long_name);
					}
				});
			} else {
			// La direccion es incorrecta o no la reconoce GEOCODE
			// No sabemos el barrio
			}
        	});
        } else {
	// La direccion es incorrecta o no la reconoce el USIG
	// No sabemos la calle y numero!!
	}
        }
}); // autocompleter

} // if

}); // ready
