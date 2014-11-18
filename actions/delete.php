<?php 
gatekeeper();

$entity_guid = get_input('guid', NULL);

$response = array(
	'success' => FALSE,
	'guid' => $guid,
	'message' => elgg_echo('live_notifications:delete:error')
);

if($entity_guid!=NULL){
	$entity = get_entity($entity_guid);
	if($entity->delete()){
		$response = array(
			'success' => TRUE,
			'guid' => $guid,
			'message' => elgg_echo('live_notifications:delete:success')
		);
	}

}

exit(json_encode($response));