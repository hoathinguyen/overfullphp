<?php
function lg($name, $parameters = []){
	if(!isset(\Bag::module()->translator)){
		\Bag::module()->translator = new \Overfull\Modules\Translate\Translator();
	}

	return \Bag::module()->translator->get($name, $parameters);
}