<?php
/* ----------------------------------------------------
* constant.php file.
* This file contains basic defined,
* Firstly, default DS and ROOT before call application
* ----------------------------------------------------
*/
define('ROOT', dirname(dirname(dirname(dirname(__DIR__)))));

define('DS', '/'); //DIRECTORY_SEPARATOR

define("BASE_URL", isset($_SERVER["HTTP_HOST"]) ? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http').':'.'//'.$_SERVER["HTTP_HOST"] : null);

define("WEB_ROOT", BASE_URL);