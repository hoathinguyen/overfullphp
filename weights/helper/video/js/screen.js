$(document).ready(function(){
	function screenChange(){
		if ($.fullscreen.isFullScreen()) {
			$('#media-area').attr('data-fullscreen', 'true');
			$('.control-panel .full-screen-btn').html('<i class="glyphicon glyphicon-resize-small"></i>');
		} else {
			$('#media-area').attr('data-fullscreen', 'false');
			$('.control-panel .full-screen-btn').html('<i class="glyphicon glyphicon-resize-full"></i>');
		}
	}

	//  Full screen event
	$(document).on('click', '.control-panel .full-screen-btn', function(e){
		if($('#media-area').attr('data-fullscreen') == 'false'){
			$('#media-area').fullscreen();
		} else {
			$.fullscreen.exit();
		}
		screenChange();
		e.preventDefault();
	});

	// document's event
	$(document).bind('fscreenchange', function(e, state, elem) {
		screenChange();
	});

	$(document).on('click', '.control-panel .run-video-btn', function(){
		if($('#media-area').attr('data-run') == 'false'){
			$('#media-area video').get(0).play();
			$('#media-area').attr('data-run', 'true');
			$('.control-panel .run-video-btn').html('<i class="glyphicon glyphicon-pause"></i>');
		} else {
			$('#media-area video').get(0).pause();
			$('#media-area').attr('data-run', 'false');
			$('.control-panel .run-video-btn').html('<i class="glyphicon glyphicon-play"></i>');
		}
	});

    $('#media-area video').get(0).addEventListener('ended',function(){
		$('#media-area').attr('data-run', 'false');
		$('.control-panel .run-video-btn').html('<i class="glyphicon glyphicon-play"></i>');
  	}, false);

  	// Event for advertising
  	$(document).on('click','#media-area .advertising .ad-continue-btn', function(){
  		$('#media-area .advertising').removeClass('active');
  		$('#media-area video').get(0).play();
		$('#media-area').attr('data-run', 'true');
		$('.control-panel .run-video-btn').html('<i class="glyphicon glyphicon-pause"></i>');
  	});
});