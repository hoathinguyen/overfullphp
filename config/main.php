<?php
// Load domain config
config()->loadFile('domain', ROOT.'/config/domain.php', true)
->loadFile('databases', ROOT.'/config/databases.php', true)
->loadFile('alias', ROOT.'/config/alias.php', true)
->loadFile('core', ROOT.'/config/core.php', true)
->forApp('ofs', function($config){
    $config->loadFile('routes', ROOT.'/config/ofs/routes.php', true)
        ->loadFile('databases', ROOT.'/config/databases.php', true);
})
// Config for ofs
->forApp('shop', function($config){
    $config->loadFile('routes', ROOT.'/config/shop/site/routes.php', true)
        ->loadFile('packages', ROOT.'/config/shop/packages.php', true);
})
// Config for ofs
->forApp('admin-shop', function($config){
    $config->loadFile('routes', ROOT.'/config/shop/admin/routes.php', true)
        ->loadFile('packages', ROOT.'/config/shop/packages.php', true);
})
// Config for ofs
->forApp('attendance', function($config){
    $config->loadFile('databases', ROOT.'/config/attendance/databases.php', true)
        ->loadFile('routes', ROOT.'/config/attendance/routes.php', true)
        ->loadFile('packages', ROOT.'/config/attendance/packages.php', true);
});