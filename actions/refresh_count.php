<?php 
gatekeeper();

$num_messages = count_unread_notifications(25);

echo $num_messages;