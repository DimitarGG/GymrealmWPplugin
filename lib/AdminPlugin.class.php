<?php // ѣ
/**
 * Definition of the GymRealm_AdminPlugin class.
 * 
 * Methods that render HTML are towards the bottom of the file.
 * 
 * @author pavelsof
 * @package GymRealm
 * @since 0.0.1
 */

require_once('Plugin.class.php');


class GymRealm_AdminPlugin extends GymRealm_Plugin {
	
	const PAGE_SLUG_SETTINGS = 'gymrealm_settings';
	
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		
		add_action('admin_init', array(&$this, admin_init));
		add_action('admin_menu', array(&$this, admin_menu));
		
		add_action('wp_ajax_gymrealm_add_client', array(&$this, wp_ajax_gymrealm_add_client));
		add_action('wp_ajax_nopriv_gymrealm_add_client', array(&$this, wp_ajax_gymrealm_add_client));
		
		add_action('wp_ajax_gymrealm_book_schedule', array(&$this, wp_ajax_gymrealm_book_schedule));
		add_action('wp_ajax_nopriv_gymrealm_book_schedule', array(&$this, wp_ajax_gymrealm_book_schedule));
		
	}
	
	
	/**
	 * Loads the plugin's admin pages.
	 * 
	 * Called by the WordPress action admin_menu.
	 * 
	 * @return void
	 */
	public function admin_menu() {
		
		add_menu_page(
			__("GymRealm", 'gymrealm'), # page title
			__("GymRealm", 'gymrealm'), # menu title
			'manage_options', # privileges needed
			GymRealm_AdminPlugin::PAGE_SLUG_SETTINGS, # slug
			array(&$this, do_settings_page),
			'dashicons-universal-access-alt'
		);
		
		/*add_submenu_page(
			'gymrealm',
			__("GymRealm Settings", 'gymrealm'), # page title
			__("Settings", 'gymrealm'), # menu title
			'manage_options', # privileges needed
			GymRealm_AdminPlugin::PAGE_SLUG_SETTINGS, # slug
			array(&$this, do_settings_page)
		);*/
		
	}
	
	
	/**
	 * Loads the plugin's admin settings.
	 * 
	 * Called by the WordPress action admin_init.
	 * 
	 * @return void
	 */
	public function admin_init() {
		
		register_setting(
			'gymrealm',
			GymRealm_Plugin::OPTION_NAMESPACE,
			array(&$this, sanitise_namespace)
		);
		
		add_settings_section(
			'gymrealm_api_settings_section',
			__("API Integration", 'gymrealm'),
			array(&$this, do_api_settings_section),
			GymRealm_AdminPlugin::PAGE_SLUG_SETTINGS
		);
		
		add_settings_field(
			GymRealm_Plugin::OPTION_NAMESPACE,
			__("Namespace", 'gymrealm'),
			array(&$this, do_namespace_field),
			GymRealm_AdminPlugin::PAGE_SLUG_SETTINGS,
			'gymrealm_api_settings_section',
			array(
				'label_for'	=>	GymRealm_Plugin::OPTION_NAMESPACE
			)
		);
		
	}
	
	
	/**
	 * Echoes something after the API settings section title.
	 * 
	 * @return void
	 */
	public function do_api_settings_section() {
		_e("Set up your API credentials here.", 'gymrealm');
	}
	
	
	/**
	 * Checks whether the POSTed OPTION_NAMESPACE option is OK.
	 * 
	 * @param string The POSTed value.
	 * @return string The sanitised value.
	 */
	public function sanitise_namespace($input) {
		
		/*if(empty($input)) {
			add_settings_error(
				GymRealm_Plugin::OPTION_NAMESPACE,
				'empty',
				__("Namespace cannot be empty!", 'gymrealm'),
				'error'
			);
		}*/
		
		return sanitize_key($input);
		
	}
	
	
	/**
	 * Echoes the form control for OPTION_NAMESPACE.
	 * 
	 * @return void
	 */
	public function do_namespace_field() {
		
		$value = get_option(GymRealm_Plugin::OPTION_NAMESPACE, '');
		
		?>
		<input 
			type="text" 
			name="<?php echo GymRealm_Plugin::OPTION_NAMESPACE ?>" 
			id="<?php echo GymRealm_Plugin::OPTION_NAMESPACE ?>" 
			value="<?php echo $value; ?>" 
			class="regular-text"
		/>
		<?php
		
	}
	
	
	/**
	 * Echoes the plugin's Settings page.
	 * 
	 * @return void
	 */
	public function do_settings_page() {
		
		?>
		<div class="wrap">
			<h2><?php _e("GymRealm Settings", 'gymrealm'); ?></h2>
			<?php settings_errors(); ?>
			<form action="options.php" method="post">
				<?php settings_fields('gymrealm'); ?>
				<?php do_settings_sections(GymRealm_AdminPlugin::PAGE_SLUG_SETTINGS); ?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
		
	}
	
	
	/**
	 * AJAX back-end for the AddClientWidget.
	 * 
	 * Called by the WordPress actions wp_ajax_* and wp_ajax_nopriv_*.
	 * 
	 * @return void
	 */
	public function wp_ajax_gymrealm_add_client() {
		
		$args = array();
		
		$args['name'] = sanitize_text_field($_POST['name']);
		$args['email'] = sanitize_email($_POST['email']);
		$args['phone'] = sanitize_text_field($_POST['phone']);
		$args['company'] = sanitize_text_field($_POST['company']);
		$args['location'] = sanitize_text_field($_POST['location']);
		
		if($this->api->post_add_client($args)) {
			$message = array(
				'status'=>	'success',
				'text'	=>	__("Your registration was received. Thank you.", 'gymrealm')
			);
		} else {
			$message = array(
				'status'=>	'error',
				'text'	=>	__("There was an error processing your inquiry. Please contact support.", 'gymrealm')
			);
		}
		
		echo json_encode($message);
		die();
		
	}
	
	
	/**
	 * AJAX back-end for the BookScheduleWidget.
	 * 
	 * Called by the WordPress actions wp_ajax_* and wp_ajax_nopriv_*.
	 * 
	 * @return void
	 */
	public function wp_ajax_gymrealm_book_schedule() {
		
		global $current_user;
		get_currentuserinfo();
		
		$args = array();
		
		$args['area'] = absint($_POST['area']);
		$args['datetime'] = sanitize_text_field($_POST['datetime']);
		$args['duration'] = absint($_POST['duration']);
		$args['gym'] = absint($_POST['gym']);
		
		if(isset($_POST['instructor'])) {
			$args['instructor'] = absint($_POST['instructor']);
		}
		if(isset($_POST['comment'])) {
			$args['comment'] = sanitize_text_field($_POST['comment']);
		}
		if(isset($_POST['visit'])) {
			$args['visit'] = absint($_POST['visit']);
		}
		
		$args['email'] = $current_user->user_email;
		$args['phone'] = '';
		
		if($this->api->post_book_schedule($args)) {
			$message = array(
				'status'=>	'success',
				'text'	=>	__("Your inquiry was received. Thank you.", 'gymrealm')
			);
		} else {
			$message = array(
				'status'=>	'error',
				'text'	=>	__("There was an error processing your inquiry. Please contact support.", 'gymrealm')
			);
		}
		
		echo json_encode($message);
		die();
		
	}
	
	
}

?>
