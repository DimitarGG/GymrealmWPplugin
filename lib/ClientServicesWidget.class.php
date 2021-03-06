<?php // ѣ
/**
 * Definition of the GymRealm_ClientServicesWidget class.
 * 
 * @author pavelsof
 * @package GymRealm
 * @since 0.0.1
 */


class GymRealm_ClientServicesWidget extends WP_Widget {
	
	const TEMPLATE_NAME = 'gymrealm-client-services.php';
	
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct(
			'gymrealm_client_services_widget', 
			__('GymRealm Client Services', 'gymrealm'), 
			array('description' => __("Renders a list of the current user's services.", 'gymrealm'))
		);
		
	}
	
	
	/**
	 * Renders the form used for changing the widget's options.
	 * 
	 * @param array The widget options.
	 * @return void
	 */
 	public function form($instance) {
		return;
	}
	
	
	/**
	 * Handles the update of the widget's options.
	 * 
	 * @param array The new options.
	 * @param array The old options.
	 * @return array The newest options.
	 */
	public function update($new_instance, $old_instance) {
		return $new_instance;
	}
	
	
	/**
	 * Renders the widget.
	 * 
	 * @param array The widget arguments.
	 * @param array The widget options (the database stuff).
	 * @return void
	 */
	public function widget($args, $instance) {
		
		global $current_user, $gymrealm_plugin;
		get_currentuserinfo();
		
		try {
			$services = $gymrealm_plugin->api->get_client_services(
				$current_user->user_email
			);
		} catch(Exception $e) {
			$services = null;
			$error_message = $e->getMessage();
		}
		
		echo $before_widget;
		
		$theme_template = locate_template(self::TEMPLATE_NAME);
		if($theme_template) {
			include($theme_template);
		} else {
			include(dirname(dirname(__FILE__)) .'/tpl/'. self::TEMPLATE_NAME);
		}
		
		echo $after_widget;
	}
	
}

?>
