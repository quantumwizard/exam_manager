<?php
  $keywords = 'physics kinematics intro easy freshman jkintner';
  $acc = rand(1, 5);
  $time = rand(2, 15);
  $dist =  .5* $acc * pow($time, 2);
  $report["acc"] = $acc;
  $report["time"] = $time;
  $report["dist"] = $dist;
?>

\item (<?= $point_value ?> points) A car starts from rest and accelerates uniformly at a rate of <?= $acc ?>m/s$^2$
  due North over a time of <?= $time ?>s.

	\begin{enumerate}
		\item	 How far did the car travel in those 5s?
		\item What is the car's velocity at t=5s?
	\end{enumerate}

  <?php if ($is_solution) {  ?>

  {\bf Solution: } Starting from $$ x = x_0 + v_0 t + 1/2 a t^2 $$
    we get $$ d = 0 + 0 + 1/2 a t^2 =1/2 <?= $acc ?> <?= $time ?>^2 = <?= $dist ?> $$

  <?php } ?>
