<?php 

function set_val($id, $val){
	    return $val;
}
function get_val($id){
	    global $vals;
	        return $vals[$id];
}
function print_exam($student_id, $student_name, $problems){
	    include __DIR__.'/../modules/header.php';

	        $qid = 1;
	        foreach($problems as $problem){
			        include __DIR__."/../modules/$problem";
				        $qid++;
				    }
		    include __DIR__.'/../modules/footer.php';
}

function print_exams($students, $problems){
	    foreach($students as $student_id => $student_name){
		            ob_start();
			            print_exam($student_id, $student_name, $problems);
			            file_put_contents("$student_id.tex", ob_get_contents());
				            ob_end_clean();
				        }
}

?>

