/**
 * Spacer tag Short code button
 */

( function() {
	tinymce.create( 'tinymce.plugins.spacer_horz', {
        init : function( ed, url ) {
             ed.addButton( 'spacer_horz', {
                title : 'Spacer',
                image : url + '/ed-icons/spacer.png',
                onclick : function() {
                	var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
					W = W - 80;
					H = H - 84;
					tb_show( 'Spacer Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-spacer-form' );
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'spacer_horz', tinymce.plugins.spacer_horz );
	jQuery( function() {
		var form = jQuery( '<div id="sc-spacer-form"><table id="sc-spacer-table" class="form-table">\
							<tr>\
							<th><label for="sc-spacer-padding-top">Padding top</label></th>\
							<td><input type="text" name="sc-spacer-padding-top" id="sc-spacer-padding-top" /><small>(Without px. Default value is 10)</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-spacer-padding-bottom">Padding bottom</label></th>\
							<td><input type="text" name="sc-spacer-padding-bottom" id="sc-spacer-padding-bottom" /><small>(Without px. Default value is 10)</small></td>\
							</tr>\
							</table>\
							<p class="submit">\
							<input type="button" id="sc-spacer-submit" class="button-primary" value="Insert Space" name="submit" />\
							</p>\
							</div>' );
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-spacer-submit' ).click( function() {
			var padding_top = table.find( '#sc-spacer-padding-top').val(),
			padding_bottom = table.find( '#sc-spacer-padding-bottom' ).val(),
			shortcode = '[spacer_horz';
			if(padding_top)
				shortcode += ' padding_top="' + padding_top + '"';
			if(padding_bottom)
				shortcode += ' padding_bottom="' + padding_bottom + '"';
			shortcode +=']';

			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
	
 } )();