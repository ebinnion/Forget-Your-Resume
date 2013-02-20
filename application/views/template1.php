<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">

	<title><?php echo $object[0]['name']; ?> | <?php echo $object[0]['tagline']; ?></title>

	<link rel="author" href="<?php echo base_url(); ?>humans.txt">
	<link rel="dns-prefetch" href="//ajax.googleapis.com">
	<?php 
		if( isset( $object[0]['headlinefont']) ) {
			echo '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' . $object[0]['headlinefont'] .'">';
		}
	?>

	<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css?v=1">

	<style type="text/css">
		<?php echo $object['styles']; ?>
	</style>
	
	<script src="<?php echo base_url(); ?>js/modernizr-2.6.2.min.js"></script>
</head>
<body>
	<div class="container content cf">
		<!--[if lt IE 7 ]><p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p><![endif]-->

		<header role="banner" class="cf">
			<hgroup class="pull-left cf">
				<h1 class="pull-left"><a href="<?php echo base_url(); ?>"><?php echo $object[0]['name']; ?></a></h1>
				<h2 class="pull-left" style="margin-left: 30px;"><?php echo $object[0]['tagline']; ?></h2>
			</hgroup>

			<div class="social-icons pull-right">
				
				<?php
					if ($object[0]['facebook']){
						echo '<a href="'. $object[0]['facebook'] .'" class="icon-facebook icon-large"></a>';
					}

					if ($object[0]['twitter']){
						echo '<a href="'. $object[0]['twitter'] .'" class="icon-twitter icon-large"></a>';
					}

					if ($object[0]['google']){
						echo '<a href="'. $object[0]['google'] .'" class="icon-google-plus icon-large"></a>';
					}

					if ($object[0]['pinterest']){
						echo '<a href="'. $object[0]['pinterest'] .'" class="icon-pinterest icon-large"></a>';
					}

					if ($object[0]['linkedin']){
						echo '<a href="'. $object[0]['linkedin'] .'" class="icon-linkedin icon-large"></a>';
					}

					if ($object[0]['github']){
						echo '<a href="'. $object[0]['github'] .'" class="icon-github icon-large"></a>';
					}
				?>
			</div>
		</header>

		<div class="main" role="main">
			<h2 style="margin: 0;">About Me</h2>

			<?php echo $object[0]['aboutme']; ?>

			<h2>My Resume</h2>

			<?php echo $object[0]['resume']; ?>

		</div> <!-- #main -->

		<aside role="complementary">
			<img src="
			<?php 
				if ( isset($object[0]['profileimg']) ){
					echo $object[0]['profileimg'];
				}
				else {
					echo 'http://dummyimage.com/320x400/efefef/000&text=Your+Image+Here';
				}
			?>
			">
		</aside>
	</div>

	<footer role="contentinfo">
		<div class="container cf">
			<p>&copy; Copyright <?php echo date('Y'); ?> <?php echo $object[0]['name']; ?>, All Rights Reserved.</p>
		</div>
	</footer>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.8.3.min.js"><\/script>')</script>
	<script src="<?php echo base_url(); ?>js/plugins.js"></script>
	<script src="<?php echo base_url(); ?>js/main.js"></script>
</body>
</html>