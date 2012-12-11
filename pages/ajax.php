<?php
gatekeeper();

$top = 25;

$user = elgg_get_logged_in_user_entity();

$objects = get_last_notifications($top);

$content = elgg_view('live_notifications/ajax', array('user'=>$user, 'notifications'=>$objects));

echo $content;
