<?php
  $speed = rand(5, 25);
  $height = rand(5, 25);
  $report["speed"] = $speed;
  $report["height"] = $height;
  $report["timeToHitBottom"] = sqrt(2*$height/9.8);
?>

\item  (20 points)  <?= $student_name ?> is frustrated and throws their textbook from a window.
	If the initial velocity of the book is <?= $speed ?> m/s horizontally, and the window is <?= $height ?>m above ground:
	(Ignore air resistance.)

		\begin{enumerate}
		\item  How long does it take for the book to hit the ground?
		\item  How far does it go horizontally?
		\item  What is the book's velocity right before it hits the ground?
		\end{enumerate}
