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
                	var dummy = '<p>Insert your content here. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus leo ante, consectetur sit amet vulputate vel, dapibus sit amet lectus.</p>';
                    var nl = '<br /><br />';
                    var shortcode = '[container_tag]' + dummy + '[/container_tag]' + nl;
                    ed.execCommand('mceInsertContent', 0, shortcode);
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'container_tag', tinymce.plugins.container_tag );
	
 } )();