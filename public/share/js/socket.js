var socket = io('http://localhost:8080');
socket.on('connected', function(msg){
	socket.emit('sign', me);

	socket.on('online', function(count){
		$('.info-view .online b').text(count);
	});

	socket.on('message', function(data){
		$('.media-list').append('<li class="media">'
            + '<div class="media-left">'
            + '<a href="#">'
            + '<img class="media-object" src="'+data.from.avatar+'" alt="..." style="height: 30px; width: 30px;">'
            + '</a>'
            + '</div>'
            + '<div class="media-body">'
            + data.msg
            + '</div>'
            + '</li>');
	});

	socket.on('typing', function(data){
		if(data.from.id != me.id){
			$('.typing').text(data.from.username + ' is typing...');
		}
	});

	$('#chat form').submit(function(e){
    	e.preventDefault();
    	socket.emit('message', {msg: $(this).find('input').val(), to: {room: me.room}, from: me});
  		$(this).find('input').val('');
  	});

  	// $('#chat form input').keyup(function(e){
   //  	e.preventDefault();
   //  	socket.emit('typing', {to: {room: me.room}, from: me});
  	// });
});