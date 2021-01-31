<?php
//add description tags
  $keywords = 'physics projectile intro easy freshman jkintner';

//varables
  $speed = rand(5, 25);
  $height = rand(5, 25);
  $timeEnd = sqrt(2*$height/9.8);

//make report
  $report["speed"] = $speed;
  $report["height"] = $height;
  $report["timeEnd"] = $timeEnd;

?>

\item  (<?= $point_value ?> points)  <?= $student["First name"] ?> is frustrated and throws their textbook from a window.
	If the initial velocity of the book is <?= $speed ?> m/s horizontally, and the window is <?= $height ?>m above ground:
	(Ignore air resistance.)

		\begin{enumerate}
		\item  How long does it take for the book to hit the ground?
		\item  How far does it go horizontally?
		\item  What is the book's velocity right before it hits the ground?
		\end{enumerate}

<?php if ($is_solution) {  ?>

{\bf Solution: } Starting from $$ y = y_0 + v_0 t + 1/2 a t^2 $$
  we get $$ t = \sqrt{\frac{2h}{g}} = \sqrt{\frac{2 <?= $height ?>}{g}} = <?= $timeEnd ?> $$

<?php } ?>
