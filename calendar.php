<?php 
		/* 		
			PHP calendar created by Stefany Dyulgerova
			stefany.dyulgerova@gmail.com 
			www.dyulgerova.info
			18.02.2013
			Enjoy!
		*/
// $year, and $month are the most important variables.
// They have conditional values, i.e. if their respective valyes are not set in the URL 
// as a query string, their default value is the current year and month.
	$year = (isset($_GET['year'])) ? filter_input(INPUT_GET, 'year', FILTER_SANITIZE_NUMBER_INT) : date('Y');
	$month = (isset($_GET['month'])) ? filter_input(INPUT_GET, 'month', FILTER_SANITIZE_NUMBER_INT) : date('m');
// $days_in_month calculates stores the number of the days in each month
// cal_day_in_month function's last two arguments are the variables declared above.
	$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
// $count will be used for incrementing until it equals $days_in_month,
// $tr will be used for inserting a "<tr>" element every time the $count variable
// hits 8.
		$count = 1;
		$tr = 1;
// $first_day calculates the name of the first of the month.
// This is important, because we want to be able to calculate 
// how many spaces to insert before putting the first day 
// of the month in the correct place. Otherwise all months
// will start from Monday and that's just lame...
// $first_day_of_month actually uses $first day and outputs
// the name of the first day.
		$first_day = mktime(0,0,0,$month,1,$year);
		$first_day_of_month = date('D', $first_day);
// Now here is the tricky part. We declare a new variable
// $blank, and its sole purpose is to be used later in the while
// loop to insert empty "<td>" elements in our calendar
// only if the first day of the month is not Monday.
		$blank = 0;
// The switch statement below checks the name of the 
// first day of the month 
// and we overwrite the $blank variable
// depending on the name of the day.
		switch($first_day_of_month){
			case 'Mon' : $blank = 0;
			break;
			case 'Tue' : $blank = 1;
			break;
			case 'Wed' : $blank = 2;
			break;
			case 'Thu' : $blank = 3;
			break;
			case 'Fri' : $blank = 4;
			break;
			case 'Sat' : $blank = 5;
			break;
			case 'Sun' : $blank = 6;
		}
		?>
<!-- Now, the table represents pretty much the calender itself. -->
<!-- The "caption" element holds the name of the current month.  -->
		<table>
			<caption><?php echo '<strong>',date('F', $first_day),'</strong>'; ?></caption>
			<tr>
				<th>M</th>
				<th>T</th>
				<th>W</th>
				<th>T</th>
				<th>F</th>
				<th>S</th>
				<th>S</th>
			</tr>
			<tr>
			<?php
// Here we take the $blank variables we declared earlier
//  and processed in the switch statemen.
// The first while loop has the sole purpose
// of putting "<td>" elements i.e. empty space
// before outputting the first day of the month.
// the while loop will ONLY put empty space if
// the the $blank variable is more than 0
// i.e. the first day of the month is not monday.
// In each looping of the loop, we take 1 from the $blank variable
// and we add 1 to the $tr one, so it could insert "<tr>" elements
// when the week starts and thus make the calendar look like one...
			while($blank > 0){
				echo '<td></td>';
				$blank--;
				$tr++;
			}
// Now, after we have inserted enough "<td>" elements
// we actually output the calendar. 
// In the following while loop we compare the 
// $count varialbe with the $days_in_month variable
// i.e. we increment and display the value of the $count variable
// until it is equal to the numbers of the days of the current month.
// We increment the $tr variable so that it automatically inserts "<tr>"
// elements at the end of each week.
			while($count <= $days_in_month){
			echo '<td>',$count++,'</td>';
			$tr++;
			if($tr > 7){
				echo '<tr></tr>';
				$tr = 1;
			}
		}
// Now, until this line, our calendar is only showing the current
// month and that's a bit lame, so now we are creating the functionality
// for the back/forward buttons.
// First we put the $year variable in another one
// so that we can increment its value later.
// $increment_month and $decrease_month do pretty much
// what their names suggest.
		$increment_year = $year;
		$decrease_year = $year;
		$increment_month =  $month + 1;
		$decrease_month =  $month - 1;
// That if statements checks whether the user has clicked "Forward"
// after it is passed December and it they have, we display them January instead
// and we increment the year with 1.
		if($increment_month === 13){
			$increment_month = 1;
			$increment_year =  $year + 1;
		}
// This if statement is doing pretty much the exact opposite
// of the above one.
		if($decrease_month === 0){
			$decrease_month = 12;
			$decrease_year = $year - 1;
		}
// And the back/forward buttons below. 
		?>
			</tr>
		</table>
		<a href="test.php?month=<?php echo $increment_month; ?>&year=<?php echo $increment_year; ?>"> Forward </a>
		<br />
		<a href="test.php?month=<?php echo $decrease_month; ?>&year=<?php echo $decrease_year; ?>"> Back </a>