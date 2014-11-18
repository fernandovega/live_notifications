<script type="text/javascript">

$(document).ready(function(){
	$("a.delete-notification").live("click", function(){
		if(confirm("<?php echo elgg_echo('live_notifications:delete:confirm'); ?>")){
			var item = $(this).parent();
			elgg.action("live_notifications/delete",
				{
					data: { guid: $(this).attr('id') },
					success: function(r){
						if(r.success){
							elgg.system_message(r.message);
							item.fadeOut("slow", function(){ $(this).remove() });
							$('#live_notifications_loader').show();	
						    $("#live_notifications_result").load("<?php echo elgg_get_site_url(); ?>live_notifications/ajax",function(){
						        $('#live_notifications_loader').hide(); // remove the loading gif
						    }); 
						}else{
							elgg.register_error(r.message);
						}
					}
				}
			);
		}
	});

});

</script>

<?php if($vars['notifications']): ?>
	<?php foreach ($vars['notifications'] as $notify): ?>
			<div class="notifications_content_item_all">
				<a class="delete-notification" title="<?php echo elgg_echo('delete'); ?>" href="#" id="<?php echo $notify->guid ?>">
				<span class="elgg-icon elgg-icon-delete" style="float:right"></span>
				</a>
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