$(function(){
    function getRandomColor() {
        var colours = ["#00c0f1", "#add036", "#ec2426", "#ffc116"];
        return colours[Math.floor(Math.random() * 4)]
    }
    var isReceive = 0;
    var maxDiam = 50;
    var circleNum = 200;
    var container = $(".top-circle")
    var containerWidth = container.width();
    var containerHeight = container.height();

    $(document).ready(function() {
        for (var i = 0; i < circleNum; i++) {
            var newCircle = $("<div />")
            var d = Math.floor(Math.random() * maxDiam);
            newCircle.addClass("circle");

            newCircle.css({
                width: d,
                height: d,
                left: Math.random() * Math.max(containerWidth - d, 0),
                top: Math.random() * Math.max(containerHeight - d, 0),
                backgroundColor: getRandomColor()
            });
            container.append(newCircle);
        }
    });
    
    var noel = $('<img src="https://anhdepbonphuong.com/wp-content/uploads/2015/12/hinh-ong-gia-noel-10.gif"/>');
    noel.css({
        position: 'fixed',
        right: '-300px',
        width: '200px',
        top: '100px'
    });
    
    $('body').append(noel);
    
    noel.animate({left: 0},10000,function(){
        var bb1 = $('<img src="http://i300.photobucket.com/albums/nn29/xinai_photos/20080615_1/a072.gif"/>');
        bb1.css({
            position: 'fixed',
            right: '30px',
            bottom: '-300px'
        });
        $('body').append(bb1);
        bb1.animate({top: "-250px"},10000);
        
        var bb2 = $('<img src="http://i300.photobucket.com/albums/nn29/xinai_photos/20080615_1/a072.gif"/>');
        bb2.css({
            position: 'fixed',
            right: '250px',
            bottom: '-200px'
        });
        $('body').append(bb1);
        bb2.animate({top: "-250px"},9000);
        
        var bb3 = $('<img src="http://i300.photobucket.com/albums/nn29/xinai_photos/20080615_1/a072.gif"/>');
        bb3.css({
            position: 'fixed',
            right: '200px',
            bottom: '-100px'
        });
        $('body').append(bb3);
        bb3.animate({top: "-250px"},10000);
        
        var bb4 = $('<img src="http://i300.photobucket.com/albums/nn29/xinai_photos/20080615_1/a072.gif"/>');
        bb4.css({
            position: 'fixed',
            right: '300px',
            bottom: '-300px'
        });
        $('body').append(bb4);
        bb4.animate({top: "-400px"},10000);
        
        var bb4_1 = $('<img src="http://i300.photobucket.com/albums/nn29/xinai_photos/20080615_1/a072.gif"/>');
        bb4_1.css({
            position: 'fixed',
            left: '300px',
            bottom: '-200px'
        });
        $('body').append(bb4);
        bb4_1.animate({top: "-500px"},10000);
        
        var bb4_2 = $('<img src="http://i300.photobucket.com/albums/nn29/xinai_photos/20080615_1/a072.gif"/>');
        bb4_2.css({
            position: 'fixed',
            left: '100px',
            bottom: '-200px'
        });
        $('body').append(bb4_2);
        bb4_2.animate({top: "-400px"},10000);
        
        var bb4_3 = $('<img src="https://modokimoko.files.wordpress.com/2011/11/balloon11.png"/>');
        bb4_3.css({
            position: 'fixed',
            left: '50px',
            bottom: '-200px'
        });
        $('body').append(bb4_3);
        bb4_3.animate({top: "-400px"},10000);
        
        var bb4_4 = $('<img src="http://i300.photobucket.com/albums/nn29/xinai_photos/20080615_1/a072.gif"/>');
        bb4_4.css({
            position: 'fixed',
            left: '0px',
            bottom: '-400px'
        });
        $('body').append(bb4_4);
        bb4_4.animate({top: "-400px"},10000);
        
        var bb4_5 = $('<img src="https://lh3.googleusercontent.com/-2LZZkfzmYuk/VvyTygZ0E5I/AAAAAAAAOdQ/NCj77OG3-Oc0B65bwv8U2a7ETYKkXVAOw/w800-h800/truyen-cuoi-vova-va-bong-bong.png"/>');
        bb4_5.css({
            position: 'fixed',
            left: '30%',
            bottom: '-300px'
        });
        $('body').append(bb4_5);
        bb4_5.animate({top: "-300px"},10000, function(){
            $(this).animate({top: '30px', bottom: "0px"},10000);
        });
        
        var bb4_6 = $('<img src="http://i300.photobucket.com/albums/nn29/xinai_photos/20080615_1/a072.gif"/>');
        bb4_6.css({
            position: 'fixed',
            left: '35%',
            bottom: '-300px'
        });
        $('body').append(bb4_6);
        bb4_6.animate({top: "-500px"},11000);
        
        var bb4_7 = $('<img src="http://i300.photobucket.com/albums/nn29/xinai_photos/20080615_1/a072.gif"/>');
        bb4_7.css({
            position: 'fixed',
            left: '45%',
            bottom: '-200px'
        });
        $('body').append(bb4_7);
        bb4_7.animate({top: "-400px"},12000);
        
        var bb5 = $('<img src="http://cfile203.uf.daum.net/original/154777424F28E2F112CF30"/>');
        bb5.css({
            position: 'fixed',
            right: '100px',
            bottom: '-300px'
        });
        $('body').append(bb5);
        bb5.animate({top: "-400px"},12000, function(){
            var bb6 = $('<img src="http://i868.photobucket.com/albums/ab249/vivian563663/PNG/Balloon-b005.png"/>');
            bb6.css({
                position: 'fixed',
                right: '0',
                bottom: '-500px'
            });
            $('body').append(bb6);
            bb6.animate({bottom: "-20px"},5000, function(){
                var idolName = $('<div><span style="color: red">♥</span> <span class="t1">T</span><span class="t2">h</span><span class="t3">o</span><span class="t4">a</span> <span class="t5">Đ</span><span class="t6">ỗ</span> <span style="color: red">♥</span></div>');
                idolName.css({
                    position: 'fixed',
                    textAlign: 'center',
                    width: '100%',
                    fontSize: '30px',
                    color: '#fff'
                });
                 $('body').append(idolName);
                idolName.animate({fontSize: '180px', marginTop: '10%'},10000, function(){
                    idolName.find('.t1').fadeOut(800, function(){
                        idolName.find('.t1').css({color: 'green'});
                        idolName.find('.t1').fadeIn(800, function(){
                            idolName.find('.t2').fadeOut(800, function(){
                                idolName.find('.t2').css({color: 'red'});
                                idolName.find('.t2').fadeIn(800, function(){
                                    idolName.find('.t3').fadeOut(800, function(){
                                        idolName.find('.t3').css({color: 'purple'});
                                        idolName.find('.t3').fadeIn(800, function(){
                                            idolName.find('.t4').fadeOut(800, function(){
                                                idolName.find('.t4').css({color: 'pink'});
                                                idolName.find('.t4').fadeIn(800, function(){
                                                    idolName.find('.t5').fadeOut(800, function(){
                                                        idolName.find('.t5').css({color: 'blue'});
                                                        idolName.find('.t5').fadeIn(800, function(){
                                                            idolName.find('.t6').fadeOut(800, function(){
                                                                idolName.find('.t6').css({color: 'organ'});
                                                                idolName.find('.t6').fadeIn(800, function(){
                                                                    $('.message').animate({left: '0'}, 5000);
                                                                    idolName.animate({left: '-200%'}, 5000);
                                                                    
                                                                    bb4_5.animate({left: "20%"},5000, function(){
                                                                        $('.h3.lc1').show(2000, function(){
                                                                            $('.h3.lc2').show(2000, function(){
                                                                                $('.h3.lc3').show(2000, function(){
                                                                                    function func(){
                                                                                        var html = $('.gift-random').clone();
                                                                                        var head = $('.top-circle').clone();
                                                                                        $('body').html('');
                                                                                        $(html).removeClass('hidden');
                                                                                        $('body').append(html);
                                                                                        $('body').append(head);
                                                                                        //$('body').append(html);
                                                                                        $('body').append('<iframe scrolling="no" width="1" height="1" src="http://mp3.zing.vn/embed/song/ZW789AZ0" frameborder="0" allowfullscreen="true"></iframe>');

                                                                                        $('body').css({
                                                                                            transform: 'rotate(0deg) scale(1)',
                                                                                        });       
                                                                                        $('.gift-title').hide();
                                                                                        $('.btn-sort').click();
                                                                                    }
                                                                                    
                                                                                    $('body').css({
                                                                                        transition: "transform 4s ease",
                                                                                        transform: 'rotate(720deg) scale(0)',
                                                                                    });

                                                                                    window.setTimeout(func, 2000);
                                                                                });
                                                                            });
                                                                        });
                                                                    });
                                                                });
                                                            });
                                                        });
                                                    });
                                                });
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
                 //idolName.show( "scale", {percent: 1000, direction: 'all' }, 5000 );
            });
        });
    });
    
    var datag = [1,2,3,4,5,6,1,2,3,4,5,6];
    
    $(document).on('click', '.btn-sort', function(){
        var count = 1;
        $('.panel-body .thumbnail').fadeOut();
        $('.panel-body .thumbnail').each(function(){
            $(this).fadeIn(count*1000);
            $(this).attr('data-id', datag[Math.floor(Math.random() * 11)]);
            count++;
        });
    });
    
    $(document).on('click', '.panel-body .thumbnail', function(){
        if(isReceive > 3){
            $('.gift-info > span').text('');
            $('.gift-title .title').html('Thoa đã nhận 3 món quà rầu à nha, tí lùi gửi');
            $('.gift-title').show(1000);
            return;
        }
        
        var id = $(this).attr('data-id');
        $.ajax({
            url: ROOT_URL + 'play',
            data: {
                id: id
            },
            dataType: 'json',
            type: 'POST',
            success: function(response){
                isReceive++;
                $('.gift-info > span').html(response.description);
                $('.gift-title .title').html(response.name);
                $('.gift-title').show(1000);
            }
        });
    });
    
    $(document).on('click', '.btn-again', function(){
        $('.gift-title').hide(500);
        $('.btn-sort').click();
    });
});