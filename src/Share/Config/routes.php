<?php
return [
	'pages' => array(
		['(<:empty>|index.html)', 'any', 'controller=HomeController;method=index'],
		['chanel/<:integer>/live.html', 'any', 'controller=ChanelsController;method=live;id={1}']
	)
];