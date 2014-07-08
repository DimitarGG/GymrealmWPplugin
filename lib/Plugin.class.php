<?php // ѣ
/**
 * Definition of the GymRealm_Plugin class.
 * 
 * @author pavelsof
 * @package GymRealm
 * @since 0.0.1
 */

require_once('Api.class.php');

require_once('BookScheduleWidget.class.php');
require_once('ClientServicesWidget.class.php');


class GymRealm_Plugin {
	
	const OPTION_NAMESPACE = 'gymrealm_namespace';
	
	public $api = null;
	
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
		add_action('plugins_loaded', array(&$this, plugins_loaded));
		add_action('widgets_init', array(&$this, widgets_init));
		add_action('wp_enqueue_script', array(&$this, wp_enqueue_script));
		
		$this->api = new GymRealm_Api();
		
	}
	
	
	/**
	 * Loads the plugin's internationalisation.
	 * 
	 * Called by the WordPress action plugins_loaded.
	 * 
	 * @return void
	 */
	public function plugins_loaded() {
		
		load_plugin_textdomain(
			'gymrealm',
			false,
			dirname(plugin_basename(__FILE__)) .'/lang/'
		);
		
	}
	
	
	/**
	 * Loads the plugin's widgets.
	 * 
	 * Called by the WordPress action widgets_init.
	 * 
	 * @return void
	 */
	public function widgets_init() {
		
		register_widget('GymRealm_BookScheduleWidget');
		register_widget('GymRealm_ClientServicesWidget');
		
	}
	
	
	/**
	 * Loads the plugin's scripts.
	 * 
	 * Called by the WordPress action wp_enqueue_script.
	 * 
	 * @return void
	 */
	public function wp_enqueue_script() {
		
		wp_enqueue_script('jquery');
		
	}
	
	
}

?>
