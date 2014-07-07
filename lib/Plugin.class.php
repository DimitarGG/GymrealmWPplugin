<?php // ѣ
/**
 * Definition of the GymRealm_Plugin class.
 * 
 * @author pavelsof
 * @package GymRealm
 * @since 0.0.1
 */

require_once('Api.class.php');


class GymRealm_Plugin {
	
	const OPTION_GYM = 'gymrealm_gym';
	
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
		# internationalisation
		add_action('plugins_loaded', array(&$this, plugins_loaded));
		
		
		
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
	
	
}

?>
