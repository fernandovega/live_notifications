<?php
gatekeeper();

$top = 100;

elgg_set_context('settings');

$user = elgg_get_logged_in_user_entity();

$objects = get_last_notifications($top);

$content = elgg_view('live_notifications/all', array('user'=>$user, 'notifications'=>$objects));

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => elgg_echo('live_notifications:all'),
	'filter' => '',
));

echo elgg_view_page(elgg_echo('live_notifications:all'), $body);
