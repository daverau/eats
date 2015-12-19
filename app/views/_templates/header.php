<?php
//global $current_user;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>eats &mdash; food &amp; mood journal</title>
	<link rel="stylesheet" type="text/css" media="screen" href="/app/public/css/eats.css" />

	<link id="page_favicon" href="/favicon.ico" rel="icon" type="image/x-icon" />

	<meta name="viewport" id="vp" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" />
	<meta name="viewport" id="vp" content="initial-scale=1.0,user-scalable=no,maximum-scale=1" media="(device-height: 568px)" /> 

	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />

	<script type="text/javascript" src="<?=URL?>public/js/jquery.js"></script>
	<script type="text/javascript" src="<?=URL?>public/js/custom.js"></script>
	<script type="text/javascript" src="<?=URL?>public/js/fastclick.js"></script>
	<script>
	window.addEventListener('load', function() {
	    FastClick.attach(document.body);
	}, false);
	</script>

	<script type="text/javascript" src="//use.typekit.net/idj5mzc.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

	<script type="text/javascript">
	$(document).ready(function(){

		// links open inside same bookmarked window; for iphone bookmarked pages only
		var a=document.getElementsByTagName("a");
		for(var i=0;i<a.length;i++) {
		    a[i].onclick=function() {
		        window.location=this.getAttribute("href");
		        return false
		    }
		}
	
		$("h1").click(function () { 
			$('#nav').toggle();
			$('.trash, #signout').toggle();
		});

		$(".button-delete").click(function () {
			id = $(this).attr("data-id");
			where_from = $(this).attr("data-from");
			$('#the_id').val( id );
			$('#where_from').val( where_from );
			//console.log('deleting… id: '+id+ ' from: ' +where_from);
			$('#delete').submit();
		});

		$(".toggle-next").click(function () {
			$(this).toggleClass('selected');
			$(this).next().toggleClass('hide');
		});

	});
	</script>

</head>
<body>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-5536882-21', 'auto');
  ga('send', 'pageview');

</script>

	<header>
		<h1>eats <span class="tagline">food &amp; mood journal</span></h1>
        <?php if (Session::get('user_logged_in') == true) { ?>
		<div id="nav">
			<ul>
				<li><a href="<?=URL?>eat">eat</a></li>
				<li><a href="<?=URL?>foods">foods</a></li>
				<li><a href="<?=URL?>moods">moods</a></li>
			</ul>
		</div>
		<?php } ?>
	</header>
	
<div id="wrapper">

