<?php

/**
 * The autoload module setting for the project.
 *
 * When included this php script into your script, the undeclared classes used in your scripts will be automatically loaded from current folder according to 'classname.class.php' convention.
 *
 * This script requires features of PHP 5's autoload method. See PHP's document for more information about autoloading.
 *
 * @author yfwz100
 */

spl_autoload_register(function ($name) {
  $path = strtolower(str_replace('\\','/', $name));
  require_once dirname(__FILE__)."/$path.class.php";
});

