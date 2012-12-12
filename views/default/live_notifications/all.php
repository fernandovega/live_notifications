<?php if($vars['notifications']): ?>
	<?php foreach ($vars['notifications'] as $notify): ?>
			<div class="notifications_content_item_all">
				<span class="notification_icon_all">
					<?php $from_entity = get_entity($notify->from_guid); ?>
					<?php echo elgg_view_entity_icon($from_entity, 'small', array(
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

				<?php if($notify->read!=1): ?>
					<?php 
					$notify->read = 1;
					$notify->save();
					 ?>
				<?php endif; ?>
			</div>
	<?php endforeach ?>
<?php else: ?>
	<div class="notifications_content_item_all">
		<p><?php echo elgg_echo('live_notifications:none'); ?></p>
	</div>
<?php endif; ?>