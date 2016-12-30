/**
 * Box Color tag Short code button
 */

( function() {
	tinymce.create( 'tinymce.plugins.box_color', {
        init : function( ed, url ) {
             ed.addButton( 'box_color', {
                title : 'Box color',
                image : url + '/ed-icons/box-color.png',
                onclick : function() {
                	var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
					W = W - 80;
					H = H - 84;
					tb_show( 'Box Color Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-box-form' );
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'box_color', tinymce.plugins.box_color );
	jQuery( function() {
		var form = jQuery( '<div id="sc-box-form"><table id="sc-box-table" class="form-table">\
							<tr>\
							<th><label for="sc-box-bg-color">Background color</label></th>\
							<td><input type="text" name="sc-box-bg-color" id="sc-box-bg-color" /><small>(Default transparency)</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-box-font-color">Font color</label></th>\
							<td><input type="text" name="sc-box-font-color" id="sc-box-font-color" /><small>(Default none)</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-box-padding-top">Padding top</label></th>\
							<td><input type="text" name="sc-box-padding-top" id="sc-box-padding-top" /><small>(Without px. Default value is 10)</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-box-padding-right">Padding right</label></th>\
							<td><input type="text" name="sc-box-padding-right" id="sc-box-padding-right" /><small>(Without px. Default value is 10)</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-box-padding-bottom">Padding bottom</label></th>\
							<td><input type="text" name="sc-box-padding-bottom" id="sc-box-padding-bottom" /><small>(Without px. Default value is 10)</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-box-padding-left">Padding left</label></th>\
							<td><input type="text" name="sc-box-padding-left" id="sc-box-padding-left" /><small>(Without px. Default value is 10)</small></td>\
							</tr>\
							</table>\
							<p class="submit">\
							<input type="button" id="sc-box-submit" class="button-primary" value="Insert Box color" name="submit" />\
							</p>\
							</div>' );
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-box-submit' ).click( function() {
			var dummy = '<p>Insert your content here. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus leo ante, consectetur sit amet vulputate vel, dapibus sit amet lectus.</p>';
			var nl = '<br /><br />';
			var bg_color = table.find( '#sc-box-bg-color').val(),
			font_color = table.find( '#sc-box-font-color').val(),
			padding_top = table.find( '#sc-box-padding-top').val(),
			padding_right = table.find( '#sc-box-padding-right').val(),
			padding_bottom = table.find( '#sc-box-padding-bottom' ).val(),			
			padding_left = table.find( '#sc-box-padding-left' ).val(),
			shortcode = '[box_color';
			if(bg_color)
				shortcode += ' bg_color="' + bg_color + '"';
			if(font_color)
				shortcode += ' font_color="' + font_color + '"';
			if(padding_top)
				shortcode += ' padding_top="' + padding_top + '"';
			if(padding_right)
				shortcode += ' padding_right="' + padding_right + '"';
			if(padding_bottom)
				shortcode += ' padding_bottom="' + padding_bottom + '"';
			if(padding_left)
				shortcode += ' padding_left="' + padding_left + '"';
			shortcode +=']' + dummy + '[/box_color]' + nl;

			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
	
 } )();