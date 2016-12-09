$(document).ready(function(){
    /**
    * Event click show/hide chat box
     */
    $(document).on('click', '.btn-turn-chat', function(){
        if($('#chat').hasClass('active')){
            $('#chat').removeClass('active');
            $(this).find('.title').html('Show chatbox');
            $.cookie('chat-tab', false);
        }else{
            $('#chat').addClass('active');
            $(this).find('.title').html('Hide chatbox');
            $.cookie('chat-tab', true);
        }
    });

    $(document).on('click', '#chat', function(){
        $(this).find('.chat-count').text(0);
    });

    $(document).on('click', '.rm-chanel-info', function(){
        $('.chanel-label-info').remove();
    });
    
    $('.nav-tabs li').click(function(){
        $('.nav-tabs li').removeClass('active');
        $(this).addClass('active');
        $('.tab-contents > *').addClass('hide');
        $('.tab-contents > '+ $(this).attr('bind')).removeClass('hide');
        $.cookie('view-tab', $(this).attr('bind'));
    });

    $('.nav-tabs li').first().addClass('active');
    $('.tab-contents > div').first().removeClass('hide');

    var tab = $.cookie('view-tab');
    if(tab && $('.nav-tabs li[bind="'+tab+'"]').length != 0){
        $('.nav-tabs li').removeClass('active');
        $('.nav-tabs li[bind="'+tab+'"]').addClass('active');
        $('.tab-contents > *').addClass('hide');
        $('.tab-contents > '+ tab).removeClass('hide');
    }

    // Cookie for chat
    var chatCk = $.cookie('chat-tab');
    if(chatCk == undefined || chatCk == 'true'){
        $('#chat').addClass('active');
    }
});