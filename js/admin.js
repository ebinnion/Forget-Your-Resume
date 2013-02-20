$(document).ready(function() {
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontsizeselect,|,fullscreen",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Skin options
		skin : "o2k7",
		skin_variant : "silver",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "js/template_list.js",
		external_link_list_url : "js/link_list.js",
		external_image_list_url : "js/image_list.js",
		media_external_list_url : "js/media_list.js",
	});
	
	// Background Image Selection
	var bgpattern = $('#bgpattern');
	bgpattern.hide();

	var bgselector = $('#bgselector');

	$('[data-image]').each(function (){
		var img = $(this).data('image');
		bgselector.append('<img src="' + img + '">');
	});

	$('#bgselector img').live('click',function() {
		var img = $(this).attr('src');
		$('body').css('background',function() {
			var temp = 'url('+img+')';
			return temp;
		});

		$('#bgpattern option:selected').attr('selected',false);

		$('[data-image]').each(function() {
			if( $(this).data('image') == img ) {
				$(this).attr('selected' , true);
			}
		});
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