<?php
//add description tags
$keywords = 'area rectangle math easy grade2 raycruz';
//define variables
$length = rand(12,24);
$width = rand(5,10);
$area = $length * $width;

$report['length'] = $length;
$report['width'] = $width;
$report['area'] = $area;

?>
\item  (<?= $point_value ?> points)
What is the area of a rectangle of length <?= $length ?> and width <?= $width ?> ?
