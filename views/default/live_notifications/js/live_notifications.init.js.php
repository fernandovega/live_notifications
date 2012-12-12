
//**<script type="text/javascript">**//
<?php 

$user_name = elgg_get_logged_in_user_guid();
$comet_url = $vars['url']."live_notifications/pull";
 ?>
NovComet = {
    sleepTime: 1000,
    _subscribed: {},
    _timeout: undefined,
    _baseurl: "<?php echo $comet_url ?>",
    _args: '',
    _urlParam: 'subscribed',
    
    subscribe: function(id, callback) {
        NovComet._subscribed[id] = {
            cbk: callback,
            timestamp: NovComet._getCurrentTimestamp()
        };
        return NovComet;
    },

    _refresh: function() {
        NovComet._timeout = setTimeout(function() {
            NovComet.run()
        }, NovComet.sleepTime);
    },

    init: function(baseurl) {
        if (baseurl!=undefined) {
            NovComet._baseurl = baseurl;
        }
    },

    _getCurrentTimestamp: function() {
        return Math.round(new Date().getTime() / 1000);
    }, 
    
    run: function() {
        var cometCheckUrl = NovComet._baseurl + '?' + NovComet._args;
        for (var id in NovComet._subscribed) {
            var currentTimestamp = NovComet._subscribed[id]['timestamp'];
            
            cometCheckUrl +=  NovComet._urlParam+ '[' + id + ']=' + 
               currentTimestamp;
        }
        cometCheckUrl += '&' + NovComet._getCurrentTimestamp();
        $.getJSON(cometCheckUrl, function(data){
            switch(data.s) {
                case 0: // sin cambios
                    NovComet._refresh();
                    break;
                case 1: // trigger
                    for (var id in data['k']) {
                        NovComet._subscribed[id]['timestamp'] = data['k'][id];
                        NovComet._subscribed[id].cbk(data.k);
                    }
                    NovComet._refresh();
                    break;
            }
        });

    },
    
    publish: function(id) {
        var cometPublishUrl = NovComet._baseurl + '?' + NovComet._args;
        cometPublishUrl += '&publish=' + id;
        $.getJSON(cometPublishUrl);
    }
};

NovComet.subscribe("<?php echo $user_name ?>", function(data){
    var num = parseInt($("#count_unread_notifications").html());
    $("#count_unread_notifications").html(num+1);
    $("#count_unread_notifications").show();
    $('#live_notifications_loader').show(); 
    $("#live_notifications_result").load("<?php echo $vars['url']; ?>live_notifications/ajax",function(){
        $('#live_notifications_loader').hide(); // remove the loading gif
    }); 
});

$(document).ready(function () {
    //Init comet
    NovComet.run();

    $("#live_notifications").hide();                           
    
    $('#live_notifications_loader').show();	
    $("#live_notifications_result").load("<?php echo $vars['url']; ?>live_notifications/ajax",function(){
        $('#live_notifications_loader').hide(); // remove the loading gif
    }); 

    $("#live_notifications_link").click(function(){ 
        $("#live_notifications").toggle($('#live_notifications').css('display') == 'none');
        $("#count_unread_notifications").html(0);
        $("#count_unread_notifications").hide();            

        $('.elgg-icon-live_notifications').addClass("elgg-icon-live_notifications-selected");

        return false;   
    });
    
    $(document).click(function(event) { 
        if($(event.target).parents().index($('#live_notifications')) == -1) {
            if($('#live_notifications').is(":visible")) {
                $('#live_notifications').hide();
                $('.elgg-icon-live_notifications').removeClass("elgg-icon-live_notifications-selected");                
            }
        }        
    });
	

});

