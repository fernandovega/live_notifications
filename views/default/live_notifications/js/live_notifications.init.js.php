
//**<script type="text/javascript">**//
$(document).ready(function () {
   
    $("#live_notifications").hide();                           
    
    $("#live_notifications_link").click(function(){ 
        $("#live_notifications").toggle($('#live_notifications').css('display') == 'none');
        $('#live_notifications_loader').html('cargando...');	
        $("#live_notifications_result").load("<?php echo $vars['url']; ?>live_notifications/ajax",function(){
            $('#live_notifications_loader').empty(); // remove the loading gif            
        });	

        $('.elgg-icon-live_notifications').addClass("elgg-icon-live_notifications-selected");

        return false;   
    });       
       
   //Interval update counter: 10 second(10000)
   setInterval(function() {
        elgg.action('live_notifications/refresh_count', function(response) {
            if(response.output>0){
        		$("#count_unread_notifications").html(response.output);
                $("#count_unread_notifications").show();
            }
            else{
                $("#count_unread_notifications").hide();            	
            }
        });
    }, 10000);

    
    $(document).click(function(event) { 
        if($(event.target).parents().index($('#live_notifications')) == -1) {
            if($('#live_notifications').is(":visible")) {
                $('#live_notifications').hide();
                $('.elgg-icon-live_notifications').removeClass("elgg-icon-live_notifications-selected");                
            }
        }        
    });
	

});

