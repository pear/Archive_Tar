--TEST--
tests basic creation of tarballs
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . '/setup.php.inc';

$tar = new Archive_Tar(dirname(__FILE__) . '/no_compression.tar');
$tar->add(array(__FILE__));
$content = $tar->listContent();
$discovered_self = false;
foreach ($content as $item) {
  if ($item['filename'] === __FILE__) {
    $discovered_self = true;
    break;
  }
}
$phpunit->assertTrue($discovered_self, 'found the file in the uncompressed archive');
unlink(dirname(__FILE__) . '/no_compression.tar');

$tar_gz = new Archive_Tar(dirname(__FILE__) . '/gzip.tar.gz', 'gz');
$tar_gz->add(array(__FILE__));
$content = $tar_gz->listContent();
$discovered_self = false;
foreach ($content as $item) {
  if ($item['filename'] === __FILE__) {
    $discovered_self = true;
    break;
  }
}
$phpunit->assertTrue($discovered_self, 'found the file in the gzipped archive');
unlink(dirname(__FILE__) . '/gzip.tar.gz');

echo 'tests done';
?>
--CLEAN--
--EXPECT--
tests done
