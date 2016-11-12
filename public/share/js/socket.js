var socket = io('http://192.168.0.111:8080');
socket.on('connected', function(msg){
	socket.emit('sign', me);

	socket.on('online', function(count){
		$('.info-view .online b').text(count);
	});

	$('#chat form').submit(function(e){
    	e.preventDefault();
    	socket.emit('message', {msg: $(this).find('input').val(), to: {room: me.room}, from: me});
  		$(this).find('input').val('');
  	});
});