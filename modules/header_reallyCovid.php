\documentstyle[12pt,graphicx]{article}
%\usepackage{graphicx}

%\usepackage{graphics}
\oddsidemargin -.125in
\textwidth 6.75in
\topmargin -.5in
\textheight 9.5in
\pagestyle{myheadings}
\markright{\it \small <?= $exam_info['course_id'] ?>, <?= $exam_info['teacher_name'] ?>, <?= $exam_info['exam_id'] ?>}
\newcommand{\ts}{\textstyle}
\begin{document}


\newcommand{\bm}[1]{\mbox{\boldmath$ #1 $}}
\newcommand{\pd}[2]{\frac{\partial #1}{\partial #2}}
\newcommand{\dd}[1]{\frac{d}{d#1}}
\newcommand{\ddt}[1]{\frac{d#1}{dt}}


\thispagestyle{empty}

\pagenumbering{roman}

%\noindent\hfill NAME:\rule[0in]{2.5in}{.01in}

\noindent \begin{tabular}{lp{5.0in}r}
<?= $exam_info['course_id'] ?> \hfill & & \hfill <?= $exam_info['semester'] ?>\\
\end{tabular}


<?php if ($is_solution) {  ?>

\centerline{Solution to <?= $exam_info["exam_id"] ?>}

<?php } else { ?>
\centerline{<?= $exam_info["exam_id"] ?>}

<?php } ?>

\centerline{<?= $exam_info["exam_date"] ?>}
\centerline{ <?= $student["First name"] ?>  <?= $student["Last name"] ?> }


\noindent Instructions:

\medskip\noindent  {\bf  Logistics of online exams:}

\medskip\noindent  {\bf Your answers to this exam must be submitted to Moodle by the end of class time.}
	You might want to set a timer or alarm to alert you 15 mins before the end of class time. \\
	(Sec 1:  9:15-10:20,   and Sec 2:  11:45-12:50)

\begin{itemize}
	\item I will email you the exam right before the start of class.
	\item Most of you will write the solutions on your own paper, scan them, and turn them in.
	\begin{itemize}
		\item {\bf Please space them as they are spaced on the exam.}.
		(I grade them page by page for consistency and anonymity.)
		\item  Please also number them and label parts.  For problems (not short answers),
		put a box around, or circle, your final answer.
		\item
		If you need more space, one problem per page is fine.
		\item If you can print and write on the exam, even better.
		If you can use a tablet to annotate the PDF file, that's great too.
		\item If you have handwritten them, use a scanner app to clean them up and put them in one PDF file.
	\end{itemize}
	\item Submit the PDF file to Moodle.  I will put the link at the top of the page for the day.
\end{itemize}

\medskip\noindent

\medskip\noindent {\bf Some constants:}

\vspace{.1in}
$g = 9.8$ m/s$^2$
%$g = 9.8$ m/s$^2$    \hspace{1.5in}  $ G = 6.67 \times 10^{-11}$N m$^2$/kg$^2$
\vspace{.1in}

\medskip\noindent {\bf Derivative table from class:}

\parbox{7.5cm}{


 \begin{tabular}{| r | l | }
\hline

%$\bigcirc$	& $  \frac{d\bigcirc}{dt} $	\\

 $f$		& 	$\frac{df}{dt}$ \\

\hline

$A$		& 0		\\
$A t^n$	& $nAt^{n-1}$  \\
$A \cos \omega t	$& $ -\omega A \sin \omega t$	\\
$B \sin \omega t$	& $  \omega B\cos \omega t$	\\
%$ B \cos(\omega t + \phi)$ & $ -\omega B \sin(\omega t + \phi)$  \\
%$ B \sin(\omega t + \phi)$ & $ \omega B \cos(\omega t + \phi)$  \\
%\\ $A e^{\beta t}$  &  $A e^{\beta t}$  \\
\hline
\end{tabular}



        }
        \hfill
        \parbox{7.5cm}{


\medskip\noindent {\bf Some helpful equations:}

$$ \Delta \vec r \equiv \vec r_f - \vec r_i $$

$$ \vec{v} \equiv  \ddt{\vec{r}}  \hspace{.5in}  \vec{v}_{ave} \equiv  \frac{\Delta\vec{r}}{\Delta t} $$

$$ \vec{a} \equiv \ddt{\vec v}   \hspace{.5in}    \vec{a}_{ave} \equiv  \frac{\Delta\vec{v}}{\Delta t} $$

$$ \vec v = \vec{v_0} + \vec a t $$

$$  \vec r = \vec{r_0} + \vec{v_0}t + \frac{1}{2} \vec a t^2	$$

%$$ v^2 = v_{0}^2 + 2a(x-x_0) $$
%$$ v^2 = v_{0}^2 + 2a(r-r_0) $$


%$$ F = -kx $$
$$ \Sigma \vec F = m \vec a $$
%$$ \vec F_{12} = - \vec F_{21} $$

$$ \vec F_g \equiv m\vec g $$
%$$  F_{fr}  = \mu F_N $$

% $$ a_c = \frac{v^2}{r} $$

% $$ F_G = G \frac{Mm}{r^2} $$

% $$ W \equiv  \int \vec F \cdot d\vec \ell $$

% $$ KE \equiv  \frac{1}{2} m v^2 $$
%$$ W_{net} = \Delta KE $$

%$$ \Delta U_c \equiv -W_c $$
%$$ U_g = mgh $$
%$$ U_s =  \frac{1}{2} kx^2 $$

}

\pagebreak
\pagenumbering{arabic}

\noindent\hfill NAME:\rule[0in]{2.5in}{.01in}



\begin{enumerate}
