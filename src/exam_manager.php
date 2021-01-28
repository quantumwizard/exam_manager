<?php

function random_module($regex){
	$modules = array();
	$dir = new DirectoryIterator(__DIR__."/../modules");
	foreach ($dir as $fileinfo) {
		if (!$fileinfo->isDot()) {
			$fname = $fileinfo->getFilename();
			$path = $fileinfo->getPathname();
			if (preg_match($regex, $fname) || 
				preg_match($regex, file_get_contents($path))){
					$modules[] = $fname;
			}
		}
	}
	$num = count($modules);
	if ($num==0){
		throw new Exception("No modules match $regex");
	}
	return $modules[rand(0,$num-1)];
}

function print_exam($student_id, $student_name, $problems, &$summary, $is_solution){
	    include __DIR__.'/../modules/header.php';
		$student_report = array();
		$qid = 1;
		$tag = array();
		foreach($problems as $problem){
			if (preg_match('/\/.*\//', $problem)){
				$problem = random_module($problem);
			}
			$report = array("problem"=>$qid, "module"=>$problem);
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
			print_exam($student_id, $student_name, $problems, $summary, False);
			$fname = "$student_id.exam.tex";
			file_put_contents($fname, ob_get_contents());
			ob_end_clean();
			shell_exec("pdflatex  -interaction=batchmode $fname");
		}
}

function print_solutions($students, $problems, &$summary){
	    foreach($students as $student_id => $student_name){
			ob_start();
			print_exam($student_id, $student_name, $problems, $summary, True);
			$fname = "$student_id.solution.tex";
			file_put_contents($fname, ob_get_contents());
			ob_end_clean();
			shell_exec("pdflatex -interaction=batchmode $fname");
		}
}

function print_summary($summary){
	$output = json_encode($summary, JSON_PRETTY_PRINT);
	file_put_contents("summary.json", $output);
	print($output);
}
?>
