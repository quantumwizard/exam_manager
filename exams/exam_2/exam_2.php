<?php
include '../../src/exam_manager.php';

//can do fixed or random order
//random_order();
fixed_order();

// you can add students as an array in this file or import a csv file
//first column = student id, second column= student name
// $students = array(
//     array(1234, "Steve Rogers"), 
//     array(4321, "Tony Stark")
// );
$students = import_csv('students.csv');

// you can add problems as an array in this file or import a csv file
// first column = point value, second column = regular expression search on $keywords
// $problems = import_csv('problems.csv');
$problems = array(
    array(10, '/(?=.*?(area))(?=.*?(raycruz))/is'),
    array(20, '/proj.php|q2.php/'),
    array(30, '/jkintner/'),
    array(10, '/raycruz|jkintner/')
);

//A given $randseed should produce deterministic output for a given student
$randseed = __FILE__;

$summary1 = print_exams($students, $problems);

$summary2 = print_solutions($students, $problems, $summary);

print_summary($summary2, "summary");

//sanity check
if (json_encode($summary1)!=json_encode($summary2)){
    echo "warning: Something went wrong, the exams and solutions do not match!\n";
} else {
    echo "Successfully generated exams and solutions\n";
}



?>
