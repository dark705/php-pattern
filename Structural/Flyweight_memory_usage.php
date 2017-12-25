<?php
$startMemory = 0;
$startMemory = memory_get_usage();
$testfile = 'Flyweight_no.php';
// Измеряемое1
include $testfile;
echo "<br style='clear:both;'> \n";
echo "<br style='clear:both;'> \n";
echo "<br style='clear:both;'> \n";
echo "<br style='clear:both;'> \n";
echo "<br style='clear:both;'> \n";
echo "<br style='clear:both;'> \n";
echo "<br style='clear:both;'> \n";
echo "<br style='clear:both;'> \n";
echo "<br style='clear:both;'> \n";
echo "<br style='clear:both;'> \n";
echo "$testfile".(memory_get_usage() - $startMemory) . ' bytes' . PHP_EOL;

?>