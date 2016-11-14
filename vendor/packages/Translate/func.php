<?php
function lg($domain, $text, $parameters = []){
	if(!isset(\Bag::package()->translator)){
		\Bag::package()->translator = new \Packages\Translate\Translator();
	}

	return \Bag::package()->translator->get($domain, $text, $parameters);
}