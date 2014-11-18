<?php 
gatekeeper();

$notifications = get_unread_notifications(25);

foreach ($notifications as $notify) {
	# code...
	if($notify->read!=1){
		$notify->read = 1;
		$notify->save();	
	}
}
				
					 