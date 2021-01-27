<?php
include '../../src/exam_manager.php';

$students = array(1234=>"Steve Rogers", 4321=>"Tony Stark");

$problems = array('q1.php', 'q1.php', 'q2.php');

$summary = array();

print_exams($students, $problems, $summary);

print_summary($summary)

?>
