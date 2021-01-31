<?php
//add description tags
  $keywords = 'physics force incline intro easy freshman jkintner';

//varables
  $mass = frand(.1, 3.0, 2);
  $angle = rand(5, 40);

//make report
  $report["mass"] = $mass;
  $report["angle"] = $angle;

?>

\item (<?= $point_value ?> points) A box of mass <?= $mass ?>kg slides down an incline as shown.
	The incline makes an angle of <?= $angle ?>$^\circ$ with respect to the horizontal.
	\begin{enumerate}
		\item Draw a free body diagram for the box.
		\item  What is the Normal force on the box?
		\item What is the acceleration of the box?
	\end{enumerate}

\includegraphics[width=5cm]{<?= __DIR__."/images/" ?>exam2_figIncline2.pdf}

<?php if ($is_solution) {  ?>

{\bf Solution: } Starting from $$ \Sigma F_y = F_n - mg\cos\theta = ma_y $$
  we get $$ F_N = mg\cos\theta $$
		$$ F_N = <?= $mass ?>kg (9.81m/s^2) \cos(<?= $angle ?>) = <?= sig_fig($mass * 9.81 * cos($angle*3.14/180), 3) ?> $$

<?php } ?>
