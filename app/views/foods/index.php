<?php if (!isset($this->total_foods[0])) { ?>

<div class="box">
	<h2>Foods</h2>
	<div class="box bg-white align-center">
		<h3>Nothing here yet.</h3>
		Go eat and track what you're eating over time.
	</div>
</div>

<?php } else { ?>

<div class="mbox calories moods_totals">
	<h2>Foods</h2>
	<p class="centered"><img src="/img/water.svg" class="water" alt="water" /> <span class="tiny"><?=$this->total_waters?></p>
	
	<ul class="chartlist">
	<?php
		foreach ($this->total_foods as $food) {
			$max = $this->total_foods[0]->eaten;
			$percent = round(($food->eaten / $max) * 100);
			?>
			<li class="category category_<?=$food->category?>" data-category="<?=$food->category?>">
			<a href="#"><?=$food->category?></a>
			<span class="count"><?=$food->eaten?></span>
			<span class="index" style="width: <?=$percent?>%">(<?=$percent?>%)</span>
			<?php
		}
		?>
	</ul>
	<br class="clear" />
</div>
<div class="mbox calories" id="eaten">	
	<ul class="chartlist">
	<?php
		foreach ($this->total_eaten as $food) {
			$max = $this->total_eaten[0]->eaten;
			$percent = round(($food->eaten / $max) * 100);
			?>
			<li class="food category_<?=$food->category?>">
			<a href="#"><?=$food->name?></a>
			<span class="count"><?=$food->eaten?></span>
			<span class="index" style="width: <?=$percent?>%">(<?=$percent?>%)</span>
			<?php
		}
		?>
	</ul>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('.moods_totals li').click(function() {
		var cat = $(this).data("category");
		$('li.food, li.category').removeClass('op20');
		$('li.food, li.category').not('.category_'+cat).addClass('op20');
		return false;
	});
});
</script>


<?php } ?>