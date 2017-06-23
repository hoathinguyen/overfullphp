<?php
// Load domain config
config()->runFile(ROOT.'/config/domain.php', true)
->loadFile('databases', ROOT.'/config/databases.php', true)
->loadFile('alias', ROOT.'/config/alias.php', true)
->loadFile('core', ROOT.'/config/core.php', true)
->loadFile('mvc', ROOT.'/config/mvc.php', true)
->runFile(ROOT.'/config/events.php', true)
// Config for shop
->forApp('app', function($config){
    $config->runFile(ROOT.'/config/app/site/routes.php', true)
        ->loadFile('modules', ROOT.'/config/app/modules.php', true);
});