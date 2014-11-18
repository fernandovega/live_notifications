
//**<script type="text/javascript">**//
$(document).ready(function () {
    
    $('#live_notifications_loader').show();	    

    $("#live_notifications_link").click(function(){ 
        var num = parseInt($("#count_unread_notifications").html());
        if(num>0){
            elgg.action('live_notifications/read_all', function(response) {

            });
            $('.elgg-icon-live_notifications').removeClass("elgg-icon-live_notifications-selected");            
        }

        $("#count_unread_notifications").html(0);
        $("#count_unread_notifications").hide();         
    });

    if(elgg.is_logged_in()){
        $("#live_notifications_result").load("<?php echo elgg_get_site_url(); ?>live_notifications/ajax",function(){
            $('#live_notifications_loader').hide(); // remove the loading gif
        }); 
       
       setInterval(function() {
            
            elgg.action('live_notifications/refresh_count', function(response) {

                var num = parseInt($("#count_unread_notifications").html());
                var new_count = parseInt(response.output);
                //alert(new_count);
                if(new_count>num){
                    $("#count_unread_notifications").show();
                    $("#count_unread_notifications").html(new_count);
                    $('#live_notifications_loader').show(); 
                    $("#live_notifications_result").load("<?php echo elgg_get_site_url(); ?>live_notifications/ajax",function(){
                        $('#live_notifications_loader').hide(); // remove the loading gif
                        elgg.system_message('<?php echo elgg_echo('live_notifications:new_notification'); ?>');
                    });     
                }
                else if(new_count==0){
                    $("#count_unread_notifications").hide();                
                }
            });

        }, 10000);
        
        //check new messages
        setInterval(function() {
            
            elgg.action('live_notifications/refresh_count_messages', function(data) {

                var icon = $(".elgg-menu-item-messages");
                var text = '<?php echo elgg_view_icon("mail") ?>';

                // get unread messages
                
                var num_messages = parseInt(data.output);
    
                var num = parseInt($(".elgg-menu-item-messages a span.messages-new").html());
                if(num_messages>num || num_messages > 0){
                    text = text + "<span class=\"messages-new\">"+num_messages+"</span>";
                    $(".elgg-menu-item-messages a").html(text);
                    //$(".messages-new").show();
                }
                else if(num_messages==0){
                    $(".elgg-menu-item-messages a span.messages-new").hide();               
                }
            });

        }, 15000);

    }
   	

});

