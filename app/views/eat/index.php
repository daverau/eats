<?php
/*

[todo]
target calories as user preference
email reminders
local setup
edit
	food and calories)
	when/what eat it
	mood and note

*/

// [todo] move to user table as setting
global $target_calories;
$target_calories = 2500;

// [todo] move functions to helper/utils library
function what_color($num)	{
	global $target_calories;
	$percentage = round(($num / $target_calories) * 100);
	if ($percentage < 40) {
		$class = 'red';
	} else if ($percentage < 80) {
		$class = 'yellow';
	} else if ($percentage >= 80) {
		$class = 'green';
	}
	return $class;
}
?>


<div class="mbox margin-bottom-0">
	<div class="today-circle <?=what_color($this->calories_today)?>" id="today-circle">
		<?php
		if ($this->calories_today == 0) {
			echo '<span class="number">0</span> <span class="cal">go eat!</span>';
		} else {
			?>
			<span class="number"><?=$this->calories_today + 0?></span> <span class="cal">calories</span>
			<?php
		}
		?>
		<span class="drops">
			<?php
			if ($this->water_today == 0) {
				echo '<img src="/img/water.svg" alt="water" class="water op20" />';
			} else {
				for ($x=1; $this->water_today >= $x; $x++) {
					echo '<img src="/img/water.svg" alt="water" class="water" />';
				}
			}
			?>
		</span>
	</div>

<div class="calories hide box-calories" id="box-calories">
	<?php
	if ($this->recently_eaten) {
	?>
	<h2>recently</h2>
	<div id="recently">
		<table id="recent">
		<thead>
		<tr>
		<th class="align-left">food</th>
		<th class="align-right">calories</th>
		<th class="align-right">when</th>
		</tr>
		</thead>
		<tbody>
			<?php
			$caltotal=0;
			foreach ($this->recently_eaten as $food) {
				$caltotal += $food->total;
				?>
				<tr id="log_<?=$food->id?>">
					<td><?=htmlentities($food->name)?></td>
					<td class="num"><?=$food->total?></td>
					<td class="tiny lowercase align-right lite"><?php echo str_replace('from', '', $food->human_time); ?> <a href="<?=URL?>eat/delete_eat_log/<?=$food->id?>" class="trash">x</a></td>
				</tr>
				<?php
				$last_when = str_replace('from', '', $food->human_time);
			}
			?>
		</tbody>
		</table>
	</div>
	<?php } ?>


<div class="calories">
	<h2>last two weeks</h2>
	<div class="group">
		<ul class="timeline" id="foods_over_time">
		  <li id="goal">
			<a title="goal">
			  <span class="label">G</span>
			  <span class="count goal" style="height: 100%">(<?=$target_calories?></span>
			</a>
		  </li>
		<?php
		// daily calorie totals
		foreach ($this->caloriesTwoweeks as $row) {
			$class = what_color($row->total);
		?>
		  <li>
			<a title="<?=round($row->total)?> calories (<?=$row->human_date?>)">
			  <span class="label"><?=$row->day?></span>
			  <span class="count <?=$class?>" style="height: <?=round($row->total / $target_calories * 100)?>%">(<?=round($row->total)?>)</span>
			</a>
		  </li>
		<?php
		}
		?>
		</ul>
		</div>
</div>


	</div>

</div>	




<div class="box nosidepad">
	<h2>Eat</h2>
	<form id="eat_it" name="eat_food" method="post" action="<?=URL?>eat/eat_food">
		<input type="hidden" name="eats_foods_id" id="eats_foods_id" value="0" />
	</form>
	<table class="eat-it">
		<tr>
			<td data-cat="fruit"><img src="/img/icon-fruit.svg" alt="" />FRUIT</td>
			<td data-cat="veggie"><img src="/img/icon-veggie.svg" alt="" />VEGGIE</td>
			<td data-cat="protein"><img src="/img/icon-meat.svg" alt="" />PROTEIN</td>
		</tr>
		<tr>
			<td data-cat="dairy"><img src="/img/icon-dairy.svg" alt="" />DAIRY</td>
			<td data-cat="grain"><img src="/img/icon-grain.svg" alt="" />GRAIN</td>
			<td data-cat="fat"><img src="/img/icon-fat.svg" alt="" />FAT</td>
		</tr>
		<tr>
			<td data-cat="meal"><img src="/img/icon-meal.svg" alt="" />MEAL</td>
			<td data-cat="snack"><img src="/img/icon-snack.svg" alt="" />SNACK</td>
			<td data-cat="drink"><img src="/img/icon-drink.svg" alt="" />Drink</td>
		</tr>
	</table>

	<?php
	$last_cat = '';
	foreach($this->fave_foods as $row) {
		
		// close if not the first block
		if ($last_cat !== '' && $last_cat !== $row->category) {
			echo '</ul>';
		}

		if ($last_cat !== $row->category) {
			echo '<ul class="plain thin foods-list list-'.$row->category.' hide"><li class="tiny add-food food-button">+ add</li>';
		}
		
		echo '<li data-foodid="'.$row->id.'" class="food-button action-eat">'.htmlentities($row->name).'</li><a href="'.URL.'eat/delete_food/'.$row->id.'" class="trash">x</a>';
		$last_cat = $row->category;
	}
	?>
	</ul>
	
	<form id="add_food" name="add_food" method="post" class="hide align-center add-form" action="<?=URL?>eat/add_food">
		<input type="hidden" name="food_category" id="add_food_category" />
		<p><input type="text" name="food_name" id="food_name" placeholder="food name" size="20" /></p>
		<p><input type="text" name="food_calories" id="food_calories" placeholder="calories" size="6" /></p>
		<p><button onclick="$('#add_food').submit()">save</button></p>
	</form>

</div>
	

	
	
	
	<div class="box nosidepad" id="mood">
	<h2>Moods</h2>	
		<div id="new_mood">
			<form id="add_mood" name="add_mood" method="post" action="<?=URL?>eat/add_mood">
				<input type="hidden" id="mood_feeling" name="mood_feeling" value="3" />
				<p class="icons"><img src="/img/5.svg" alt="5" /> <img src="/img/4.svg" alt="4" /> <img src="/img/3.svg" alt="3" /> <img src="/img/2.svg" alt="2" /> <img src="/img/1.svg" alt="1" /></p>
				<div class="hide toggle">
					<p><textarea name="mood_note" class="cmsTextarea"></textarea></p>
					<p class="centered"><button onclick="$('#add_mood').submit()">add</button></p>
				</div>
			</form>
		</div>
	</div>


<div class="box recently bg-white" id="moods">

<?php
$month = date('m');
$year = date('Y');

// build array of feelings this year
// [todo] make part of user area, globally accessible
$feelings = array();
$moods = $this->feelings_year;
foreach ($moods as $mood) {
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

    $calendar = '<h2><span class="month">'.$monthName.'</span></h2>';
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

<div class="feelings">
<?php
	echo build_calendar($month,$year,$feelings);
?>

	<table class="log hide">
	<?php
		$moods = $this->moods_this_month;
		$last_day='';
		$last_time='';
		foreach ($moods as $mood) {
			// hide linear dupes of dates/times
			$simple_date = '';
			if ($last_day == $mood->day) {
				$simple_date = ' class="linear_dupe"';
			}
			$dupe_time = '';
			if ($last_time == $mood->human_time) {
				$dupe_time = 'linear_dupe';
			}
			?>
			<tr class="feeling_<?=$mood->feeling?>">
				<td class="nowrap tiny align-left">
					<span<?=$simple_date?>><?=$mood->human_day?></span>
					<span class="lite block <?=$dupe_time?>"><?=strtolower($mood->human_time)?></span>
				</td>
				<td class="align-left"><?=$mood->note?><a href="<?=URL?>eat/delete_mood_log/<?=$mood->id?>" class="trash">x</a></td>
				<td><img src="/img/<?=$mood->feeling?>.svg" alt="<?=$mood->feeling?>" /></td>
			</tr>
			<?php
			$last_day = $mood->day;
			$last_time = $mood->human_time;
		}
	?>
	</table>
</div>

</div>

<script>
$(document).ready(function(){

	$(".feelings").click(function () { 
		$('.log', this).fadeToggle();
	});

	$(".add-food").click(function () {
		$('.eat-it').toggleClass('hide');
		$('#add_food').toggleClass('hide');
		$('.foods-list').addClass('hide');
	});

	$(".foods-cat").click(function () { 
		$(this).next('.foods-list').fadeToggle();
	});

	$(".icons").click(function () { 
		$('#mood .toggle').fadeIn();
	});

	$("#today-circle").click(function () { 
		$('.box-calories').fadeToggle();
		$(this).toggleClass('active');
	});

	$("#mood .icons img").click(function () {
		$('#mood_feeling').attr('value', $(this).attr("alt") );
		$('#mood .icons img').css("opacity",".4");
		$(this).css("opacity","1");
		$("#mood .icons img").removeClass("selected");
		$(this).toggleClass("selected");
	});

	// eat_it
	$(".action-eat").click(function () {
		id = $(this).data("foodid");
		$('#eats_foods_id').val( id );
		$('#eat_it').submit();
	});

	$(".eat-it td").click(function () { 
		var cat = $(this).data('cat');
		$('#add_food_category').val(cat);
		$('#food_name').attr('placeholder', cat+' name');
		if ($(this).hasClass('selected')) {
			$('#plus-food').addClass('hide');
		} else {
			$(".eat-it td").removeClass('selected');
			$(".foods-list").addClass('hide');
			$('#plus-food').removeClass('hide');
		}
		$(this).toggleClass('selected');
		$('.list-'+cat).toggleClass('hide');
	});

});
</script>