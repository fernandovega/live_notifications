<?php if($vars['notifications']): ?>
	<?php foreach ($vars['notifications'] as $notify): ?>
		<?php if($notify->from_guid!=$vars['user']->guid): ?>
			<div class="notifications_content_item_all">
				<span class="notification_icon_all">
					<?php echo elgg_view_entity_icon($vars['user'], 'small', array(
														'use_hover' => false,
														'use_link' => true,
													)); 
					?>
				</span>
				<span class="notification_message_all">
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
	<div class="notifications_content_item_all">
		<p><?php echo elgg_echo('live_notifications:none'); ?></p>
	</div>
<?php endif; ?>