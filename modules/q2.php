<?php 
//define variables
$length = rand(12,24);
$width = rand(5,10);
$height = rand(4,23);
$volume = $length * $width * $height;

$report['length'] = $length;
$report['width'] = $width;
$report['height'] = $area;
$report['volume'] = $volume;

?>

<?= $qid ?>. What is the volume of a box of length <?= $length ?> and width <?= $width ?> and height <?= $height ?>?


