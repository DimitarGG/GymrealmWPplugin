<?php // ѣ
/**
 * Definition of the GymRealm_AddClientWidget class.
 * 
 * @author pavelsof
 * @package GymRealm
 * @since 0.0.1
 */


class GymRealm_AddClientWidget extends WP_Widget {
	
	const TEMPLATE_NAME = 'gymrealm-add-client.php';
	
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct(
			'gymrealm_add_client_widget', 
			__('GymRealm Add Client', 'gymrealm'), 
			array('description' => __("Renders client registration form.", 'gymrealm'))
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
		
		global $gymrealm_plugin;
		
		try {
			
			$gyms = $gymrealm_plugin->api->get_gyms();
			
			foreach($gyms as $gym) {
				$gym->areas = $gymrealm_plugin->api->get_areas($gym->GymID);
			}
			
			$visits = $gymrealm_plugin->api->get_visits();
			$instructors = $gymrealm_plugin->api->get_instructors();
			
		} catch(Exception $e) {
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
