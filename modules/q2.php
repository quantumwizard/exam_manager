<?php 
//add description tags
$keywords = 'volume box math easy grade2 raycruz';
//define variables
$length = rand(12,24);
$width = rand(5,10);
$height = rand(4,23);
$volume = $length * $width * $height;

$report['length'] = $length;
$report['width'] = $width;
$report['height'] = $height;
$report['volume'] = $volume;

?>
\item  (20 points)
What is the volume of a box of length <?= $length ?> and width <?= $width ?> and height <?= $height ?>?


