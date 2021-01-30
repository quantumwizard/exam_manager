<?php

$randseed = "default";
$random_order = True;
function random_order(){
	global $random_order;
	$random_order = True;
}
function fixed_order(){
	global $random_order;
	$random_order = False;
}
function search_keywords($regex, $fname){
	$keywords = '';
	$student_name = '';
	$student_id = '';
	$is_solution = False;
	$qid = 0;
	$point_value = 0;
	ob_start();
	include __DIR__."/../modules/$fname";
	ob_end_clean();
	return preg_match($regex, $keywords);
}
function select_modules($regex, $used_modules){
	$modules = array();
	$dir = new DirectoryIterator(__DIR__."/../modules");
	foreach ($dir as $fileinfo) {
		$fname = $fileinfo->getFilename();
		if (in_array($fname, $used_modules)){
			continue;
		}
		if (!$fileinfo->isDot() and !preg_match('/header|footer/', $fname))  {
			$fname = $fileinfo->getFilename();
			$path = $fileinfo->getPathname();
			if (preg_match($regex, $fname) || search_keywords($regex, $fname)){
				//preg_match($regex, file_get_contents($path))){
					$modules[] = $fname;
			}
		}
	}
	return $modules;
}
function random_module($regex, $used_modules){
	$modules = select_modules($regex, $used_modules);
	$num = count($modules);
	if ($num==0){
		throw new Exception("No unused modules match $regex");
	}
	return $modules[rand(0,$num-1)];
}
function print_problem($qid, $student_id, $student_name, $problem, &$report, $point_value, $is_solution){
	include __DIR__."/../modules/$problem";
}
function print_exam($student_id, $student_name, $problems, &$summary, $is_solution){
		global $randseed;
		global $random_order;
	    include __DIR__.'/../modules/header.php';
		$student_report = array();
		$qid = 1;
		$tag = array();
		if ($random_order){
			srand(crc32("$randseed.$student_id.$student_name"));
			shuffle($problems);
		}
		$used_modules = array();
		foreach($problems as $p){
			$point_value = $p[0];
			$problem = $p[1];
			if (preg_match('/\/.*\//', $problem)){
				$problem = random_module($problem, $used_modules);
			}
			$used_modules[] = $problem;
			$report = array("problem"=>$qid, "module"=>$problem, "point_value"=>$point_value);
			srand(crc32("$randseed.$student_id.$student_name.$problem.$qid"));
			print_problem($qid, $student_id, $student_name, $problem, $report, $point_value, $is_solution);
			//include __DIR__."/../modules/$problem";
			$student_report[] = $report;
			$qid++;
		}
		include __DIR__.'/../modules/footer.php';
		$summary["$student_id:$student_name"] = $student_report;
}

function import_csv($fname){
	$row = 1;
	$output = [];
	if (($handle = fopen($fname, "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$output[] = $data;
		}
		fclose($handle);
	} else {
		throw new Exception("can't find file: $fname");
	}
	return $output;
}
function print_exams_imp($students, $problems, $is_solution){
	$summary = array();
	try {
		foreach($students as $student){
			$student_id = $student[0];
			$student_name = $student[1];
			ob_start();
			print_exam($student_id, $student_name, $problems, $summary, $is_solution);
			if ($is_solution){
				$fname = "$student_id.solution.tex";
			 } else {
				 $fname = "$student_id.exam.tex";
			 } 	
			file_put_contents($fname, ob_get_contents());
			ob_end_clean();
			shell_exec("pdflatex  -interaction=batchmode $fname");
		}
	} catch (Exception $e){
		ob_end_clean();
		echo "exception: ", $e->getMessage(), "\n";
		exit(0);
	}
	return $summary;
}
function print_exams($students, $problems){
	return print_exams_imp($students, $problems, False);
}
function print_solutions($students, $problems){
	return print_exams_imp($students, $problems, True);
}

function print_summary($summary, $fname = ""){
	$output = json_encode($summary, JSON_PRETTY_PRINT);
	print($output."\n");
	if ($fname != ""){
		file_put_contents("$fname.json", $output);
	}
}
function print_problems_tex($student_id, $student_name, $problems, &$summary, $is_solution){
	global $randseed;
	include __DIR__.'/../modules/header.php';
	$student_report = array();
	$qid = 1;
	$tag = array();
	$point_value = 0;
	foreach($problems as $problem){
		$report = array("problem"=>$qid, "module"=>$problem, "point_value"=>$point_value);
		srand(crc32("$randseed.$student_id.$student_name.$problem.$qid"));
		print_problem($qid, $student_id, $student_name, $problem, $report, $point_value, $is_solution);
		//include __DIR__."/../modules/$problem";
		$student_report[] = $report;
		$qid++;
	}
	include __DIR__.'/../modules/footer.php';
	$summary["$student_id:$student_name"] = $student_report;
}

function print_problems($fname, $regex, $student_name="Jane Doe", $student_id=666){
	$summary = array();
	$problems = select_modules($regex);
	//var_dump($problems);
	try {
		ob_start();
		print_problems_tex($student_id, $student_name, $problems, $summary, True);
		$fname = "$fname.tex";
		file_put_contents($fname, ob_get_contents());
		ob_end_clean();
		shell_exec("pdflatex  -interaction=batchmode $fname");
	} catch (Exception $e){
		ob_end_clean();
		echo "exception: ", $e->getMessage(), "\n";
		exit(0);
	}
	return $summary;

}
?>


