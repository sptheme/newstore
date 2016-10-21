<?php
/**
 * Recent Posts w/ Thumbnails
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 * @package Total WordPress Theme
 * @subpackage Widgets
 * @version 1.0.0
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'WPSP_Newsletter_Widget' ) ) {
	class WPSP_Newsletter_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$branding = wpsp_get_theme_branding();
			$branding = $branding ? $branding . ' - ' : '';
			parent::__construct(
				'wpsp_mailchimp',
				$branding . esc_html__( 'MailChimp Newsletter', 'newstore' )
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 * @since 1.0.0
		 *
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			// Args
			$title            = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
			$heading          = isset( $instance['heading'] ) ? $instance['heading'] : esc_html__( 'NEWSLETTER','newstore' );
			$email_holder_txt = ! empty( $instance['placeholder_text'] ) ? $instance['placeholder_text'] : '';
			$email_holder_txt = $email_holder_txt ? $email_holder_txt : esc_html__( 'Your email address', 'newstore' );
			$name_field       = ! empty( $instance['name_field'] ) ? true : false;
			$name_holder_txt  = ! empty( $instance['name_placeholder_text'] ) ? $instance['name_placeholder_text'] : '';
			$name_holder_txt  = $name_holder_txt ? $name_holder_txt : esc_html__( 'First name', 'newstore' );
			$button_text      = ! empty( $instance['button_text'] ) ? $instance['button_text'] : esc_html__( 'Subscribe', 'newstore' );
			$form_action      = isset( $instance['form_action'] ) ? $instance['form_action'] : 'http://wpexplorer.us1.list-manage1.com/subscribe/post?u=9b7568b7c032f9a6738a9cf4d&id=7056c37ddf';
			$description      = isset( $instance['description'] ) ? $instance['description'] : '';

			// Before widget hook
			echo $args['before_widget']; ?>

				<?php
				// Display widget title
				if ( $title ) {
					echo $args['before_title'] . $title . $args['after_title'];
				} ?>

				<?php if ( $form_action ) { ?>

					<div class="wpsp-newsletter-widget">

						<?php
						// Display the heading
						if ( $heading ) { ?>

							<h4 class="wpsp-newsletter-widget-heading"><?php echo wpsp_sanitize_data( $heading, 'html' ); ?></h4>

						<?php } ?>

						<?php
						// Display the description
						if ( $description ) { ?>

							<div class="wpsp-newsletter-widget-description">
								<?php echo wpsp_sanitize_data( $description, 'html' ); ?>
							</div>

						<?php } ?>

							<form action="<?php echo esc_attr( $form_action ); ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>

								<?php if ( $name_field ) : ?>
								<div class="form-group">
									<input type="text" class="form-control" value="<?php echo esc_attr( $name_holder_txt ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" name="FNAME" id="mce-FNAME" autocomplete="off">
								</div>	
								<?php endif; ?>
								<div class="input-group">
									<input type="email" class="form-control" value="<?php echo esc_attr( $email_holder_txt ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" name="EMAIL" id="mce-EMAIL" autocomplete="off">
									<span class="input-group-btn">
										<button type="submit" value="" name="subscribe" class="btn btn-primary"><?php echo strip_tags( $button_text ); ?></button>
									</span>
								</div>
								<?php echo apply_filters( 'wpsp_mailchimp_widget_form_extras', null ); ?>

							</form>

					</div><!-- .mailchimp-widget -->

				<?php } else { ?>

					<?php esc_html_e( 'Please enter your Mailchimp form action link.', 'newstore' ); ?>

				<?php } ?>

			<?php
			// After widget hook
			echo $args['after_widget'];
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 * @since 1.0.0
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['heading'] = ! empty( $new_instance['heading'] ) ? wpsp_sanitize_data( $new_instance['heading'], 'html' ) : '';
			$instance['description'] = ! empty( $new_instance['description'] ) ? wpsp_sanitize_data( $new_instance['description'], 'html' ) : '';
			$instance['form_action'] = ! empty( $new_instance['form_action'] ) ? strip_tags( $new_instance['form_action'] ) : '';
			$instance['placeholder_text'] = ! empty( $new_instance['placeholder_text'] ) ? strip_tags( $new_instance['placeholder_text'] ) : '';
			$instance['button_text'] = ! empty( $new_instance['button_text'] ) ? strip_tags( $new_instance['button_text'] ) : '';
			$instance['name_field'] = isset( $new_instance['name_field'] ) ? 1 : 0;
			$instance['name_placeholder_text'] = ! empty( $new_instance['name_placeholder_text'] ) ? strip_tags( $new_instance['name_placeholder_text'] ) : '';
			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 * @since 1.0.0
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			
			extract( wp_parse_args( ( array ) $instance, array(
				'title'                 => '',
				'heading'               => esc_html__( 'NEWSLETTER','newstore' ),
				'description'           => '',
				'form_action'           => 'http://wpexplorer.us1.list-manage1.com/subscribe/post?u=9b7568b7c032f9a6738a9cf4d&id=7056c37ddf',
				'placeholder_text'      => esc_html__( 'Your email address', 'newstore' ),
				'button_text'           => esc_html__( 'Subscribe', 'newstore' ),
				'name_placeholder_text' => esc_html__( 'First name', 'newstore' ),
				'name_field'            => 0,
			) ) ); ?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'newstore' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"><?php esc_html_e( 'Heading', 'newstore' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'heading' ) ); ?>" type="text" value="<?php echo esc_attr( $heading ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'form_action' ) ); ?>"><?php esc_html_e( 'Form Action', 'newstore' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'form_action' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'form_action' ) ); ?>" type="text" value="<?php echo esc_attr( $form_action ); ?>" />
				<span style="display:block;padding:5px 0" class="description">
					<a href="//docs.shopify.com/support/configuration/store-customization/where-do-i-get-my-mailchimp-form-action?ref=wpexplorer" target="_blank"><?php esc_html_e( 'Learn more', 'newstore' ); ?>&rarr;</a>
				</span>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description:','newstore' ); ?></label>
				<textarea class="widefat" rows="5" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo wpsp_sanitize_data( $description, 'html' ); ?></textarea>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'name_field' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name_field' ) ); ?>" <?php checked( $name_field, 1, true ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'name_field' ) ); ?>"><?php esc_html_e( 'Display Name Field?', 'newstore' ); ?></label>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'name_placeholder_text' ) ); ?>"><?php esc_html_e( 'Name Input Placeholder Text', 'newstore' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name_placeholder_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name_placeholder_text' ) ); ?>" type="text" value="<?php echo esc_attr( $name_placeholder_text ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'placeholder_text' ) ); ?>"><?php esc_html_e( 'Email Input Placeholder Text', 'newstore' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'placeholder_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'placeholder_text' ) ); ?>" type="text" value="<?php echo esc_attr( $placeholder_text ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Button Text', 'newstore' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" />
			</p>
			<?php
		}
	}
}
register_widget( 'WPSP_Newsletter_Widget' );