<?php // ѣ
/**
 * Template for GymRealm_BookScheduleWidget.
 * 
 * The following variables are available:
 * $gyms, $visits, $instructors.
 * Otherwise $error_message is not NULL.
 * 
 * @package GymRealm
 * @since 0.0.1
 */

?>
<?php if($gyms) { ?>
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
	
	<label for="gymrealm_datetime"><?php _e("Starting", 'gymrealm'); ?></label>
	<input type="text" name="datetime" id="gymrealm_datetime" />
	
	<label for="gymrealm_duration"><?php _e("Duration", 'gymrealm'); ?></label>
	<input type="text" name="duration" id="gymrealm_duration" />
	
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
<?php } else { ?>
<p><?php echo $error_message; ?></p>
<?php } ?>
