<?php if (!isset($this->total_moods[0])) { ?>

<div class="box">
	<h2>Moods</h2>
	<div class="box bg-white align-center">
		<h3>Nothing here yet.</h3>
		Add your moods and track how you're feeling over time.
	</div>
</div>

<?php } else { ?>

<div class="box calories moods_totals group nosidepad">
	<h2>Moods</h2>
	<ul class="chartlist">
	<?php
		foreach ($this->total_moods as $mood) {
			$max = $this->total_moods[0]->cnt;
			$percent = ($mood->cnt / $max) * 100;
			?>
			<li class="category category_<?=$mood->feeling?>" data-category="<?=$mood->feeling?>">
			<a href="#" class="feeling_<?=$mood->feeling?>"><img src="/img/<?=$mood->feeling?>.svg" alt="<?=$mood->feeling?>" /></a>
			<span class="count"><?=$mood->cnt?></span>
			<span class="index" style="width: <?=$percent?>%">(<?=$percent?>%)</span>
			<?php
		}
		?>
	</ul>

	<script type="text/javascript">
	$(document).ready(function() {
		$('.moods_totals li').click(function() {
			var cat = $(this).data("category");
	
			$('.feelings table, .feelings tr').removeClass('hide');
			$('.feelings tr').not('.feeling_'+cat).addClass('hide');
	
			$('li.category').removeClass('op20');
			$('li.category').not('.category_'+cat).addClass('op20');
	
			return false;
		});
	});
	</script>

</div>



<?php
$month = date('m');
$year = date('Y');

// build array of feelings this year
// [todo] make part of user area, globally accessible
foreach ($this->feelings_all as $mood) {
	$feelings[$mood->short_date] = $mood->feeling;
}


// filter by month
// [todo] move to helper/utils external
function build_calendar($month,$year,$feelings) {

    $daysOfWeek = array('S','M','T','W','T','F','S');
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
    $numberDays = date('t',$firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $calendar = '<h2><span class="month">'.$monthName.' '.$year.'</span></h2>';
    $calendar .= "<table class='calendar'>";
    $calendar .= "<tr>";

    // Create the calendar headers
    foreach($daysOfWeek as $day) {
         $calendar .= "<th class='header hide'>$day</th>";
    }

    $currentDay = 1;
    $calendar .= "</tr><tr>";
    if ($dayOfWeek > 0) {
         $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {
         // Seventh column (Saturday) reached. Start a new row.
         if ($dayOfWeek == 7) {
              $dayOfWeek = 0;
              $calendar .= "</tr><tr>";
         }

         $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
         $date = "$year-$month-$currentDayRel";

    	$checked = '';
    	if (isset($feelings["$date"])) {
			$checked = 'checked';
	        $calendar .= "<td class='day $checked' rel='$date'><img src=\"/img/".$feelings[$date].".svg\" width='20' /></td>";
    	} else {
	        $calendar .= "<td class='day $checked' rel='$date'>$currentDay</td>";
		}

         // Increment counters
         $currentDay++;
         $dayOfWeek++;
    }

    // Complete the row of the last week in month, if necessary
    if ($dayOfWeek != 7) {
         $remainingDays = 7 - $dayOfWeek;
         $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";    
    return $calendar;
}

?>

	<?php
		$last_month='';
		$last_date='';
		foreach ($this->moods_year as $mood) {
		
			if ($last_month !== $mood->month) {

				// close if not the first block
				if ($last_month > 0) {
					echo '</table></div></div>';
				}
				echo '<div class="box bg-white recently">';
				echo build_calendar($mood->month,$mood->year,$feelings);
				echo '<div class="feelings"><table class="hide">';
			}
		
			$simple_date = '';
			if ($last_date !== $mood->human_date) {
				$simple_date = ' class="linear_dupe"';
			}
			?>
			<tr class="feeling_<?=$mood->feeling?>">
				<td class="nowrap tiny">
					<span<?=$simple_date?>><?=$mood->human_day?></span>
					<span class="lite block"><?=strtolower($mood->human_time)?></span>
				</td>
				<td><?=$mood->note?></td>
				<td><img src="/img/<?=$mood->feeling?>.svg" alt="<?=$mood->feeling?>" /></td>
			</tr>
			<?php
			$last_date = $mood->human_date;
			$last_month = $mood->month;
		}
	?>
	</table>
</div></div>

<script>
$(document).ready(function(){

	$(".recently").click(function () { 
		$('.feelings table', this).toggleClass('hide');
		//$('.feelings table', this).slideToggle();
	});

});
</script>

<?php } // end of page content ?>