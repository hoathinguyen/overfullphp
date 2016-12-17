$(document).ready(function(){
    function setHeight(){
        var cw = $('.chanel-box').width();

        if(cw > 150){
            cw = 150;
        }

        $('.chanel-box').css({'height':cw+'px'});
    }

    $( window ).resize(function() {
        setHeight();
    });

    setHeight();
});