<?php 

$students = array(1234=>"Steve Rogers", 4321=>"Tony Stark");
$vals = array();
$q_id = 0;
$student_name = "";
$student_id = 0;

function set_val($id, $val){
    global $vals;
    global $student_id;
    $vals[$id] = $val;
    return $val;
}
function get_val($id){
    global $vals;
    return $vals[$id];
}
function add_question($filename){
    global $q_id;
    global $student_name;
    $q_id += 1;
    include $filename;
}
function print_exam($studentId){
    global $student_name;
    global $students;
    global $student_id;
    $student_id = $studentId;
    $student_name = $students[$studentId];
    include 'header.php';

    add_question('q1.php');
    add_question('q1.php');
    
    include 'footer.php';
}

foreach($students as $id => $name){
    $q_id = 0;
    print_exam($id);
    print("=================================\n");
}

?>
