<?php 
gatekeeper();

$notifications = get_last_notifications(false);

foreach ($notifications as $item) {
	$item->delete();
}

system_message(elgg_echo('live_notifications:message:deleted_all'));