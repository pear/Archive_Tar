--TEST--
test files that happen to contain the endblock
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . '/setup.php.inc';
$tar = new Archive_Tar(dirname(__FILE__) . '/testblock.tar.gz');
$tar->add('testblock1');
$tar->add('testblock2');
$tar = new Archive_Tar(dirname(__FILE__) . '/testblock.tar.gz');
$tar->listContent();
$phpunit->assertNoErrors('after');
echo 'tests done';
?>
--CLEAN--
<?php
@unlink('testblock.tar.gz');
?>
--EXPECT--
tests done
