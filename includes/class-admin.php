<?php
	class LWSB_Admin
	{

		public $text_domain;

		function __construct( $text_domain ){
				
			$this->text_domain = $text_domain;

			add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
			add_action( 'admin_init', array( $this, 'register_lwsb_settings' ) );

		}

		public function add_settings_page(){

			add_options_page(
				__( 'Lightweight Social Buttons', $this->text_domain ),
				__( 'Lightweight Social Buttons', $this->text_domain ),
				'manage_options',
				'leightweigt_social_buttons',
				array(
					$this,
					'lwsb_settings'
				)
			);

		}

		public function register_lwsb_settings() {

			//register our settings
			register_setting( 'lwsb-settings', 'lwsb_social_media' );
			register_setting( 'lwsb-settings', 'lwsb_social_media_show_in_overview' );
			register_setting( 'lwsb-settings', 'lwsb_social_media_post_type' );
		}

		public function lwsb_settings(){

			?>
			<div class="wrap">
			<h1><?php _e( 'Lightweight Social Buttons', $this->text_domain ); ?></h1>

			<form method="post" action="options.php">
			    <?php settings_fields( 'lwsb-settings' ); ?>
			    <?php do_settings_sections( 'lwsb-settings' ); ?>
			    <table class="form-table">
			        <tr valign="top">
				        <th scope="row"><?php _e( 'Social Media Buttons', $this->text_domain ); ?></th>
				        <td>
				        	<label>
				        		<input type="checkbox" name="lwsb_social_media[facebook]" value="1"<?php checked( isset( get_option('lwsb_social_media')['facebook'] ) ); ?> /> Facebook
				        	</label><br />
				        	<label>
				        		<input type="checkbox" name="lwsb_social_media[linkedin]" value="1"<?php checked( isset( get_option('lwsb_social_media')['linkedin'] ) ); ?> /> Linkedin
				        	</label><br />
				        	<label>
				        		<input type="checkbox" name="lwsb_social_media[twitter]" value="1"<?php checked( isset( get_option('lwsb_social_media')['twitter'] ) ); ?> /> Twitter
				        	</label><br />
				        	<label>
				        		<input type="checkbox" name="lwsb_social_media[google]" value="1"<?php checked( isset( get_option('lwsb_social_media')['google'] ) ); ?> /> Google Plus
				        	</label><br />
				        	<label>
				        		<input type="checkbox" name="lwsb_social_media[pinterest]" value="1"<?php checked( isset( get_option('lwsb_social_media')['pinterest'] ) ); ?> /> Pinterest
				        	</label><br />
				        	<label>
				        		<input type="checkbox" name="lwsb_social_media[email]" value="1"<?php checked( isset( get_option('lwsb_social_media')['email'] ) ); ?> /> E-mail
				        	</label>
				        </td>
			        </tr>
			        <tr valign="top">
				        <th scope="row"><?php _e( 'Show buttons in overview', $this->text_domain ); ?></th>
				        <td>
				        	<label>
				        		<input type="checkbox" name="lwsb_social_media_show_in_overview" value="1"<?php checked( get_option('lwsb_social_media_show_in_overview' ) ); ?> /> <?php _e( 'Show in overview', $this->text_domain ); ?>
				        	</label>
				        </td>
			        </tr>
			        <tr valign="top">
				        <th scope="row"><?php _e( 'Post Types', $this->text_domain ); ?></th>
				        <td>
				        	<?php
				        	$args = array(
				        		'public' => true
				        	);
				        	$post_types = get_post_types( $args );
				        	foreach ( $post_types as $id => $type ): ?>
				        	<label>
				        		<input type="checkbox" name="lwsb_social_media_post_type[<?php echo $id; ?>]" value="1"<?php checked( isset( get_option('lwsb_social_media_post_type')[$id] ) ); ?> /> <?php echo $type; ?>
				        	</label><br />
				        	<?php endforeach; ?>
				        </td>
			        </tr>
			    </table>
			    <?php submit_button(); ?>

			</form>
			</div>
			<?php

		}
	}

?>