function how_may_days(month, year) {
    return new Date(year, month, 0).getDate();
}

var per = function(value, max){
	var percentage = value * 100 / max;
	return percentage;
};

var single_bar = function(day_value){
	single='';
	return single;
};

var status_ok = function(day_id){
	oks = 0;
	for (var i = 0; i < day_id; i++) {
		if ( $('.year .day').eq(i).find('.face').hasClass('ok') ){
			oks++;
		}
	};
	return oks;
}

var status_ko = function(day_id){
	kos = 0;
	for (var i = 0; i < day_id; i++) {
		if ( $('.year .day').eq(i).find('.face').hasClass('ko') ){
			kos++;
		}
	};
	return kos;
}

var dow_stats = function (day_of_the_week){
	var wgd = 0;
	var wbd = 0;
	var wd = $('.year .active.' + day_of_the_week + ' .face').length;
	var stats = '';
	$('.year .active.' + day_of_the_week + ' .face').each(function() {
		if ($(this).hasClass('ok')){
			wgd++;
		} else {
			wbd++;
		}
	});

	if ( wgd >= wbd ){
		stats = day_of_the_week + '(' + wd + '): '  + wgd + ' días buenos / ' + wbd + ' días malos. // ' + (per(wgd,wd)).toFixed(1) + '% Buenos';
		stats = (per(wgd,wd)).toFixed(2);
	} else {
		stats = day_of_the_week + '(' + wd + '): '  + wgd + ' días buenos / ' + wbd + ' días malos. // ' + (per(wbd,wd)).toFixed(1) + '% Malos';
		stats = (per(wbd,wd)).toFixed(2) * -1;
	}
	return stats;
};

var consecutive_days = function(type){
	if ( (type != 'ok') || (type != 'ko') ){
		type = 'ok';
	}

	var cgd = 0;
	var countgd = 0;
	$('.year .active .face').each(function(index) {
		if ( $(this).hasClass(type) ) {
			countgd++;
		} else {
			if (countgd >= cgd) {
				cgd = countgd;
			}
			countgd = 0;

		}
	if (countgd >= cgd) {
		cgd = countgd;
		}
	});

	return cgd;
};


$(document).ready(function() {

	if (window.location.hash != ''){
		var idSel = window.location.hash.replace('#','');
		if ( (Number(idSel)) && (idSel > 0) && (idSel <= $('.year .day').length) ){
			$('.year').addClass('fullscreen');

			$('.year .day').eq(idSel-1).addClass('sel');
			var classSel ='';
			if ( $('.year .day.sel .face').parent('.day').hasClass('bday') ){
				classSel = 'bday';
			} else {
				classSel = $('.year .day.sel .face').attr('class');
				classSel = classSel.replace('face','').replace(' ','');
			}
			//$('body').addClass(classSel);

		} else {
			window.location.hash = '';
		}
	}

	// Toggles day/year view
	$('li .face').click(function() {
		$('.year').toggleClass('fullscreen');
		$(this).parent('li').toggleClass('sel');

		if ( $('.year').hasClass('fullscreen') ){

				if ( $('.year .day.sel .face').parent('.day').hasClass('bday') ){
					classSel = 'bday';
				} else {
					classSel = $('.year .day.sel .face').attr('class');
					classSel = classSel.replace('face','').replace(' ','');
				}
				//$('body').addClass(classSel);

			} else {
				//$('body').attr('class', $('body').data('default'));
			}

		if (window.location.hash == ''){
			window.location.hash = '';
			window.location.hash = $('.year .day.sel').data('day');
		} else {
			window.location.hash = '';
		}
	});

	// ministats
	if ($('.stats').length>0){

		var tdays = $('.stats .good.days').data('value') + $('.stats .bad.days').data('value');
		var gdays = $('.stats .good.days').data('value') * 100 / tdays;
		var bdays = 100 - gdays;
		$('.stats .good.days').append('<span class="value">' + $('.stats .good.days').data('value') + '</span>');
		$('.stats .bad.days').append('<span class="value">' + $('.stats .bad.days').data('value') + '</span>');

		$('.stats .good.days').animate({width: gdays + '%'}, 5000);
		$('.stats .bad.days').animate({width: bdays + '%'}, 5000);
	}

	//datepicker
	// if (!Modernizr.inputtypes.date){
	// 	$('#soldier_date').datepicker({
	// 		showButtonPanel: true
	// 	});
	// }

	var stat = 0;
	var data = new Array();
	var raw = new Array();
	$('.face').each(function(index) {
		if ( $(this).hasClass('ok') ){
			stat += 1;
			raw[index] = 1;
		} else if ( $(this).hasClass('ko') ){
			stat -= 1;
			raw[index] = -1;
		} else {
			stat += 0;
			raw[index] = 0;
		}
		data[index] = stat;
	});


	//vamos a calcular el último més - NO ME INTERESA PORQUE HAY MUY POCA VARIACIÓN
	/*
	bar = '<ul class="bars">';
	var month_days = how_may_days($('.bar_graph').data('month'), $('.bar_graph').data('year'));

	for (var i = 0; i < month_days; i++) {
		var bar_value = '';
		if ( $('.year .m' + $('.bar_graph').data('month')).eq(i) ){
			bar_value = $('.year .m' + $('.bar_graph').data('month')).eq(i).data('day');
		}

		var type_of_day = 'good';
		if (data[bar_value] < 0) {type_of_day = 'bad';}
		bar += '<li class="bar ' + type_of_day + '" style="width:' + per(1,month_days) +'%"><div class="progress" style="height:' + per( Math.abs(data[bar_value]),365 ) + '%"></div><div class="number">' + (i+1) + '</div></li>';
	};

	bar += '</ul>';
	*/

	// estadísticas semanales

	bar = '<ul class="week bars">';
	var week_days = 7;
	var week = new Array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');

	for (var i = 0; i < week_days; i++) {
		bar_value = dow_stats(week[i]);

		var type_of_day = 'good';
		if (bar_value < 0) {type_of_day = 'bad';}
		bar += '<li class="bar ' + type_of_day + '" style="width:' + per(1,week_days) +'%"><div class="progress" style="height:' + Math.abs(bar_value) + '%"></div><div class="number">' + week[i] + '</div></li>';
	};

	bar += '</ul>';


	// estadísticas 1 día concreto
/*
	bar = '<div>' + dow_stats('monday') + '</div>';
	bar += '<div>' + dow_stats('tuesday') + '</div>';
	bar += '<div>' + dow_stats('wednesday') + '</div>';
	bar += '<div>' + dow_stats('thursday') + '</div>';
	bar += '<div>' + dow_stats('friday') + '</div>';
	bar += '<div>' + dow_stats('saturday') + '</div>';
	bar += '<div>' + dow_stats('sunday') + '</div>';
*/

	// días buenos consecutivos
	//bar ='Días consecutivos buenos: ' + consecutive_days('ok');

	//$('.bar_graph.data').html(bar).slideDown();
});



