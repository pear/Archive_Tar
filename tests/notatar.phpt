--TEST--
test processing files that are not tar files
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . '/setup.php.inc';

$tar = new Archive_Tar(__DIR__ . '/notatar/text-0.txt');
$tar->listContent();
$errors = $phpunit->_errors;
$phpunit->_errors = array();
$phpunit->assertEquals(1, count($errors), "1 error expected");
$message = $errors[0]["params"]["obj"]->getMessage();
$phpunit->assertEquals(1, preg_match('/^Invalid checksum for file /', $message), "Expected error message: $message");
echo 'tests done';
?>
--CLEAN--
<?php
?>
--EXPECT--
tests done
