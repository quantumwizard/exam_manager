<?php
include '../../src/exam_manager.php';

$students = array(1234=>"Steven Rogers", 4321=>"Tony Stark");

$problems = array(
    '/length/',
    '/projectile/'
);

$summary = array();

print_exams($students, $problems, $summary);

print_solutions($students, $problems, $summary);

print_summary($summary)

?>
