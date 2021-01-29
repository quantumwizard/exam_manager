<?php
include '../../src/exam_manager.php';

<<<<<<< HEAD
$students = array(1234=>"Steven Rogers", 4321=>"Tony Stark");
=======
fixed_order();

$students = array(1234=>"Steve Rogers", 4321=>"Tony Stark");
>>>>>>> master

$problems = array(
    array(10, '/(?=.*?(area))(?=.*?(raycruz))/is'),
    array(20, '/proj.php|q2.php/'),
    array(30, '/jkintner/'),
    array(10, '/raycruz|jkintner/')
);

$summary = array();

//A given $randseed should produce deterministic output for a given student
$randseed = __FILE__;

$summary1 = print_exams($students, $problems);

print_summary($summary1);

$summary2 = print_solutions($students, $problems, $summary);

print_summary($summary2);

//sanity check
if (json_encode($summary1)!=json_encode($summary2)){
    echo "The is an issue, exams and solutions are not the same!\n";
} else {
    echo "Successfully generated exams and solutions\n";
}



?>
