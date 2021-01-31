<?php

$randseed = "default";
$random_order = True;
$img_dir = __DIR__."/../modules/resources";

$default_student = array('ID number'=>'8888', 'First name'=>'Jane', 'Last name'=>'Doe');
$default_exam_info = array(
    'teacher_name'=>"Professor",
    'course_id'=>"Course ID",
    'course_title'=>"Title",
    'exam_date' => "TBD",
    'exam_topic' => "topic",
    'exam_id' => '1'
);
//might be useful for generating random floats in modules
//generates random float between 0.0 and 1.0
function sig_fig($value, $digits)
{
    if ($value == 0) {
        $decimalPlaces = $digits - 1;
    } elseif ($value < 0) {
        $decimalPlaces = $digits - floor(log10($value * -1)) - 1;
    } else {
        $decimalPlaces = $digits - floor(log10($value)) - 1;
    }

    $answer = ($decimalPlaces > 0) ?
        number_format($value, $decimalPlaces) : round($value, $decimalPlaces);
	return $answer;
	
}

function frand($min, $max, $sigfigs=5){
	return sig_fig($min + ($max-$min)*rand(0, PHP_INT_MAX)/PHP_INT_MAX, $sigfigs);
}

function random_order(){
	global $random_order;
	$random_order = True;
}
function fixed_order(){
	global $random_order;
	$random_order = False;
}
function search_keywords($regex, $fname){
	global $default_student;
	global $default_exam_info;
	$keywords = '';
	$student = $default_student;
	$exam_info = $default_exam_info;
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
function print_problem($exam_info, $qid, $student, $problem, &$report, $point_value, $is_solution){
	global $image_dir;
	include __DIR__."/../modules/$problem";
}
function print_exam($exam_info, $student, $problems, $headers, $footers, &$summary, $is_solution){
		global $randseed;
		global $random_order;
		global $image_dir;
		foreach ($headers as $header){
			include __DIR__."/../modules/$header";
		}
		$student_report = array();
		$qid = 1;
		$tag = array();
		if ($random_order){
			srand(crc32($randseed.$student["ID number"]));
			shuffle($problems);
		}
		$used_modules = array();
		foreach($problems as $p){
			$point_value = $p['point_value'];
			$problem = $p['regex'];
			if (preg_match('/\/.*\//', $problem)){
				$problem = random_module($problem, $used_modules);
			}
			$used_modules[] = $problem;
			$report = array("problem"=>$qid, "module"=>$problem, "point_value"=>$point_value);
			srand(crc32($randseed.$student["ID number"].$problem.$qid));
			print_problem($exam_info, $qid, $student, $problem, $report, $point_value, $is_solution);
			//include __DIR__."/../modules/$problem";
			$student_report[] = $report;
			$qid++;
		}
		foreach ($footers as $footer){
			include __DIR__."/../modules/$footer";
		}
		$summary["{$student["ID number"]}:{$student["Last name"]}"] = $student_report;
}

function import_csv($fname){
	$count = 0;
	$output = [];
	$key = array();
	if (($handle = fopen($fname, "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($count == 0){
				//for unknown reason key[0] has unprintable chars prepended.
				foreach($data as $k){
					$key[] = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $k);
				}
			} else {
				$row = array();
				$colnum = 0;
				foreach ($data as $col){
					$row[$key[$colnum]] = $col;
					++$colnum;
				}
				$output[] = $row;
			}
			++$count;
		}
		fclose($handle);
	} else {
		throw new Exception("can't find file: $fname");
	}
	//var_dump($output);
	return $output;
}
function print_exams_imp($exam_info, $students, $problems, $headers, $footers, $is_solution){
	$summary = array();
	try {
		$output_dir = 'exams';
		if ($is_solution){
			$output_dir = 'solutions';
		}
		if (!is_dir($output_dir)){
			mkdir($output_dir);
		}
		foreach($students as $student){
			//var_dump($student);
			/*
			if (!array_key_exists('Last name', $student)){
				echo "Last name not found for ";
				var_dump($student);
				exit(1);
			} else {
				echo "Last name found.\n";
			}
			if (!array_key_exists('First name', $student)){
				echo "First name not found for ";
				//var_dump($student);
				foreach ($student as $key => $val){
					echo $key, ": ", $val ,"\n";
				}
				var_dump($student);
				exit(1);
			}
			*/
			$student_id = $student['ID number'];
			$student_first = $student["First name"];
			$student_last = $student['Last name'];
			ob_start();
			print_exam($exam_info, $student, $problems, $headers, $footers, $summary, $is_solution);
			if ($is_solution){
				$fname = "$output_dir/$student_first.$student_last.$student_id.solution.tex";
			 } else {
				 $fname = "$output_dir/$student_first.$student_last.$student_id.exam.tex";
			 } 	
			file_put_contents($fname, ob_get_contents());
			ob_end_clean();
			shell_exec("pdflatex -output-directory $output_dir -interaction=batchmode $fname");
		}
	} catch (Exception $e){
		ob_end_clean();
		echo "exception: ", $e->getMessage(), "\n";
		exit(1);
	}
	return $summary;
}
function print_exams($exam_info, $students, $problems, $headers, $footers){
	return print_exams_imp($exam_info, $students, $problems, $headers, $footers, False);
}
function print_solutions($exam_info, $students, $problems, $headers, $footers){
	return print_exams_imp($exam_info, $students, $problems, $headers, $footers, True);
}

function print_summary($summary, $fname = ""){
	$output = json_encode($summary, JSON_PRETTY_PRINT);
	//print($output."\n");
	if ($fname != ""){
		file_put_contents("$fname.json", $output);
	}
}
function print_problems_tex($problems, &$summary, $is_solution){
	global $randseed;
	include __DIR__.'/../modules/header.php';
	//dummy student
	$student = array(
		'ID number'=> 6666,
		'First name' => "Jane",
		'Last name' => 'Doe'
	);
	$student_report = array();
	$qid = 1;
	$tag = array();
	$point_value = 0;
	foreach($problems as $problem){
		$report = array("problem"=>$qid, "module"=>$problem, "point_value"=>$point_value);
		srand(crc32("$randseed.$student_id.$student_name.$problem.$qid"));
		print_problem($default_exam_info, $qid, $student, $problem, $report, $point_value, $is_solution);
		//include __DIR__."/../modules/$problem";
		$student_report[] = $report;
		$qid++;
	}
	include __DIR__.'/../modules/footer.php';
	$summary["$student_id:$student_name"] = $student_report;
}

function print_problems($fname, $regex){
	$summary = array();
	$problems = select_modules($regex);
	//var_dump($problems);
	try {
		ob_start();
		print_problems_tex($problems, $summary, True);
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


