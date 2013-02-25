$(document).ready(function() {

	var bgpattern = $('#bgpattern');
	var bgselector = $('#bgselector');
	var h1 = $('hgroup h1 a');
	var tagline = $('hgroup h2');
	var contentbgvis = $('input[name=contentbgvis]');
	var linkcolor = $('input [name=linkcolor]');
	var linkhovercolor = $('input [name=linkhovercolor]');

	// Hide the backgroung image select to create a visual one
	bgpattern.hide();

	// Let's initialize the tiny MCE text editor with a ton of options...
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
	
	/*****************************************************
			Beginning of background image selection
	*****************************************************/
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

	/*****************************************************
			Ending of background image selection
	*****************************************************/

	/*****************************************************
			Begin color selection code
	*****************************************************/

	$('input.minicolors').minicolors({
		change: function(hex, opacity) {
	        var selector = $(this).data('selector');
	        var type = $(this).data('selecttype');

	        if (selector == '.content'){
	        	contentbgvis.attr('checked', false);
	        }
	        $(selector).css(type, hex);
	    }
		
	});
	
	contentbgvis.live('click', function() {
		if( $(this).attr('checked', true) ){
			$('.content').css('background', 'none');
		}
	});

	/*****************************************************
			End color selection code
	*****************************************************/

	// Selection of Google web fonts.
	// Updates the font-family of h1 element on change
	$('select#headfont').fontSelector({
		fontChange: function(e, ui) {
			// Update page title according to the font that's set in the widget options:
			$('h1').css({
				fontFamily: ui.font,
			});
		}
	});

	// Dynamically update the name (h1 element) in dom as user types
	$('input[name=name]').keyup(function() {
		var value = $(this).val();
		h1.text(value);
	});

	// Dynamically update tagline (h2 element) in dom as user types
	$('input[name=tagline]').keyup(function() {
		var value = $(this).val();
		tagline.text(value);
	});

	if( $.cookie('first') == null ) { 
          $('.optin').removeClass('hide');
     }
     $('#hideOpt').click(function(){
          $.cookie( 'first', '1',  { expires: 7, path: '/' } );
          $('.optin').addClass('hide');
     });
});