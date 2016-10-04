<?php
/**
 * Core theme functions
 *
 * These functions are used throughout the theme and must be loaded
 * early on.
 *
 * @package WPSP_Blog
 */

/*-------------------------------------------------------------------------------*/
/* General
/*-------------------------------------------------------------------------------*/

/**
 * Get Theme Branding
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_get_theme_branding' ) ) :
function wpsp_get_theme_branding( $branding = true ) {
	$fullname = THEME_BRANDING;		
	$prefix = THEME_BRANDING_PREFIX;
	if ( $branding ) {
		return $fullname;
	} else {
		return $prefix;
	}
}
endif;

/**
 * Returns theme options value from redux framework
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_get_redux') ) :
function wpsp_get_redux( $id, $default = '' ) {

	// Get global object
	global $redux_wpsp;

	// Return data from global object
	if ( ! empty( $redux_wpsp ) ) {

		// Return value
		if ( isset( $redux_wpsp[$id] ) ) {
			return $redux_wpsp[$id];
		}

		// Return default
		else {
			return $default;
		}

	}

	else {
		return $default;
	}

}
endif;

/**
 * Store current post ID
 *
 * @since 1.0.0
 */
function post_id() {

	// If singular get_the_ID
	if ( is_singular() || is_home() ) {
		return get_the_ID();
	}

	// Get ID of WooCommerce product archive
	elseif ( class_exists('woocommerce') && is_shop() ) {
		$shop_id = wc_get_page_id( 'shop' );
		if ( isset( $shop_id ) ) {
			return $shop_id;
		}
	}

	// Tribe events
	/*elseif( function_exists( 'tribe_is_month' )
		&& tribe_is_month()
		&& $page_id = wpex_get_tribe_events_main_page_id()
	) {
		return $page_id;
	}*/

	// Posts page
	elseif ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
		return $page_for_posts;
	}

	// Return nothing
	else {
		return NULL;
	}

}


/**
 * Echo the post URL
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_permalink') ) :
function wpsp_permalink( $post_id = '' ) {
	echo wpsp_get_permalink( $post_id );
}
endif;

/**
 * Return the post URL
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_get_permalink') ) :
function wpsp_get_permalink( $post_id = '' ) {

	// If post ID isn't defined lets get it
	$post_id = $post_id ? $post_id : get_the_ID();

	// Check wpsp_post_link custom field for custom link
	$meta = get_post_meta( $post_id, 'wpsp_post_link', true );

	// If wpsp_post_link custom field is defined return that otherwise return the permalink
	$permalink  = $meta ? $meta : get_permalink( $post_id );

	// Apply filters
	$permalink = apply_filters( 'wpsp_permalink', $permalink );

	// Sanitize & return
	return esc_url( $permalink );

}
endif;

/**
 * Echo escaped post title
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_esc_title') ) :
function wpsp_esc_title() {
	echo wpsp_get_esc_title();
}
endif;

/**
 * Return escaped post title
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_get_esc_title') ) :
function wpsp_get_esc_title() {
	return esc_attr( the_title_attribute( 'echo=0' ) );
}
endif;

/**
 * Escape attribute with fallback
 *
 * @since 1.0.0
 */
function wpsp_esc_attr( $val = null, $fallback = null ) {
	if ( $val = esc_attr( $val ) ) {
		return $val;
	} else {
		return $fallback;
	}
}

/**
 * Escape html with fallback
 *
 * @since 1.0.0
 */
function wpsp_esc_html( $val = null, $fallback = null ) {
	if ( $val = esc_html( $val ) ) {
		return $val;
	} else {
		return $fallback;
	}
}

/**
 * Sanitize numbers with fallback
 *
 * @since 1.0.0
 */
function wpsp_intval( $val = null, $fallback = null ) {
	if ( $val = intval( $val ) ) {
		return $val;
	} else {
		return $fallback;
	}
}

/**
 * Get or generate excerpts
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_excerpt') ) :
function wpsp_excerpt( $args ) {
	echo wpsp_get_excerpt( $args );
}
endif;

/**
 * Get or generate excerpts
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_get_excerpt') ) :
function wpsp_get_excerpt( $args = array() ) {

	// Fallback for old method
	if ( ! is_array( $args ) ) {
		$args = array(
			'length' => $args,
		);
	}

	// Setup default arguments
	$defaults = array(
		'output'        => '',
		'length'        => '30',
		'readmore'      => false,
		'readmore_link' => '',
		'more'          => '&hellip;',
	);

	// Parse arguments
	$args = wp_parse_args( $args, $defaults );

	// Filter args
	$args = apply_filters( 'wpsp_excerpt_args', $args );

	// Extract args
	extract( $args );

	// Sanitize data
	$excerpt = intval( $length );

	// If length is empty or zero return
	if ( empty( $length ) || '0' == $length || false == $length ) {
		return;
	}

	// Get global post
	$post = get_post();

	// Display password protected notice
	if ( $post->post_password ) :

		$output = esc_html__( 'This is a password protected post.', 'newstore' );
		$output = apply_filters( 'wpsp_password_protected_excerpt', $output );
		$output = '<p>'. $output .'</p>';
		return $output;

	endif;

	// Get post data
	$post_id      = $post->ID;
	$post_content = $post->post_content;
	$post_excerpt = $post->post_excerpt;

	// Get post excerpt
	if ( $post_excerpt ) {
		$post_excerpt = apply_filters( 'the_content', $post_excerpt );
	}

	// If has custom excerpt
	if ( $post_excerpt ) :

		// Display custom excerpt
		$output = $post_excerpt;

	// Create Excerpt
	else :

		// Return the content including more tag
		if ( '9999' == $length ) {
			return apply_filters( 'the_content', get_the_content( '', '&hellip;' ) );
		}

		// Return the content excluding more tag
		if ( '-1' == $length ) {
			return apply_filters( 'the_content', $post_content );
		}

		// Check for text shortcode in post
		if ( strpos( $post_content, '[vc_column_text]' ) ) {
			$pattern = '{\[vc_column_text.*?\](.*?)\[/vc_column_text\]}is';
			preg_match( $pattern, $post_content, $match );
			if ( isset( $match[1] ) ) {
				$excerpt = strip_shortcodes( $match[1] );
				$excerpt = wp_trim_words( $excerpt, $length, $more );
			} else {
				$content = strip_shortcodes( $post_content );
				$excerpt = wp_trim_words( $content, $length, $more );
			}
		}

		// No text shortcode so lets strip out shortcodes and return the content
		else {
			$content = strip_shortcodes( $post_content );
			$excerpt = wp_trim_words( $content, $length, $more );
		}

		// Add excerpt to output
		if ( $excerpt ) {
			$output .= '<p>'. $excerpt .'</p>';
		}

	endif;

	// Add readmore link to output if enabled
	if ( $readmore ) :

		$read_more_text = isset( $args['read_more_text'] ) ? $args['read_more_text'] : esc_html__( 'Read more', 'newstore' );
		$output .= '<a href="'. get_permalink( $post_id ) .'" title="'.$read_more_text .'" rel="bookmark" class="btn btn-secondary newstore-read-more-link">'. $read_more_text .' <span class="wpsp-readmore-rarr">&rarr;</span></a>';

	endif;

	// Apply filters for easier customization
	$output = apply_filters( 'wpsp_excerpt_output', $output );
	
	// Echo output
	return $output;

}
endif;

/**
 * Custom excerpt length for posts
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_excerpt_length') ) :
function wpsp_excerpt_length() {

	// Theme panel length setting
	$length = wpsp_get_redux( 'blog-excerpt-length', '40' );

	// Taxonomy setting
	if ( is_category() ) {
		
		// Get taxonomy meta
		$term       = get_query_var( 'cat' );
		$term_data  = get_option( "category_$term" );
		if ( ! empty( $term_data['wpsp_term_excerpt_length'] ) ) {
			$length = $term_data['wpsp_term_excerpt_length'];
		}
	}

	// Return length and add filter for quicker child theme editign
	return apply_filters( 'wpsp_excerpt_length', $length );

}
endif;

/**
 * Change default read more style
 *
 * @since 1.0.0
 */
function wpsp_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'wpsp_excerpt_more', 10 );

/**
 * Change default excerpt length
 *
 * @since 1.0.0
 */
function wpsp_custom_excerpt_length( $length ) {
	return '40';
}
add_filter( 'excerpt_length', 'wpsp_custom_excerpt_length', 999 );

/**
 * Outputs a theme heading
 * 
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_heading') ) :
function wpsp_heading( $args = array() ) {

	// Defaults
	$defaults = array(
		'apply_filters' => '',
		'content'       => '',
		'tag'           => 'h2',
		'classes'       => array(),
	);

	// Add filters if defined
	if ( ! empty( $args['apply_filters'] ) ) {
		$args = apply_filters( 'wpsp_heading_'. $args['apply_filters'], $args );
	}

	// Parse args
	wp_parse_args( $args, $defaults );

	// Extract args
	extract( $args );

	// Return if text is empty
	if ( ! $content ) {
		return;
	}

	// Get classes
	$add_classes = $classes;
	$classes     = array( 'theme-heading' );
	if ( $add_classes && is_array( $add_classes ) ) {
		$classes = array_merge( $classes, $add_classes );
	}

	// Turn classes into space seperated string
	$classes = implode( ' ', $classes ); ?>

	<<?php echo esc_attr( $tag ); ?> class="<?php echo esc_attr( $classes ); ?>">
		<span class="text"><?php echo $content; ?></span>
	</<?php echo esc_attr( $tag ); ?>>

<?php
}
endif;

/**
 * Prevent Page Scroll When Clicking the More Link
 * http://codex.wordpress.org/Customizing_the_Read_More
 *
 * @since 1.0.0
 */
function wpsp_remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'wpsp_remove_more_link_scroll' );

/**
 * Displays dashboard thumbnails if enabled
 *
 * @since 1.0.0
 */
if ( is_admin() && apply_filters( 'wpsp_dashboard_thumbnails', true ) ) :

	add_filter( 'manage_post_posts_columns', 'wpsp_posts_columns' );
	add_filter( 'manage_portfolio_posts_columns', 'wpsp_posts_columns' );
	add_action( 'manage_posts_custom_column', 'wpsp_posts_custom_columns', 10, 2 );
	add_filter( 'manage_page_posts_columns', 'wpsp_posts_columns' );
	add_action( 'manage_pages_custom_column', 'wpsp_posts_custom_columns', 10, 2 );

	if ( ! function_exists( 'wpsp_posts_columns' ) ) {
		function wpsp_posts_columns( $defaults ){
			$defaults['wpsp_post_thumbs'] = esc_html__( 'Featured Image', 'newstore' );
			return $defaults;
		}
	}

	if ( ! function_exists( 'wpsp_posts_custom_columns' ) ) {
		function wpsp_posts_custom_columns( $column_name, $id ){
			if ( $column_name != 'wpsp_post_thumbs' ) {
				return;
			}
			if ( has_post_thumbnail( $id ) ) {
				$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'thumbnail', false );
				if ( ! empty( $img_src[0] ) ) { ?>
						<img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_html( get_the_title() ); ?>" style="max-width:100%;max-height:90px;" />
					<?php
				}
			} else {
				echo '&mdash;';
			}
		}
	}
endif;

/**
 * Returns the correct classname for any specific column grid work with bootstrap
 *
 * @since 1.0.0
 */
if ( ! function_exists('bootstrap_grid_class') ) :
function bootstrap_grid_class( $col = '4' ) {
	$bootstrap_grid = 12;
	return esc_attr( apply_filters( 'bootstrap_grid_class', 'col-md-'. ($bootstrap_grid/$col) ) );
}
endif;


/*-------------------------------------------------------------------------------*/
/* [ Image ]
/*-------------------------------------------------------------------------------*/

/**
 * Echo animation classes for entries
 *
 * @since 1.0.0
 */
function wpsp_entry_image_animation_classes() {
	echo wpsp_get_entry_image_animation_classes();
}

/**
 * Returns animation classes for entries
 *
 * @since 1.0.0
 */
function wpsp_get_entry_image_animation_classes() {

	// Empty by default
	$classes = '';

	// Only used for standard posts now
	if ( 'post' != get_post_type( get_the_ID() ) ) {
		return;
	}

	// Get blog classes
	if ( wpsp_get_redux( 'blog-entry-image-hover-animation' ) ) {
		$classes = ' wpsp-image-hover '. wpsp_get_redux( 'blog-entry-image-hover-animation' );
	}

	// Apply filters
	return apply_filters( 'wpsp_entry_image_animation_classes', $classes );

}

/**
 * Returns attachment data
 *
 * @since 1.0.0
 */
function wpsp_get_attachment_data( $attachment = '', $return = '' ) {

	// Return if no attachment
	if ( ! $attachment ) {
		return;
	}

	// Return if return equals none
	if ( 'none' == $return ) {
		return;
	}

	// Create array of attachment data
	$array = array(
		'url'         => get_post_meta( $attachment, '_wp_attachment_url', true ),
		'src'         => wp_get_attachment_url( $attachment ),
		'alt'         => get_post_meta( $attachment, '_wp_attachment_image_alt', true ),
		'title'       => get_the_title( $attachment),
		'caption'     => get_post_field( 'post_excerpt', $attachment ),
		'description' => get_post_field( 'post_content', $attachment ),
		'video'       => esc_url( get_post_meta( $attachment, '_video_url', true ) ),
	);

	// Set alt to title if alt not defined
	$array['alt'] = $array['alt'] ? $array['alt'] : $array['title'];

	// Return data
	if ( $return ) {
		return $array[$return];
	} else {
		return $array;
	}

}

/**
 * Checks if a featured image has a caption
 *
 * @since 1.0.0
 */
function wpsp_featured_image_caption( $post_id = '' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	return get_post_field( 'post_excerpt', get_post_thumbnail_id( $post_id ) );
}

/**
 * Echo post thumbnail url
 *
 * @since 1.0.0
 */
function wpsp_post_thumbnail_url( $args = array() ) {
	echo wpsp_get_post_thumbnail_url( $args );
}

/**
 * Return post thumbnail url
 *
 * @since 1.0.0
 */
function wpsp_get_post_thumbnail_url( $args = array() ) {
	$args['return'] = 'url';
	return wpsp_get_post_thumbnail( $args );
}

/**
 * Outputs the img HTMl thubmails used in the Total VC modules
 *
 * @since 1.0.0
 */
function wpsp_post_thumbnail( $args = array() ) {
	echo wpsp_get_post_thumbnail( $args );
}

/**
 * Returns correct HTMl for post thumbnails
 *
 * @since 1.0.0
 */
function wpsp_get_post_thumbnail( $args = array() ) {
	$attr       = array();

	// Default args
	$defaults = array(
		'attachment'    => get_post_thumbnail_id(),
		'size'          => 'full',
		'width'         => '',
		'height'        => '',
		'crop'          => 'center-center',
		'alt'           => '',
		'class'         => '',
		'return'        => 'html',
		'style'         => '',
		'schema_markup' => false,
		'placeholder'   => false,
	);

	// Parse args
	$args = wp_parse_args( $args, $defaults );

	// Extract args
	extract( $args );

	// Return dummy image
	if ( 'dummy' == $attachment || $placeholder ) {
		return '<img src="'. wpsp_placeholder_img_src() .'" />';
	}

	// Return if there isn't any attachment
	if ( ! $attachment ) {
		return;
	}

	// Sanitize variables
	$size = ( 'wpsp-custom' == $size ) ? 'wpsp_custom' : $size;
	$size = ( 'wpsp_custom' == $size ) ? false : $size;
	$crop = ( ! $crop ) ? 'center-center' : $crop;
	$crop = ( 'true' == $crop ) ? 'center-center' : $crop;

	// Image must have an alt
	if ( empty( $alt ) ) {
		$alt = get_post_meta( $attachment, '_wp_attachment_image_alt', true );
	}
	if ( empty( $alt ) ) {
		$alt = trim( strip_tags( get_post_field( 'post_excerpt', $attachment ) ) );
	}
	if ( empty( $alt ) ) {
		$alt = trim( strip_tags( get_the_title( $attachment ) ) );
		$alt = str_replace( '_', ' ', $alt );
		$alt = str_replace( '-', ' ', $alt );
	}

	// Prettify alt attribute
	if ( $alt ) {
		$alt = ucwords( $alt );
	}

	// If image width and height equal '9999' return full image
	if ( '9999' == $width && '9999' == $height ) {
		$size  = $size ? $size : 'full';
		$width = $height = '';
	}

	// Define crop locations
	$crop_locations = array_flip( wpsp_image_crop_locations() );

	// Set crop location if defined in format 'left-top' and turn into array
	if ( $crop && in_array( $crop, $crop_locations ) ) {
		$crop = ( 'center-center' == $crop ) ? true : explode( '-', $crop );
	}

	// Get attachment URl
	$attachment_url = wp_get_attachment_url( $attachment );

	// Return if there isn't any attachment URL
	if ( ! $attachment_url ) {
		return;
	}

	// Add classes
	if ( $class ) {
		$attr['class'] = $class;
	}

	// Add alt
	if ( $alt ) {
		$attr['alt'] = esc_attr( $alt );
	}

	// Add style
	if ( $style ) {
		$attr['style'] = $style;
	}

	// Add schema markup
	if ( $schema_markup ) {
		$attr['itemprop'] = 'image';
	}

	// If on the fly image resizing is enabled or a custom width/height is defined
	if ( wpsp_get_redux( 'is-image-resizing', true ) || ( $width || $height ) ) {

		// Add Classes
		if ( $class ) {
			$class = ' class="'. $class .'"';
		}

		// If size is defined and not equal to wpsp_custom
		if ( $size && 'wpsp_custom' != $size ) {
			$dims   = wpsp_get_thumbnail_sizes( $size );
			$width  = $dims['width'];
			$height = $dims['height'];
			$crop   = ! empty( $dims['crop'] ) ? $dims['crop'] : $crop;
		}


		// Crop standard image
		$image = wpsp_image_resize( array(
			'image'  => $attachment_url,
			'width'  => $width,
			'height' => $height,
			'crop'   => $crop,
		) );

		// Return HTMl
		if ( $image ) {

			// Return image URL
			if ( 'url' == $return ) {
				return $image['url'];
			}

			// Return image HTMl
			else {

				// Add attributes
				$attr = array_map( 'esc_attr', $attr );
				$html = '';
				foreach ( $attr as $name => $value ) {
					$html .= ' '. esc_attr( $name ) .'="'. esc_attr( $value ) .'"';
				}

				// Return img
				return '<img src="'. esc_url( $image['url'] ) .'" width="'. esc_attr( $image['width'] ) .'" height="'. esc_attr( $image['height'] ) .'"'. $html .' />';

			}

		}

	}

	// Return image from add_image_size
	else {

		// Sanitize size
		$size = $size ? $size : 'full';

		// Return image URL
		if ( 'url' == $return ) {
			$src = wp_get_attachment_image_src( $attachment, $size, false );
			return $src[0];
		}

		// Return image HTMl
		else {
			return wp_get_attachment_image( $attachment, $size, false, $attr );
		}

	}
}

/**
 * Placeholder Image
 *
 * @since 1.0.0
 */
function wpsp_placeholder_img_src() {
	return esc_url( apply_filters( 'wpsp_placeholder_img_src', get_template_directory_uri() .'/images/placeholder.png' ) );
}

/**
 * Returns thumbnail sizes
 *
 * @since 1.0.0
 */
function wpsp_get_thumbnail_sizes( $size = '' ) {

	global $_wp_additional_image_sizes;

	$sizes = array(
		'full'  => array(
			'width'  => '9999',
			'height' => '9999',
			'crop'   => 0,
		),
	);
	$get_intermediate_image_sizes = get_intermediate_image_sizes();

	// Create the full array with sizes and crop info
	foreach( $get_intermediate_image_sizes as $_size ) {

		if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$sizes[ $_size ]['width']   = get_option( $_size . '_size_w' );
			$sizes[ $_size ]['height']  = get_option( $_size . '_size_h' );
			$sizes[ $_size ]['crop']    = (bool) get_option( $_size . '_crop' );

		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

			$sizes[ $_size ] = array( 
				'width'     => $_wp_additional_image_sizes[ $_size ]['width'],
				'height'    => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'      => $_wp_additional_image_sizes[ $_size ]['crop']
			);

		}

	}

	// Get only 1 size if found
	if ( $size ) {
		if ( isset( $sizes[ $size ] ) ) {
			return $sizes[ $size ];
		} else {
			return false;
		}
	}

	// Return sizes
	return $sizes;
}

/*-------------------------------------------------------------------------------*/
/* [ Schema Markup ]
/*-------------------------------------------------------------------------------*/

/**
 * Outputs correct schema HTML for sections of the site
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_schema_markup') ) :
function wpsp_schema_markup( $location ) {
	echo wpsp_sanitize_data( wpsp_get_schema_markup( $location ), 'html' );
}
endif;

/**
 * Returns correct schema HTML for sections of the site
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_get_schema_markup') ) :
function wpsp_get_schema_markup( $location ) {

	// Return nothing if disabled
	if ( ! wpsp_get_redux( 'schema-markup-enable', true ) ) {
		return null;
	}

	// Loop through locations
	if ( 'body' == $location ) {
		$itemscope = 'itemscope';
		$itemtype  = 'http://schema.org/WebPage';
		if ( is_singular( 'post' ) ) {
			$type = "Article";
		} elseif ( is_author() ) {
			$type = 'ProfilePage';
		} elseif ( is_search() ) {
			$type = 'SearchResultsPage';
		}
		$schema = 'itemscope="'. $itemscope .'" itemtype="'. $itemtype .'"';
	} elseif ( 'header' == $location ) {
		$schema = 'itemscope="itemscope" itemtype="http://schema.org/WPHeader"';
	} elseif ( 'site_navigation' == $location ) {
		$schema = 'itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement"';
	} elseif ( 'main' == $location ) {
		$itemtype = 'http://schema.org/WebPageElement';
		$itemprop = 'mainContentOfPage';
		if ( is_singular( 'post' ) ) {
			$itemprop = '';
			$itemtype = 'http://schema.org/Blog';
		}
		$schema = 'itemprop="'. $itemprop .'" itemscope="itemscope" itemtype="'. $itemtype .'"';
	} elseif ( 'sidebar' == $location ) {
		$schema = 'itemscope="itemscope" itemtype="http://schema.org/WPSideBar"';
	} elseif ( 'footer' == $location ) {
		$schema = 'itemscope="itemscope" itemtype="http://schema.org/WPFooter"';
	} elseif ( 'footer_bottom' == $location ) {
		$schema = '';
	} elseif ( 'headline' == $location ) {
		$schema = 'itemprop="headline"';
	} elseif ( 'blog_post' == $location ) {
		$schema = 'itemprop="blogPost" itemscope="itemscope" itemtype="http://schema.org/BlogPosting"';
	} elseif ( 'entry_content' == $location ) {
		$schema = 'itemprop="text"';
	} elseif ( 'publish_date' == $location ) {
		$schema = 'itemprop="datePublished" pubdate';
	} elseif ( 'author_name' == $location ) {
		$schema = 'itemprop="name"';
	} elseif ( 'author_link' == $location ) {
		$schema = 'itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person"';
	} elseif ( 'image' == $location ) {
		$schema = 'itemprop="image"';
	} else {
		$schema = '';
	}

	// Apply filters and return
	return ' '. apply_filters( 'wpsp_get_schema_markup', $schema );

}
endif;

/*-------------------------------------------------------------------------------*/
/* [ Social Share ]
/*-------------------------------------------------------------------------------*/

/**
 * Checks if social share is enabled
 *
 * @since 1.0.0
 */
function wpsp_has_social_share() {

	$post_id = post_id();

	// Return false by default
	$return = false;

	// Page checked
	if ( is_page() ) {
		$return = wpsp_get_redux( 'is-social-share-pages' );
	}

	// Check if enabled on single blog posts
	elseif ( is_singular( 'post' ) ) {
		$return = true; // It uses the builder so we should return true
	}

	// Check post entries
	elseif ( 'post' == get_post_type() ) {
		$return = true; // if disabled by the entry won't matter
	}

	// Return if page header is disabled via custom field
	if ( $post_id ) {

		// Get page meta setting
		$meta = get_post_meta( $post_id, 'wpsp_is_social_share', true );

		// Return true if enabled via page settings
		if ( 'on' == $meta ) {
			$return = true;
		}

		// Return if page header is disabled and there isn't a page header background defined
		elseif ( 'off' == $meta ) {
			$return	= false;
		}

	}

	return apply_filters( 'wpsp_has_social_share', $return );
}

/**
 * Returns social sharing template part
 *
 * @since 1.0.0
 */
function wpsp_social_share_sites() {
    $sites = wpsp_get_redux( 'social-share-sites' );
    $sites = apply_filters( 'wpsp_social_share_sites', $sites );
    if ( $sites && ! is_array( $sites ) ) {
        $sites  = explode( ',', $sites );
    }
    return $sites;
}

/**
 * Returns correct social share position
 *
 * @since 1.0.0
 */
function wpsp_social_share_position() {
    $position = wpsp_get_redux( 'social-share-position' );
    $position = $position ? $position : 'horizontal';
    return apply_filters( 'wpsp_social_share_position', $position );
}

/**
 * Returns correct social share style
 *
 * @since 1.0.0
 */
function wpsp_social_share_style() {
    $style = wpsp_get_redux( 'social-share-style' );
    $style = $style ? $style : 'flat';
    return apply_filters( 'wpsp_social_share_style', $style );
}

/**
 * Returns the social share heading
 *
 * @since 1.0.0
 */
function wpsp_social_share_heading() {
    $heading = wpsp_get_translated_theme_mod( 'social_share_heading' );
    $heading = $heading ? $heading : esc_html__( 'Please Share This', 'newstore' );
    return apply_filters( 'wpsp_social_share_heading', $heading );
}

/*-------------------------------------------------------------------------------*/
/* [ Videos ]
/*-------------------------------------------------------------------------------*/

/**
 * Adds the sp-video class to an iframe
 *
 * @since 1.0.0
 */
function wpsp_add_sp_video_to_oembed( $oembed ) {
	return str_replace( 'iframe', 'iframe class="sp-video"', $oembed );
}

/**
 * Echo post video
 *
 * @since 1.0.0
 */
function wpsp_post_video( $post_id ) {
	echo wpsp_get_post_video( $post_id );
}

/**
 * Returns post video
 *
 * @since 1.0.0
 */
function wpsp_get_post_video( $post_id = '' ) {

	// Define video variable
	$video = '';

	// Get correct ID
	$post_id = $post_id ? $post_id : get_the_ID();

	// Embed
	if ( $meta = get_post_meta( $post_id, 'wpsp_post_video_embed', true ) ) {
		$video = $meta;
	}

	// Check for self-hosted first
	elseif ( $meta = get_post_meta( $post_id, 'wpsp_post_self_hosted_media', true ) ) {
		$video = $meta;
	}

	// Apply filters & return
	return apply_filters( 'wpsp_get_post_video', $video );

}

/**
 * Echo post video HTML
 *
 * @since 1.0.0
 */
function wpsp_post_video_html( $video = '' ) {
	echo wpsp_get_post_video_html( $video );
}

/**
 * Returns post video HTML
 *
 * @since 1.0.0
 */
function wpsp_get_post_video_html( $video = '' ) {

	// Get video
	$video = $video ? $video : wpsp_get_post_video();

	// Return if video is empty
	if ( empty( $video ) ) {
		return;
	}

	// Check post format for standard post type
	if ( 'post' == get_post_type() && 'video' != get_post_format() ) {
		return;
	}

	// Get oembed code and return
	if ( ! is_wp_error( $oembed = wp_oembed_get( $video ) ) && $oembed ) {
		return '<div class="responsive-video-wrap">'. $oembed .'</div>';
	}

	// Display using apply_filters if it's self-hosted
	else {

		$video = apply_filters( 'the_content', $video );

		// Add responsive video wrap for youtube/vimeo embeds
		if ( strpos( $video, 'youtube' ) || strpos( $video, 'vimeo' ) ) {
			return '<div class="responsive-video-wrap">'. $video .'</div>';
		}
		
		// Else return without responsive wrap
		else {
			return $video;
		}

	}

}

/*-------------------------------------------------------------------------------*/
/* [ Audio ]
/*-------------------------------------------------------------------------------*/

/**
 * Returns post audio
 *
 * @since 1.0.0
 */
function wpsp_get_post_audio( $id = '' ) {

	// Define video variable
	$audio = '';

	// Get correct ID
	$id = $id ? $id : get_the_ID();

	// Check for self-hosted first
	if ( $self_hosted = get_post_meta( $id, 'wpsp_post_self_hosted_media', true ) ) {
		$audio = $self_hosted;
	}

	// Check for post oembed
	elseif ( $post_oembed = get_post_meta( $id, 'wpsp_post_oembed', true ) ) {
		$audio = $post_oembed;
	}

	// Apply filters & return
	return apply_filters( 'wpsp_get_post_audio', $audio );

}

/**
 * Returns post audio
 *
 * @since 1.0.0
 */
function wpsp_get_post_audio_html( $audio = '' ) {

	// Get video
	$audio = $audio ? $audio : wpsp_get_post_audio();

	// Return if video is empty
	if ( empty( $audio ) ) {
		return;
	}

	// Get oembed code and return
	if ( ! is_wp_error( $oembed = wp_oembed_get( $audio ) ) && $oembed ) {
		return '<div class="responsive-audio-wrap">'. $oembed .'</div>';
	}

	// Display using apply_filters if it's self-hosted
	else {
		return apply_filters( 'the_content', $audio );
	}

}

/*-------------------------------------------------------------------------------*/
/* [ Taxonomy & Terms ]
/*-------------------------------------------------------------------------------*/

/**
 * Returns the "category" taxonomy for a given post type
 *
 * @since 1.0.0
 */
function wpsp_get_post_type_cat_tax( $post_type = '' ) {

	// Get the post type
	$post_type = $post_type ? $post_type : get_post_type();

	// Return taxonomy
	if ( 'post' == $post_type ) {
		$tax = 'category';
	} elseif ( 'portfolio' == $post_type ) {
		$tax = 'portfolio_category';
	} elseif ( 'staff' == $post_type ) {
		$tax = 'staff_category';
	} elseif ( 'testimonials' == $post_type ) {
		$tax = 'testimonials_category';
	} elseif ( 'product' == $post_type ) {
		$tax = 'product_cat';
	} elseif ( 'tribe_events' == $post_type ) {
		$tax = 'tribe_events_cat';
	} elseif ( 'download' == $post_type ) {
		$tax = 'download_category';
	} else {
		$tax = false;
	}

	// Apply filters & return
	return apply_filters( 'wpsp_get_post_type_cat_tax', $tax );

}

/**
 * Check if a post has terms/categories
 *
 * This function is used for the next and previous posts so if a post is in a category it
 * will display next and previous posts from the same category.
 *
 * @since 1.0.0
 */
function wpsp_post_has_terms( $post_id = '', $post_type = '' ) {

	// Post data
	$post_id    = $post_id ? $post_id : get_the_ID();
	$post_type  = $post_type ? $post_type : get_post_type( $post_id );

	// Standard Posts
	if ( $post_type == 'post' ) {
		$terms = get_the_terms( $post_id, 'category');
		if ( $terms ) {
			return true;
		}
	}

	// Portfolio
	elseif ( 'portfolio' == $post_type ) {
		$terms = get_the_terms( $post_id, 'portfolio_category');
		if ( $terms ) {
			return true;
		}
	}

	// Staff
	elseif ( 'staff' == $post_type ) {
		$terms = get_the_terms( $post_id, 'staff_category');
		if ( $terms ) {
			return true;
		}
	}

	// Testimonials
	elseif ( 'testimonials' == $post_type ) {
		$terms = get_the_terms( $post_id, 'testimonials_category');
		if ( $terms ) {
			return true;
		}
	}

}

function wpsp_has_term_description_above_loop( $return = false ) {

	// Return true for tags and categories only
	if (  'above_loop' == wpsp_get_redux( 'category-description-position' )
		&& ( is_category() || is_tag() )
	) {
		$return = true;
	}

	// Apply filters
	$return = apply_filters( 'wpsp_has_term_description_above_loop', $return );

	// Return
	return $return;

}

/*-------------------------------------------------------------------------------*/
/* [ Other ]
/*-------------------------------------------------------------------------------*/

/**
 * Returns correct theme button classes based on args
 *
 * @since 1.0.0
 */
function wpsp_get_button_classes( $style = '', $outline = '', $size = '', $align = '' ) {

	// Extract if style is an array of arguments
	if ( is_array( $style ) ) {
		extract( $style );
	}

	// Main classes
	if ( $style ) {
		$classes = 'btn ' . $style;
	} else {
		$classes = 'btn btn-link';
	}

	// Outline
	if ( $outline ) {
		$classes .= ' '. $outline;
	}

	// Size
	if ( $size ) {
		$classes .= ' '. $size;
	}

	// Align
	if ( $align ) {
		$classes .= ' align-'. $align;
	}

	// Apply filters and return classes
	return apply_filters( 'wpsp_get_theme_button_classes', $classes, $style, $color, $size, $align );
}

/**
 * Minify CSS
 *
 * @since 1.0.0
 */
function wpsp_minify_css( $css = '' ) {

	// Return if no CSS
	if ( ! $css ) return;

	// Normalize whitespace
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove ; before }
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } */ >
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

	// Remove space before , ; { }
	$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px)
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0)
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Trim
	$css = trim( $css );

	// Return minified CSS
	return $css;
	
}