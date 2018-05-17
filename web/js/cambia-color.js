$(document).ready(function() {
    $('#colorselector').colorselector({
    	callback: function (value, color, title) {
    		$.cookie('color', color);
    		$.cookie('valueColor', value);
    		$('.panel-heading').first().attr('style', 'background-color: ' +color+ ' !important');
      	}
    });
    var color = '#2E9AFE';
    var valueColor = '15';
    if ($.cookie('color') != null && $.cookie('valueColor') != null) {
    	color = $.cookie('color');
    	valueColor = $.cookie('valueColor');
    }
    $('.btn-colorselector').attr('style', 'background-color: '+color+' !important');
    $('a').removeClass('selected');
    $('a[data-value='+valueColor+']').addClass('selected');
});
