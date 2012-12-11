<div class="notifications_content">
<?php if($vars['notifications']): ?>
	<?php foreach ($vars['notifications'] as $notify): ?>
		<?php if($notify->from_guid!=$vars['user']->guid): ?>
			<div class="notifications_content_item">
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
				<?php if(!this_notification_is_read($new->guid, $vars['user']->guid)): ?>
					<?php read_notification($notify->guid, $vars['user']->guid); ?>
				<?php endif; ?>
			</div>
		<?php endif ?>
	<?php endforeach ?>
<?php else: ?>
	<div class="notifications_content_item">
		<p><?php echo elgg_echo('live_notifications:none'); ?></p>
	</div>
<?php endif; ?>
</div>