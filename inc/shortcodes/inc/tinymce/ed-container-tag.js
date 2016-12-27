/**
 * Container tag Short code button
 */

( function() {
     tinymce.create( 'tinymce.plugins.container_tag', {
        init : function( ed, url ) {
             ed.addButton( 'container_tag', {
                title : 'Container tag',
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
    tinymce.PluginManager.add( 'container_tag', tinymce.plugins.container_tag );
    jQuery( function() {
        var form = jQuery( '<div id="sc-container-form"><table id="sc-spacer-table" class="form-table">\
                            <tr>\
                            <th><label for="sc-conainer-size">Size</label></th>\
                            <td><select name="coltype" id="sc-col-coltype">\
                            <option value="full">Full</option>\
                            <option value="md">Medium</option>\
                            <option value="sm">Small</option>\
                            </select><br />\
                            <small>Select width of container.</small></td>\
                            </tr>\                            
                            </table>\
                            <p class="submit">\
                            <input type="button" id="sc-spacer-submit" class="button-primary" value="Insert Container" name="submit" />\
                            </p>\
                            </div>' );
        var table = form.find( 'table' );
        form.appendTo( 'body' ).hide();
        form.find( '#sc-container-submit' ).click( function() {
            var dummy = '<p>Insert your content here. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus leo ante, consectetur sit amet vulputate vel, dapibus sit amet lectus.</p>';
            var nl = '<br /><br />';
            var container_size = table.find( '#sc-conainer-size').val(),
            shortcode = '[container_tag class="' + container_size + '"]' + dummy + '[/container_tag]' + nl;

            tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
            tb_remove();
        } );
    } );
	
 } )();