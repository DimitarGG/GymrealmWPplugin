<?php // ѣ
/**
 * Template for GymRealm_AddClientWidget.
 * 
 * @package GymRealm
 * @since 0.0.1
 */

?>
<form action="" method="post" id="gymrealm_add_client_form">
	<div class="message"></div>
	
	<label for="gymrealm_name"><?php _e("Name", 'gymrealm'); ?></label>
	<input type="text" name="name" id="gymrealm_name" />
	
	<label for="gymrealm_email"><?php _e("Email", 'gymrealm'); ?></label>
	<input type="email" name="email" id="gymrealm_email" />
	
	<label for="gymrealm_phone"><?php _e("Phone", 'gymrealm'); ?></label>
	<input type="text" name="phone" id="gymrealm_phone" />
	
	<label for="gymrealm_company"><?php _e("Company", 'gymrealm'); ?></label>
	<input type="text" name="company" id="gymrealm_company" />
	
	<label for="gymrealm_location"><?php _e("Location", 'gymrealm'); ?></label>
	<input type="text" name="location" id="gymrealm_location" />
	
	<button type="submit"><?php _e("Submit!", 'gymrealm'); ?></button>
</form>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		var form = $('#gymrealm_add_client_form');
		var message = form.find('.message');
		
		form.submit(function() {
			form.find('button[type=submit]').prop('disabled', true);
			post_data = form.serializeArray();
			post_data.push({name: 'action', value: 'gymrealm_add_client'});
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
