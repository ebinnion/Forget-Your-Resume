$(document).ready(function() {
	$('.texteditor').htmlarea({
		toolbar: ['bold','italic','underline','|','h3','h4','h5','h6','|','unorderedlist', 'orderedlist', '|', 'outdent','indent', '|', 'link','unlink']
	});

	$('#bgpattern').shImageSelect({
		type:'radio',
		maxSelected: '1',
		showText: false,
		imageLimit: {
        	x:8,
        	y:4
    	}
	});

	$('.sh-img-select-image-wrapper img').live('click',function() {
		var img = $(this).attr('src');
		$('body').css('background',function() {
			var temp = 'url('+img+')';
			return temp;
		});
	});

	$('.toggle-arrow').live('click', function() {
		$(this).toggleClass('toggled');
		$('.controls').slideToggle();
	});

	$('select#headfont').fontSelector({
		fontChange: function(e, ui) {
		// Update page title according to the font that's set in the widget options:
		$('h1').css({
		fontFamily: ui.font,
		});
		},
		styleChange: function(e, ui) {
			
		}
	});	
});