--TEST--
test permissions of created dirs
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . '/setup.php.inc';
umask('000'); // force default to 777 to confirm we create tighter
$tar = new Archive_Tar(dirname(__FILE__) . '/dir_permissions.tar');
$tar->extract('', true);
$phpunit->assertNoErrors('after');
echo substr(sprintf('%o', fileperms('dir_permissions')), -4), PHP_EOL;
echo 'tests done';
?>
--CLEAN--
<?php
unlink('dir_permissions/a.txt');
unlink('dir_permissions/b.txt');
rmdir('dir_permissions');
?>
--EXPECT--
0775
tests done
