/**
 * Container tag Short code button
 */

( function() {
	tinymce.create( 'tinymce.plugins.container_box', {
        init : function( ed, url ) {
             ed.addButton( 'container_box', {
                title : 'Container',
                image : url + '/ed-icons/container.png',
                onclick : function() {
                	var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
					W = W - 80;
					H = H - 84;
					tb_show( 'Container Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-container-form' );
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'container_box', tinymce.plugins.container_box );
	jQuery( function() {
		var form = jQuery( '<div id="sc-container-form"><table id="sc-container-table" class="form-table">\
							<tr>\
                            <th><label for="sc-conainer-size">Size</label></th>\
                            <td><select name="coltype" id="sc-conainer-size">\
                            <option value="full">Full</option>\
                            <option value="md">Medium</option>\
                            <option value="sm">Small</option>\
                            </select><br />\
                            <small>Select width of container.</small></td>\
                            </tr>\
							</table>\
							<p class="submit">\
							<input type="button" id="sc-container-submit" class="button-primary" value="Insert Box color" name="submit" />\
							</p>\
							</div>' );
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-container-submit' ).click( function() {
			var dummy = '<p>Insert your content here. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus leo ante, consectetur sit amet vulputate vel, dapibus sit amet lectus.</p>';
            var nl = '<br /><br />';
            var container_size = table.find( '#sc-conainer-size').val(),
            shortcode = '[container_box class="' + container_size + '"]' + dummy + '[/container_box]' + nl;

			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
	
 } )();