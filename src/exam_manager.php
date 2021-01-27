<?php 

function set_val($id, $val){
	    return $val;
}
function get_val($id){
	    global $vals;
	        return $vals[$id];
}
function print_exam($student_id, $student_name, $problems, &$summary){
	    include __DIR__.'/../modules/header.php';
		$student_report = array();
		$qid = 1;
		foreach($problems as $problem){
			$report = array("qid"=>$qid);
			srand(crc32("$student_id.$student_name.$problem.$qid"));
			include __DIR__."/../modules/$problem";
			$student_report[] = $report;
			$qid++;
		}
		include __DIR__.'/../modules/footer.php';
		$summary["$student_id:$student_name"] = $student_report;
}

function print_exams($students, $problems, &$summary){
	    foreach($students as $student_id => $student_name){
			ob_start();
			print_exam($student_id, $student_name, $problems, $summary);
			file_put_contents("$student_id.tex", ob_get_contents());
			ob_end_clean();
		}
}

?>

