<?php
if(file_exists("/home/passimmopro/www/apici/vendor/autoload.php"))
require_once  "/home/passimmopro/www/apici/vendor/autoload.php";

//require_once "./src/Control.php";

use Api\Control;

/*Header("Content-type:application/json");*/

Control::Uri(); 