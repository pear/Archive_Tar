--TEST--
sizes that do not fit in 11 octal digits are written in base-256
--SKIPIF--
<?php if (PHP_INT_SIZE < 8) die('skip 64-bit only'); ?>
--FILE--
<?php
$dirname = dirname(__FILE__);
require_once $dirname . '/setup.php.inc';

$file = $dirname . '/largesize.tar';
foreach (array(8589934591, 8589934592, 68719476735, 68719476736) as $size) {
    $tar = new Archive_Tar($file);
    $tar->_openWrite();
    $tar->_writeHeaderBlock('f', $size);
    $tar->_close();

    $header = file_get_contents($file, false, null, 0, 512);
    $field = substr($header, 124, 12);
    $tar->_readHeader($header, $v_header);
    echo $size, ' ', ord($field[0]) & 0x80 ? bin2hex($field) : rtrim($field, "\0"), ' ', $v_header['size'], "\n";
}
$phpunit->assertNoErrors('after writing headers');

echo 'test done'
?>
--CLEAN--
<?php
$dirname = dirname(__FILE__);
@unlink($dirname.'/largesize.tar');
?>
--EXPECT--
8589934591 77777777777 8589934591
8589934592 800000000000000200000000 8589934592
68719476735 800000000000000fffffffff 68719476735
68719476736 800000000000001000000000 68719476736
test done
