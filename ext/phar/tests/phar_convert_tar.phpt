--TEST--
Phar::convertToTar()
--SKIPIF--
<?php if (!extension_loaded("phar")) die("skip"); ?>
--INI--
phar.require_hash=0
phar.readonly=0
--FILE--
<?php

$fname = __DIR__ . '/' . basename(__FILE__, '.php') . '.phar';
$pname = 'phar://' . $fname;
$fname2 = __DIR__ . '/' . basename(__FILE__, '.php') . '.phar.tar';
$fname3 = __DIR__ . '/' . basename(__FILE__, '.php') . '.2.phar.tar';
$stub = '<?php echo "first stub\n"; __HALT_COMPILER(); ?>';
$file = $stub;

$files = array();
$files['a'] = 'a';
$files['b'] = 'b';
$files['c'] = 'c';

include 'files/phar_test.inc';

$phar = new Phar($fname);
var_dump($phar->isFileFormat(Phar::TAR));
var_dump($phar->getStub());

$phar = $phar->convertToExecutable(Phar::TAR);
var_dump($phar->isFileFormat(Phar::TAR));
var_dump($phar->getStub());

copy($fname2, $fname3);

$phar = new Phar($fname3);
var_dump($phar->isFileFormat(Phar::TAR));
var_dump($phar->getStub());

?>
===DONE===
--CLEAN--
<?php
unlink(__DIR__ . '/' . basename(__FILE__, '.clean.php') . '.phar.tar');
unlink(__DIR__ . '/' . basename(__FILE__, '.clean.php') . '.phar');
unlink(__DIR__ . '/' . basename(__FILE__, '.clean.php') . '.2.phar.tar');
__HALT_COMPILER();
?>
--EXPECT--
bool(false)
string(48) "<?php echo "first stub\n"; __HALT_COMPILER(); ?>"
bool(true)
string(60) "<?php // tar-based phar archive stub file
__HALT_COMPILER();"
bool(true)
string(60) "<?php // tar-based phar archive stub file
__HALT_COMPILER();"
===DONE===
