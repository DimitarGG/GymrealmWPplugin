<?php // ѣ
/**
 * Template for GymRealm_ClientServicesWidget.
 * 
 * If $services is NULL, then an $error_message is available.
 * 
 * @package GymRealm
 * @since 0.0.1
 */

?>
<?php if($services) { ?>
<?php foreach($services as $service) { ?>
<p><?php echo $service->ServiceName; ?></p>
<?php } ?>
<?php } else { ?>
<p class="danger"><?php echo $error_message; ?></p>
<?php } ?>
