#!/usr/bin/php
<?php
include "exam_manager.php";
print_summary(print_problems($argv[1], $argv[2]));
?>