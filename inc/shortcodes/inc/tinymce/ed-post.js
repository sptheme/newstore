/**
 * Post Short code button
 */

(function($) {
     tinymce.create( 'tinymce.plugins.post', {
        init : function( ed, url ) {
             ed.addButton( 'post', {
                title : 'Insert Posts',
                image : url + '/ed-icons/insert_posts.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Post options', 'admin-ajax.php?action=wpsp_post_shortcode_ajax&width=' + W + '&height=' + H );					                 }
             });
         },
         getInfo : function() {
				return {
						longname : 'SP Theme',
						author : 'Sopheak Peas',
						authorurl : 'http://www.linkedin.com/in/sopheakpeas',
						infourl : 'http://www.linkedin.com/in/sopheakpeas',
						version : '1.0.1'
				};
		}
     });
	tinymce.PluginManager.add( 'post', tinymce.plugins.post );

	// handles the click event of the submit button
	$('body').on('click', '#sc-post-form #option-submit', function() {
		form = $('#sc-post-form');
		// defines the options and their default values
		// again, this is not the most elegant way to do this
		// but well, this gets the job done nonetheless
		var options = { 
			'term_id' : null,
			'post_format' : null,
			'post_meta' : null,
			'post_excerpt' : null,
			'post_style' : null,
			'post_offset' : null,
			'post_count' : null,
			'cols' : null,
			};
		var shortcode = '[sc_post';
		
		for( var index in options) {
			var value = form.find('#'+index).val();
			
			// attaches the attribute to the shortcode only if it's different from the default value
			if ( value !== options[index] )
				shortcode += ' ' + index + '="' + value + '"';
		}
		
		shortcode += ']';
			
		// inserts the shortcode into the active editor
		tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
		// closes Thickbox
		tb_remove();
		
		
	});
	
})(jQuery);