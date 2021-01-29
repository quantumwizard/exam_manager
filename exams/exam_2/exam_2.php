<?php
include '../../src/exam_manager.php';

$students = array(1234=>"Steven Rogers", 4321=>"Tony Stark");

$problems = array(
    array(10, '/(?=.*?(area))(?=.*?(raycruz))/is'),
    array(20, '/proj.php|q2.php/'),
    array(30, '/jkintner/'),
    array(10, '/raycruz|jkintner/')
);

$summary = array();

$randseed = "testin";

print_exams($students, $problems, $summary);

print_summary($summary);

print_solutions($students, $problems, $summary);

print_summary($summary)

?>
