<?php
/**
 * Elgg live_notifications plugin
 * 
 */

elgg_register_event_handler('init', 'system', 'live_notifications');

function live_notifications() {

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('live_notifications', 'live_notifications_page_handler');

	elgg_register_event_handler('pagesetup', 'system', 'live_notifications_notifier');

	elgg_register_event_handler('pagesetup', 'system', 'live_notifications_plugin_pagesetup');

	// Extend system CSS with our own styles
	elgg_extend_view('css/elgg', 'live_notifications/css');

    elgg_extend_view('js/elgg', 'live_notifications/js/live_notifications.init.js');

    elgg_register_entity_type('object', 'notification');

    //disable message notifications site, 
    //Comment this line if you want to receive also default site notifications
    unregister_notification_handler("site");

    //Extend add_to_river function for catch a event and create notification
    elgg_register_plugin_hook_handler('creating', 'river', 'catch_add_to_river_event');
    elgg_register_plugin_hook_handler("action", "likes/add", "likes_notification_action");
    //Actions
    $actions_base = elgg_get_plugins_path() . 'live_notifications/actions';
    elgg_register_action('live_notifications/refresh_count', "$actions_base/refresh_count.php");
}

function live_notifications_page_handler($page) {

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$live_notifications_dir = elgg_get_plugins_path() . 'live_notifications/pages';

	$page_type = $page[0];
	switch ($page_type) {
		case 'all':			
			include "$live_notifications_dir/all.php";
			break;
		case 'ajax':			
			include "$live_notifications_dir/ajax.php";
			break;
		case 'pull':			
			include "$live_notifications_dir/pull.php";
			break;
		default:
			return false;
	}
	return true;
}

/**
 * Live Notifications settings sidebar menu
 *
 */
function live_notifications_plugin_pagesetup() {
	if (elgg_in_context("settings") && elgg_get_logged_in_user_guid()) {

		$user = elgg_get_page_owner_entity();
		if (!$user) {
			$user = elgg_get_logged_in_user_entity();
		}

		$params = array(
			'name' => '2_a_user_live_notification',
			'text' => elgg_echo('live_notifications:all'),
			'href' => "live_notifications/all",
			'section' => "notifications",
		);
		elgg_register_menu_item('page', $params);		
	}
}

//Set notifier icon with auto update
function live_notifications_notifier() {
	global $CONFIG;
	if (elgg_is_logged_in()) {
		$class = "elgg-icon elgg-icon-live_notifications";
		$text = "<span class='$class'></span>";
		$tooltip = elgg_echo("live_notifications");
		
		//get unread messages
		$num_messages = count_unread_notifications(25);

		$display = "";
		if ($num_messages == 0) 
			$display = "style=\"display:none\"";

		$text .= "<span class=\"messages-new\" id=\"count_unread_notifications\" $display>$num_messages</span>";
		$tooltip .= " (" . elgg_echo("messages:unreadcount", array($num_messages)) . ")";
		

		$text .= '<div id="live_notifications">				  	
				    <div id="live_notifications_loader"></div>
				    <div id="live_notifications_result"></div>
				    <div id="live_notifications_see_more">
				    	<a href="'.$CONFIG->wwwroot.'pg/live_notifications/all">'.elgg_echo('live_notifications:see_all').'</a>
				    </div>
				 </div>';

		elgg_register_menu_item('topbar', array(
			'name' => 'notification',
			'href' => 'live_notifications/all',
			'text' => $text,
			'priority' => 600,
			'title' => $tooltip,
			'id' => 'live_notifications_link'
		));
	}
}

//Save Notification, call this function to add new notification from a action or event plugin
function add_new_notification($to_guid, $from_guid, $type, $entity_guid, $description) {
    
    $notify = new ElggObject();
    $notify->subtype = "notification";
    $notify->access_id = ACCESS_LOGGED_IN;
    $notify->read = 0;
    $notify->action_type = $entity_type;
    $notify->entity_guid = $entity_guid;
    //User or group notification
    $notify->to_guid = $to_guid;
    //who took the action: user
    $notify->from_guid = $from_guid;
    //Message
    $notify->description = $description;

    if($notify->save()){
    	return $notify->guid; 
    }
    else{
    	return NULL;
    }

}

function catch_add_to_river_event($hook, $type, $returnvalue, $params){
	$type = $returnvalue["subtype"]; //Subtype object: blog, thewire, bookmark,etc..
	$action_type = $returnvalue["action_type"]; //Type of action: create, update, comment
	$entity_guid = $returnvalue["object_guid"];	//Guid of object entity
	$entity = get_entity($entity_guid);
	$to_guid = $entity->owner_guid;//Entity creator to notify
	$to_entity = get_entity($to_guid);
	$from_entity = elgg_get_logged_in_user_entity();

	//In case of $action_type is "comment" get the annotation 
	$annotation = elgg_get_annotation_from_id($returnvalue["annotation_id"]);

	create_message_for_entity($to_entity, $from_entity, $type, $action_type, $entity,$annotation);

	return true;
}

function likes_notification_action($hook, $entity_type, $returnvalue, $params){
	if (!elgg_annotation_exists($entity_guid, 'likes')) {
		include('pages/NovComet.php');
		$comet = new NovComet();

		$entity_guid = get_input('guid');
		$entity = get_entity($entity_guid);
		
		$to_guid = $entity->owner_guid;	
		$from_entity = elgg_get_logged_in_user_entity();
		$from_guid = $from_entity->guid;

		if($to_guid!=$from_guid){
			$url_user = elgg_view('output/url', array(
						'href' => $from_entity->getURL(),
						'text' => $from_entity->name,
						'class' => 'elgg-river-subject',
					));		
			$description =  elgg_echo('live_notifications:like', array($url_user, $entity->subtype));
			if($entity->title!='')
				$description .= '<a href="'.$entity->getUrl().'" title="">'.$entity->title.'</a>';

			add_new_notification($to_guid, $from_guid, 'like', $entity_guid, $description);		
		}	
		$comet->publish($to_guid);
	}
	return true;
}


function create_message_for_entity($to_entity, $from_entity, $type, $action_type, $entity, $annotation=NULL){
	include('pages/NovComet.php');
	$comet = new NovComet();

	if($action_type=='comment'){
		analize_thread_comments($entity, $annotation, $from_entity, $comet);
		if($from_guid!=$entity->owner_guid){
			$url_user = elgg_view('output/url', array(
					'href' => $from_entity->getURL(),
					'text' => $from_entity->name,
					'class' => 'elgg-river-subject',
				));
			$description =  elgg_echo('live_notifications:comments:create', array($url_user, $to_entity->name));
			$description .= '<a href="'.$entity->getUrl().'" title="">'.$entity->title.'</a> <br/>';
			$description .= '<i>'.$annotation->value.'</i>';
			add_new_notification($to_entity->guid, $from_entity->guid, 'comment', $entity->guid, $description);
			$comet->publish($to_entity->guid);	
		}
	}	

	$container = get_entity($entity->container_guid);

	if(elgg_instanceof($container, 'group')){

		if($action_type=='create'){
			$url_user = elgg_view('output/url', array(
					'href' => $from_entity->getURL(),
					'text' => $from_entity->name,
					'class' => 'elgg-river-subject',
				)); 
			$url_group = elgg_view('output/url', array(
					'href' => $container->getURL(),
					'text' => $container->name,
					'class' => 'elgg-river-subject',
				));
			$description =  elgg_echo('live_notifications:group:create:'.$type, array($url_user, $url_group));
			$description .= '<a href="'.$entity->getUrl().'" title="">'.$entity->title.'</a>';

			$members = $container->getMembers();
			foreach ($members as $member) {
				# Notify to all members
				if($from_entity->guid!=$member->guid){
					add_new_notification($member->guid, $from_entity->guid, $type, $entity->guid, $description);
					$comet->publish($member->guid);
				}
			}
		}
	}
}

function analize_thread_comments($entity, $annotation, $from_entity, $comet){
	$comments = elgg_get_annotations(array(
		'guid' => $entity->getGUID(),
		'annotation_name' => 'generic_comment',
		'limit' => 50,
		'order_by' => 'n_table.time_created desc'
	));
	
	$autors_comments = array();	

    if ($comments) {       
        foreach ($comments as $comment) {
        	$owner_guid = $comment->owner_guid;                
            if($owner_guid!=$from_entity->guid && $owner_guid!=$entity->owner_guid && !in_array($owner_guid, $autors_comments)){
            	$url_user = elgg_view('output/url', array(
					'href' => $from_entity->getURL(),
					'text' => $from_entity->name,
					'class' => 'elgg-river-subject',
				));            	
            	$description =  elgg_echo('live_notifications:comments:thread', array($url_user, $entity->name));
				$description .= '<a href="'.$entity->getUrl().'" title="">'.$entity->title.'</a> <br/>';
				$description .= '<i>'.$annotation->value.'</i>';

				add_new_notification($owner_guid, $from_entity->guid, 'comment', $entity->getGUID(), $description);				
            	$comet->publish($owner_guid);	
            	$autors_comments[] = $owner_guid;
            }            
        }
    }
}

function get_last_notifications($top=25){

	$user = elgg_get_logged_in_user_entity();
	if($user){
	    $params = array(
	        'types' => 'object',
	        'subtype' => 'notification',
	        'metadata_name' => 'to_guid',
	        'metadata_value' => $user->guid,
	        'limit' => $top,
	    );

	    $objects = elgg_get_entities_from_metadata($params);
    	return $objects;
	}

}


function count_unread_notifications($top=25){
	$user_guid = elgg_get_logged_in_user_guid();
	$result = 0;
	if($user_guid){
	    $params = array(
	        'types' => 'object',
	        'subtype' => 'notification',
	        'metadata_name_value_pairs' => array(array('name' => 'to_guid', 'value' => $user_guid, 'operand' => '='),
	        									 array('name' => 'read', 'value' => 0, 'operand' => '=')
	        									 ),
	        'metadata_name_value_pairs_operator' => 'AND',
	        'limit' => $top,
	        'count' => TRUE
	    );

	    $result = elgg_get_entities_from_metadata($params);    	
	}

	return $result;
}