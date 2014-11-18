<?php 

$html = elgg_view('live_notifications/floatlist');

echo elgg_view_module('popup', '', $html, array(
		'id' => 'live_notifications',
		'class' => 'hidden clearfix',
	));
?>
 <?php if(elgg_is_active_plugin('cool_theme') || elgg_is_active_plugin('facebook_theme')): ?>
 <style type="text/css">
 .messages-new {
    left: 16px;
    min-width: 16px;
}

.elgg-page-topbar .elgg-search {
    margin: 4px 0 4px 351px;
    position: relative;
}
 </style>
<?php endif; ?>