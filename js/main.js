$(document).ready(function() {
	// Toggles day/year view
	$('li .face').click(function() {
		$('.year').toggleClass('fullscreen');
		$(this).parent('li').toggleClass('sel');
	});

	//datepicker
	// if (!Modernizr.inputtypes.date){
	// 	$('#soldier_date').datepicker({
	// 		showButtonPanel: true
	// 	});
	// }

});



