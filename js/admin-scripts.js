/**
 * Show/Hide metabox base on post format
 */

jQuery(document).ready(function($) {

	// Hide Metaboxes
	var pageTitleBgSettings = $('.post_title_background_img, .post_title_height, .post_title_background_overlay, .post_title_background_overlay_opacity'),
	 solidColorElements = $('.post_title_background_color'),
	 pageTitleStyle = $('#wpsp_post_title_style');

	if ( $('#page-options').length ) {

		pageTitleBgSettings.hide();			
		solidColorElements.hide();

		if ( pageTitleStyle.val() === 'background-image' ) {
			pageTitleBgSettings.show();
		} else if ( pageTitleStyle.val() === 'solid-color' ) {
			solidColorElements.show();
		} 
		
		pageTitleStyle.change( function() {
			pageTitleBgSettings.hide();			
			if ( $(this).val() === 'background-image' ) {
				pageTitleBgSettings.show();
				solidColorElements.show();
			} else if ( $(this).val() === 'solid-color' ) {
				solidColorElements.show();
				pageTitleBgSettings.hide();
			}
		});
	}

	// Hide post format sections
	function hide_statuses() {
		$('#format-audio,#format-aside,#format-chat,#format-gallery,#format-image,#format-link,#format-quote,#format-status,#format-video').hide();
	}

	// Post Formats
	if($("#post-formats-select").length) {
		// Hide post format sections
		hide_statuses();

		// Supported post formats
		var post_formats = ['audio','aside','chat','gallery','image','link','quote','status','video'];

		// Get selected post format
		var selected_post_format = $("input[name='post_format']:checked").val();

		// Show post format meta box
		if(jQuery.inArray(selected_post_format,post_formats) != '-1') {
			$('#format-'+selected_post_format).show();
		}

		// Hide/show post format meta box when option changed
		$("input[name='post_format']:radio").change(function() {
			// Hide post format sections
			hide_statuses();
			// Shoe selected section
			if(jQuery.inArray($(this).val(),post_formats) != '-1') {
				$('#format-'+$(this).val()).show();
			}
		});
	}

	//Switch Metabox with template was loaded or selected
	var $homepage = $('#homepage-options'),
	$contact = $('#contact-options');
	
	function hide_meta_template() {
		$homepage.hide();
        $contact.hide();
	}

	if ( $('#page_template').length ) {
		hide_meta_template();
		
		var page_tempaltes = ['homepage', 'contact'];
		var selected_page_template = $('#page_template').val().replace('templates/', '').replace('.php', '');
		//console.log( selected_page_template );
		if(jQuery.inArray(selected_page_template,page_tempaltes) != '-1') {			
			$('#'+selected_page_template+'-options').show();
		}

		$('#page_template').live('change', function(){
			hide_meta_template();
			selected_page_template = $(this).val().replace('templates/', '').replace('.php', '');
			//console.log( selected_page_template );
			if(jQuery.inArray(selected_page_template,page_tempaltes) != '-1') {			
				$('#'+selected_page_template+'-options').show();
			}
		});
	} 

});