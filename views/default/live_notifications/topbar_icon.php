<?php 
$display = "";
$num_notifications = $vars['num_notifications'];
if ($num_notifications == 0) 
	$display = "style=\"display:none\"";
?>
<span class="elgg-icon elgg-icon-live_notifications"></span>
<span class="messages-new" id="count_unread_notifications" <?php echo $display ?>>
	<?php echo $num_notifications ?>
</span>