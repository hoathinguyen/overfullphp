<?php
config()->addFiles('*', [
    'domain' => [
        array(ROOT.'/config/domain.php', true, true)
    ],
    'databases' => [
        array(ROOT.'/config/databases.php', true, true),
        //array(ROOT.'/:root/Config/databases.php', false, true)
    ],
    'alias' => [
        array(ROOT.'/config/alias.php', true, true),
        //array(ROOT.'/:root/Config/alias.php', false, true)
    ],
    'packages' => [
        array(ROOT.'/config/packages.php', true, true),
        //array(ROOT.'/:root/Config/packages.php', false, true)
    ],
    'core' => [
        array(ROOT.'/config/core.php', true, true),
        //array(ROOT.'/:root/Config/core.php', false, true)
    ],

    'system' => [
        array(ROOT.'/vendor/framework/Overfull/Configure/system.php', true, true)
    ],

    // 'routes' => [
    //     array(ROOT.'/:root/Config/routes.php', false, true)
    // ],
    // Read file
    array(
        [ROOT.'/:config/main.php', true, false]
    )
]);