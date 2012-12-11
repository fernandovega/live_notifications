<?php 
gatekeeper();

$num_messages = count_unread_notifications();

echo $num_messages;