--TEST--
tests extraction of out-of-path symlink
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . '/setup.php.inc';
$extract_target = dirname(__FILE__) . '/one/two/three/four';
mkdir($extract_target, 0777, TRUE);
file_put_contents(dirname(__FILE__) . '/one/two/secret.txt', 'password1');
$tar = new Archive_Tar(dirname(__FILE__) . '/out_of_path_relative.tar');
$tar->extract($extract_target);
// On Windows dirname() will have used backslashes but the error messages do not.
$extract_target = str_replace('\\', '/', $extract_target);
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' => 'Out-of-path file extraction {' . $extract_target . '/five/six/evil.txt --> ../../../../secret.txt}')), 'after 1');
$phpunit->assertFileNotExists($extract_target . '/five/six/evil.txt', 'Out-of-path symlink should not have succeeded');
echo 'tests done';
?>
--CLEAN--
<?php
unlink(dirname(__FILE__) . '/one/two/secret.txt');
@unlink(dirname(__FILE__) . '/one/two/three/four/five/six/evil.txt');
rmdir(dirname(__FILE__) . '/one/two/three/four/five/six');
rmdir(dirname(__FILE__) . '/one/two/three/four/five');
rmdir(dirname(__FILE__) . '/one/two/three/four');
rmdir(dirname(__FILE__) . '/one/two/three');
rmdir(dirname(__FILE__) . '/one/two');
rmdir(dirname(__FILE__) . '/one');
?>
--EXPECT--
tests done
