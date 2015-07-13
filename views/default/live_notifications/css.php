<?php
/**
 * Live Notifications
 *
 */
?>
/*<style type="text/css" media="screen">*/
/*Live Notifications*/

 .elgg-icon-live_notifications{
    background: url(<?php echo elgg_get_site_url() ?>mod/live_notifications/graphics/icon16.png) no-repeat;
 }

.elgg-icon-live_notifications:hover{
    background: url(<?php echo elgg_get_site_url() ?>mod/live_notifications/graphics/iconh16.png) no-repeat;
 }

.elgg-icon-live_notifications-selected{
    background: url(<?php echo elgg_get_site_url() ?>mod/live_notifications/graphics/iconh16.png) no-repeat;
 }

 #live_notifications_loader {
    background-image: url("/_graphics/ajax_loader.gif");
    background-position: center center;
    background-repeat: no-repeat;
    width: 98%;
    height: 48px;
    display: none;
}

#live_notifications{
    /*float: left; 
    position: absolute; */
    background: #FFF; 
    width: 350px; 
    min-height: 127px; 
    max-height: 477px;
    margin: 10px 0 0 170px;
    color: #333;
    border: #C0C0C0 1px solid;
    border-top: 0px;
    z-index:9999;    
}

#live_notifications_result{
float:left;
width: 100%;
min-height: 100px; 
max-height: 350px; 
overflow-y: auto; 
overflow-x: hidden;
}

#live_notifications_result i{
    color: #909090;
    font-size: 90%;
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

.new_notification{
    background: #F4F1C7;
}

.notifications_content_item_all{
    margin: 5px 0px;
    float: left;
    width:100%;
    border-bottom: 1px solid #C0C0C0;
}

.notification_icon{
    width:40px;
    float: left;
}
.notification_message{
    width: 275px;
    float: right;
    padding-right: 15px;
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


 .messages-new {
    background-color: #ff0000;
    border-radius: 50%;
    color: #fff;
    font-size: 11px;
    font-weight: bold;
    height: 19px;
    left: 26px;
    line-height: 18px;
    min-width: 19px;
    position: absolute;
    text-align: center;
    top: 2px;
}


