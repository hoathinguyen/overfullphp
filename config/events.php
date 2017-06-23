<?php
\Bag::event()
/**
 * Handle logic when event start
 * 
 */
->on(\Overfull\Events\EventKeys::START, function($e){
    header('Access-Control-Allow-Origin: *');
})
/**
 * Handle logic when event end
 * 
 */
->on(\Overfull\Events\EventKeys::END, function($e){
	
});