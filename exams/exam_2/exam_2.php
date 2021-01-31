<?php
include '../../src/exam_manager.php';

//This data is made available to all the modules
$exam_data = array(
    'teacher_name'=>"Prof. Kintner",
    'course_id'=>"PHYS 10",
    'section' => '1',
    'course_title'=>"Intro Physics",
    'exam_date' => "Jan 7, 2021",
    'exam_topic' => "kinematics",
    'exam_id' => 'Exam I',
    'semester' => 'Spring 2021'
);
// you can add students as an array in this file or import a csv file
//columns "ID number" "First name" and "Last name" should be present.
// $students = array(
//     array('ID number'=>1234, 'First name'=>"Steve", 'Last name'=>"Rogers"), 
//     array('ID number'=>4321, 'First name'=>"Tony",  'Last name'=>"Stark")
//  );
//$students = import_csv('200825_sec01_names.csv');
$students = import_csv('students.csv');

// you can add tex modules as an array in this file or import a csv file
// first column = point value, second column = regular expression search on $keywords (and filenames)
// $problems = import_csv('problems.csv');
$problems = array(
    array('point_value'=>10, 'regex'=>'/(?=.*?(area))(?=.*?(raycruz))/is'),
    array('point_value'=>20, 'regex'=>'/proj.php|q2.php/'),
    array('point_value'=>30, 'regex'=>'/jkintner/'),
    array('point_value'=>10, 'regex'=>'/raycruz|jkintner/')
);

$headers = array(
    'header_reallyCovid.php'
);

$footers = array(
    'footer.php'
);

//can print problems fixed or random order
//random_order();
fixed_order();

//A given $randseed should produce deterministic output for a given student
$randseed = __FILE__;

$summary1 = print_exams($exam_data, $students, $problems, $headers, $footers);

$summary2 = print_solutions($exam_data, $students, $problems, $headers, $footers);

print_summary($summary2, "summary");

//sanity check
if (json_encode($summary1)!=json_encode($summary2)){
    echo "warning: Something went wrong, the exams and solutions do not match!\n";
} else {
    echo "Successfully generated exams and solutions\n";
}



?>
