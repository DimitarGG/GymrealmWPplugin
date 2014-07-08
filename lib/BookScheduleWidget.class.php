<?php // ѣ
/**
 * Definition of the GymRealm_BookScheduleWidget class.
 * 
 * @author pavelsof
 * @package GymRealm
 * @since 0.0.1
 */


class GymRealm_BookScheduleWidget extends WP_Widget {
	
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct(
			'gymrealm_book_schedule_widget', 
			__('GymRealm Book Schedule', 'gymrealm'), 
			array('description' => __("Renders a schedule booking form.", 'gymrealm'))
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
		
		$gyms = $gymrealm_plugin->api->get_gyms();
		
		foreach($gyms as $gym) {
			$gym->areas = $gymrealm_plugin->api->get_areas($gym->GymID);
		}
		
		$visits = $gymrealm_plugin->api->get_visits();
		$instructors = $gymrealm_plugin->api->get_instructors();
		
		echo $before_widget;
		
		?>
		<form action="" method="post" id="gymrealm_book_schedule_form">
			<div class="message"></div>
			
			<label for="gymrealm_gym"><?php _e("Gym", 'gymrealm'); ?></label>
			<select name="gym" id="gymrealm_gym">
				<?php foreach($gyms as $gym) { ?>
				<option value="<?php echo $gym->GymID; ?>"><?php echo $gym->GymName; ?></option>
				<?php } ?>
			</select>
			
			<label for="gymrealm_area"><?php _e("Area", 'gymrealm'); ?></label>
			<select name="area" id="gymrealm_area">
				<?php foreach($gyms as $gym) { ?>
				<?php foreach($gym->areas as $area) { ?>
				<option value="<?php echo $area->AreaID; ?>" data-gym="<?php echo $gym->GymID; ?>">
					<?php echo $area->Name; ?>
				</option>
				<?php } ?>
				<?php } ?>
			</select>
			
			<label for="gymrealm_visits"><?php _e("Visit Type", 'gymrealm'); ?></label>
			<select name="visit" id="gymrealm_visits">
				<?php foreach($visits as $visit) { ?>
				<option value="<?php echo $visit->VisitDefinitionID; ?>"><?php echo $visit->VisitName; ?></option>
				<?php } ?>
			</select>
			
			<label for="gymrealm_instructor"><?php _e("Instructor", 'gymrealm'); ?></label>
			<select name="instructor" id="gymrealm_instructor">
				<option value="0"><?php _e("No preference", 'gymrealm'); ?></option>
				<?php foreach($instructors as $instructor) { ?>
				<option value="<?php echo $instructor->InstructorID; ?>"><?php echo $instructor->Name; ?></option>
				<?php } ?>
			</select>
			
			<label for="gymrealm_comment"><?php _e("Comment", 'gymrealm'); ?></label>
			<input type="text" name="comment" id="gymrealm_comment" />
			
			<label for="gymrealm_time_start"><?php _e("Starting", 'gymrealm'); ?></label>
			<input type="text" name="time_start" id="gymrealm_time_start" />
			
			<label for="gymrealm_time_duration"><?php _e("Duration", 'gymrealm'); ?></label>
			<input type="text" name="time_duration" id="gymrealm_time_duration" />
			
			<button type="submit"><?php _e("Book!", 'gymrealm'); ?></button>
		</form>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var form = $('#gymrealm_book_schedule_form');
				var message = form.find('.message');
				var select_gym = form.find('select#gymrealm_gym');
				var select_area = form.find('select#gymrealm_area');
				
				select_gym.change(update_select_area);
				update_select_area();
				
				function update_select_area() {
					select_area.find('option').hide();
					select_area.find('option[data-gym='+ select_gym.val() +']').show();
					var first_value = select_area.find('option:visible').attr('value');
					select_area.val(first_value);
				}
				
				form.submit(function() {
					form.find('button[type=submit]').prop('disabled', true);
					post_data = form.serializeArray();
					post_data.push({name: 'action', value: 'gymrealm_book_schedule'});
					$.post(
						'<?php echo admin_url('admin-ajax.php'); ?>',
						post_data,
						function(message) {
							if(message.status == 'success') {
								form.find('.message').html(message.text).show();
							}
							else {
								form.find('.message').html(message.text).show();
								form.find('button[type=submit]').prop('disabled', false);
							}
						},
						'json'
					);
					return false;
				});
			});
		</script>
		<?php
		
		echo $after_widget;
		
	}
	
}

?>
