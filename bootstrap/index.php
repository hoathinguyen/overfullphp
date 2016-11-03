<?php
/* ----------------------------------------------------
* The index of bootstrap file.
* This file contains basic require file in framework,
* Firstly, loaded autoload into source
* And then, create project with default app
* ----------------------------------------------------
*/

// ----------------------------------------------------
// require the autoload
// ----------------------------------------------------
require_once dirname(__DIR__) . '/vendor/autoload.php';

// ----------------------------------------------------
// Create applicateion object and run it
// ----------------------------------------------------
$application = new \Overfull\Application('dev/App', 'Dev\App');

$application->run();