<?php
error_reporting(E_ALL);
// adjust include_path for PHP pre-5.6 behavior
set_include_path(get_include_path() . PATH_SEPARATOR . '/usr/local/php/' . PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION . '/share/pear');
require_once dirname(__FILE__) . '/phpt_test.php.inc';
$phpunit = new PEAR_PHPTest(true);
require_once dirname(dirname(__FILE__)) . '/Archive/Tar.php';
