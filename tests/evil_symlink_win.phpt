--TEST--
tests extraction of out-of-path symlink with a windows path
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . '/setup.php.inc';
$extract_target = dirname(__FILE__) . '/evil_symlink_win';
mkdir($extract_target, 0777, TRUE);
$tar = new Archive_Tar(dirname(__FILE__) . '/evil_symlink_win.tar');
$tar->extract($extract_target);
// On Windows dirname() will have used backslashes but the error messages do not.
$extract_target = str_replace('\\', '/', $extract_target);
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' => 'Out-of-path file extraction {' . $extract_target . '/evil.txt --> C:\windows\system.ini}')), 'after 1');
// N.B. file_exists() typically will not detect a broken symbolic link
$phpunit->assertFalse(is_link($extract_target . '/evil.txt'), 'Out-of-path symlink should not have succeeded');
echo 'tests done';
?>
--CLEAN--
<?php
@unlink(dirname(__FILE__) . '/evil_symlink_win/evil.txt');
rmdir(dirname(__FILE__) . '/evil_symlink_win');
?>
--EXPECT--
tests done
