--TEST--
tests if files > 8G are supported
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . '/setup.php.inc';
$tar = new Archive_Tar(dirname(__FILE__) . '/big.tar.bz2');
$content = $tar->listContent();
$found_big_file = false;
foreach ($content as $item) {
  if ($item['filename'] === 'big_archive/8.5G_file') {
    $found_big_file = true;
    $phpunit->assertEquals(9126805504, $item['size'], 'size of big file correct');
  }
}
$phpunit->assertTrue($found_big_file, 'found the big file in the archive');
echo 'tests done';
?>
--CLEAN--
--EXPECT--
tests done
