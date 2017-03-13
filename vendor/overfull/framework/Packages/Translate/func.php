<?php
function lg($name, $parameters = []){
	if(!isset(\Bag::package()->translator)){
		\Bag::package()->translator = new \Overfull\Packages\Translate\Translator();
	}

	return \Bag::package()->translator->get($name, $parameters);
}