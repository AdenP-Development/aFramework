<?php
/*

An example bootstrap.php
You can just rename it bootstrap.php and plonk it into the App folder, or make your own.

Add your requirements for your App on the specified line. I, for example, just use a common.php file to include everything my App will need.
*/

/* Composer */
require_once __DIR__."/../../vendor/autoload.php";

/* App specific requirements. */
require_once __DIR__."/common.php";

define('APP_PATH', __DIR__."/../");
