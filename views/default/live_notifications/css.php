<?php
/**
 * Live Notifications
 *
 */
?>
/*<style type="text/css" media="screen">*/
/*Live Notifications*/

 .elgg-icon-live_notifications{
    background: url(<?php echo $vars['url'] ?>mod/live_notifications/graphics/icon16.png);
 }

.elgg-icon-live_notifications:hover{
    background: url(<?php echo $vars['url'] ?>mod/live_notifications/graphics/iconh16.png);
 }

.elgg-icon-live_notifications-selected{
    background: url(<?php echo $vars['url'] ?>mod/live_notifications/graphics/iconh16.png);
 }

<?php if (elgg_is_active_plugin('cool_theme')): ?>
 .messages-new {
    background-color: red;
    border-radius: 10px 10px 10px 10px;
    box-shadow: -2px 2px 4px rgba(0, 0, 0, 0.5);
    color: white;
    font-size: 10px;
    font-weight: bold;
    height: 16px;
    left: 16px;
    min-width: 16px;
    position: absolute;
    text-align: center;
    top: 0;
}
<?php endif; ?>

#live_notifications{
    float: left; 
    position: absolute; 
    background: #FFF; 
    width: 350px; 
    height: 477px;
    min-height: 100px; 
    margin: 0px 0 0 0px; 
    color: #333;
    border: #C0C0C0 1px solid;
    border-top: 0px;
    z-index:9999;
}

#live_notifications_result{
float:left;
width: 100%;
height: 450px; 
overflow-y: auto; 
overflow-x: hidden;
}

#live_notifications_see_more{  
width: 340px;
float:left;
background: #2F2F2F;
text-align: center;
font-weight: bold;
padding: 5px;
}

#live_notifications_see_more a{ 
color:#FFFFFF; 
font-weight: bold;
}

.notifications_content{

}

.notifications_content_item{
    margin: 5px 0px;
    float: left;
    width:340px;
    padding: 5px;
    border-bottom: 1px solid #C0C0C0;
}

.notifications_content_item_all{
    margin: 5px 0px;
    float: left;
    width:100%;
    padding: 5px;
    border-bottom: 1px solid #C0C0C0;
}

.notification_icon{
    width:40px;
    float: left;
}
.notification_message{
    width: 290px;
    float: right;
}

.notification_icon_all{
    width:40px;
    float: left;
}
.notification_message_all{
    width: 90%;
    float: left;
    margin-left: 15px;
}

.notification_timeago{
    float: right;
    width:100%;
    text-align: right;
    font-size:9px;
    color:#A2A2A2;
    margin: 5px 20px;
}

