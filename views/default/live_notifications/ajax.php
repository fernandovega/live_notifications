<?php $notifications = $vars['notifications']; ?>
<?php if(count($notifications)>0): ?>
	<?php foreach ($notifications as $notify): ?>		
			<div class="notifications_content_item <?php if($notify->read!=1){ echo "new_notification";} ?>">
				<span class="notification_icon">
					<?php $from_entity = get_entity($notify->from_guid); ?>
					<?php echo elgg_view_entity_icon($from_entity, 'small', array(
														'use_hover' => false,
														'use_link' => true,
													));  
					?>
				</span>
				<span class="notification_message">
					<?php echo $notify->description ?>
					<br>
					<p class="notification_timeago">
						<?php echo elgg_view_friendly_time($notify->time_created) ?>
					</p>
				</span>				
			</div>
	<?php endforeach ?>
<?php else: ?>
	<div class="notifications_content_item">
		<p><?php echo elgg_echo('live_notifications:none'); ?></p>
	</div>
<?php endif; ?>