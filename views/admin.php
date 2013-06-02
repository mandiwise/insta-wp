<?php 

if(!class_exists('InstaWP_Settings')) { 
	class InstaWP_Settings { 
		
		// - array of sections for the plugin -
		private $sections;
		private $checkboxes;
		private $settings;
		
		// - construct the plugin settings object -
		public function __construct() { 
			
			$this->checkboxes = array();
			$this->settings = array();
			$this->instawp_get_settings();
			
			// - create the settings sections -
			$this->sections['api'] = __( 'Instagram Authentication', 'insta-wp-locale' );
			$this->sections['display'] = __( 'Instagram Feed Shortcode', 'insta-wp-locale' );
			
			add_action('admin_menu', array(&$this, 'instawp_add_submenu'));
			add_action('admin_init', array(&$this, 'instawp_admin_init'));  
			
			if ( ! get_option( 'instawp_options' ) )
			$this->instawp_initialize_settings();
			
		}
		
		// - create the settings fields -
		public function instawp_create_setting( $args = array() ) {
		
			$defaults = array(
				'section' => 'general',
				'id'      => 'default_field',
				'title'   => __( 'Default Field', 'insta-wp-locale' ),
				'desc'    => '',
				'std'     => '',
				'type'    => 'text',
				'choices' => array(),
				'class'   => ''
			);
			
			extract( wp_parse_args( $args, $defaults ) );
		
			$field_args = array(
				'type'      => $type,
				'id'        => $id,
				'desc'      => $desc,
				'std'       => $std,
				'choices'   => $choices,
				'label_for' => $id,
				'class'     => $class
			);
		
			if ( $type == 'checkbox' )
				$this->checkboxes[] = $id;
		
			add_settings_field( $id, $title, array( $this, 'instawp_display_setting' ), 'instawp-options', $section, $field_args );
		}
		
		// - create the HTML output for each possible type of setting -
		public function instawp_display_setting( $args = array() ) {
		
			extract( $args );
			$options = get_option( 'instawp_options' );
		
			if ( ! isset( $options[$id] ) && $type != 'checkbox' )
				$options[$id] = $std;
			elseif ( ! isset( $options[$id] ) )
				$options[$id] = 0;
		
			$field_class = '';
			if ( $class != '' )
				$field_class = ' ' . $class;
		
			switch ( $type ) {
			
				case 'checkbox':
					echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="instawp_options[' . $id . ']" value="1" ' . checked( $options[$id], 1, false ) . ' /> <label for="' . $id . '">' . $desc . '</label>';
					break;
			
				case 'select':
					echo '<select class="select' . $field_class . '" name="instawp_options[' . $id . ']">';
					foreach ( $choices as $value => $label )
						echo '<option value="' . esc_attr( $value ) . '"' . selected( $options[$id], $value, false ) . '>' . $label . '</option>';
					echo '</select>';
				
					if ( $desc != '' )
						echo '<p class="description">' . $desc . '</p>';
					break;
			
				case 'radio':
					$i = 0;
					foreach ( $choices as $value => $label ) {
						echo '<input class="radio' . $field_class . '" type="radio" name="instawp_options[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr( $value ) . '" ' . checked( $options[$id], $value, false ) . '> <label for="' . $id . $i . '">' . $label . '</label>';
						if ( $i < count( $options ) - 1 )
							echo '<br />';
						$i++;
					}
				
					if ( $desc != '' )
						echo '<p class="description">' . $desc . '</p>';
					break;
			
				case 'textarea':
					echo '<textarea class="' . $field_class . '" id="' . $id . '" name="instawp_options[' . $id . ']" placeholder="' . $std . '" rows="5" cols="30">' . wp_htmledit_pre( $options[$id] ) . '</textarea>';
				
					if ( $desc != '' )
						echo '<p class="description">' . $desc . '</p>';
					break;
			
				case 'password':
					echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="instawp_options[' . $id . ']" value="' . esc_attr( $options[$id] ) . '" />';
				
					if ( $desc != '' )
						echo '<p class="description">' . $desc . '</p>';
					break;
			
				case 'text':
				default:
					echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="instawp_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr( $options[$id] ) . '" />';
				
					if ( $desc != '' )
						echo '<p class="description">' . $desc . '</p>';
					break;
			
			}
		
		}
		
		// - define all settings for this plugin and their defaults -
		public function instawp_get_settings() {
		
			// - api section -		
			$this->settings['clientID'] = array(
				'section' => 'api',
				'title'   => __( 'Instagram Client ID:', 'insta-wp-locale' ),
				'desc'    => __( 'Once you\'ve registered a new client with the Instagram API, enter its Client ID here.', 'insta-wp-locale' ),
				'std'     => '',
				'type'    => 'text'
			);
			$this->settings['accessToken'] = array(
				'section' => 'api',
				'title'   => __( 'Access Token:', 'insta-wp-locale' ),
				'desc'    => __( 'Add your assigned access token. Generate one ', 'insta-wp-locale'). '<a href="http://www.pinceladasdaweb.com.br/instagram/access-token/">'. __('here', 'insta-wp-locale') .'</a>.',
				'std'     => '',
				'type'    => 'text'
			);
			
			// - display section -
			$this->settings['displayby'] = array(
				'section' => 'display',
				'title'   => __( 'Display images based on:', 'insta-wp-locale' ),
				'std'     => 'none',
				'type'    => 'select',
				'choices' => array(
					'none' => __( ' Please select ', 'insta-wp-locale' ),
					'byhash' => __( 'A hash tag', 'insta-wp-locale' ),
					'byuser' => __( 'A username', 'insta-wp-locale' )
				)
			);
			$this->settings['hash'] = array(
				'section' => 'display',
				'title'   => __( 'Hash tag:', 'insta-wp-locale' ),
				'desc'    => __( 'Add your hash tag as letters and/or numbers only. Do not include "#" before the text.', 'insta-wp-locale' ),
				'std'     => '',
				'type'    => 'text'
			);
			$this->settings['username'] = array(
				'section' => 'display',
				'title'   => __( 'Username:', 'insta-wp-locale' ),
				'desc'    => __( 'Add your Instagram username (e.g. "johnsmith").', 'insta-wp-locale' ),
				'std'     => '',
				'type'    => 'text'
			);
			$this->settings['max'] = array(
				'section' => 'display',
				'title'   => __( 'Number of photos to show:', 'insta-wp-locale' ),
				'std'     => '10',
				'type'    => 'select',
				'choices' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => '7',
					'8' => '8',
					'9' => '9',
					'10' => '10',
					'11' => '11',
					'12' => '12',
					'13' => '13',
					'14' => '14',
					'15' => '15',
					'16' => '16',
					'17' => '17',
					'18' => '18',
					'19' => '19',
					'20' => '20'
				)
			);
			$this->settings['size'] = array(
				'section' => 'display',
				'title'   => __( 'Image size:', 'insta-wp-locale' ),
				'type'    => 'select',
				'std'     => 'medium',
				'choices' => array(
					'small' => __( 'Small', 'insta-wp-locale' ),
					'medium' => __( 'Medium', 'insta-wp-locale' ),
					'big' => __( 'Big', 'insta-wp-locale' )
				)
			);
		
		}
		
		// - initialize the settings to their default values -
		public function instawp_initialize_settings() {
		
			$default_settings = array();
			foreach ( $this->settings as $id => $setting ) {
				$default_settings[$id] = $setting['std'];
			}
		
			update_option( 'instawp_options', $default_settings );
		
		}
		
		public function display_api_section() {
			echo '<p>'. __( 'In order to use this plugin you\'ll need to ', 'insta-wp-locale' ) .'<a href="http://instagram.com/developer/">'. __('register for the Instagram API', 'insta-wp-locale' ) .'</a>.</p>'; 
		}
		
		public function display_display_section() {
			echo '<p>'. __( 'Customize the settings below to make your shortcode:', 'insta-wp-locale' ) .'</p>'; 
		}
		
		public function display_section() {
			// - default shows no description - 
		}
		
		public function instawp_admin_init() {
		
			register_setting( 'instawp_options', 'instawp_options', array( &$this, 'instawp_validate_settings' ) );
		
			foreach ( $this->sections as $slug => $title ) {
				if ( $slug == 'api' )
					add_settings_section( $slug, $title, array( &$this, 'display_api_section' ), 'instawp-options' );
				elseif ( $slug == 'display' )
					add_settings_section( $slug, $title, array( &$this, 'display_display_section' ), 'instawp-options' );
				else
					add_settings_section( $slug, $title, array( &$this, 'display_section' ), 'instawp-options' );
			}	

			$this->instawp_get_settings();

			foreach ( $this->settings as $id => $setting ) {
				$setting['id'] = $id;
				$this->instawp_create_setting( $setting );
		
			}
		}
		
		// - add the submenu page -
		public function instawp_add_submenu() { 
			add_options_page( 'Insta WP', 'Insta WP', 'manage_options', 'instawp-options', array(&$this, 'instawp_plugin_settings_page') );
		}
		
		public function instawp_plugin_settings_page() { 
			if(!current_user_can('manage_options')) { 
				wp_die( __('Sorry! You don\'t have sufficient permissions to access this page.', 'insta-wp-locale') ); 
			} 
			
			// - render the settings template - 
			include(sprintf("%s/settings.php", dirname(__FILE__))); 
		}
		
		public function instawp_validate_settings( $input ) {
			// - create array for storing the validated options  
			$output = array();  
  
			// - loop through each of the incoming options -
			foreach( $input as $key => $value ) {  
	  
				// - check to see if the current option has a value and then process it -  
				if( isset( $input[$key] ) ) {  
					$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );  
				}
	  
			}
			
			// - add settings error if client ID is empty -
			if ( $input[ 'clientID' ] == '' ) {
				add_settings_error( 'clientID', 'clientid', __( 'Please enter a Client ID.', 'insta-wp-locale' ) );
			}
			
			// - add settings error if access token is empty -
			if ( $input[ 'accessToken' ] == '' ) {
				add_settings_error( 'accessToken', 'accesstoken', __( 'Please enter an Access Token.', 'insta-wp-locale' ) );
			}

			return apply_filters( 'instawp_validate_settings', $output, $input ); 
		}
		
	} // - end class InstaWP_Settings -
} // - end 'if class exists' -

// * Gets the plugin options (to be used in other plugin files) *
	
function instawp_option( $option ) {
	$options = get_option( 'instawp_options' );
	if ( isset( $options[$option] ) )
		return $options[$option];
	else
		return false;
}