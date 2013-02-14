<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">

	<title></title>

	<link rel="author" href="<?php echo base_url(); ?>humans.txt">
	<link rel="dns-prefetch" href="//ajax.googleapis.com">
	<?php 
		if( isset( $object[0]['headlinefont']) ) {
			echo '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' . $object[0]['headlinefont'] .'">';
		}
	?>

	<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css?v=1">
	<link rel="Stylesheet" href="<?php echo base_url(); ?>css/jHtmlArea.css" />
	<link rel="stylesheet" href='<?php echo base_url(); ?>css/spectrum.css' />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/sh-image-select.all.css" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.ui.fontSelector.css" type="text/css" rel="stylesheet" />

	<style type="text/css">
		<?php echo $styles; ?>
	</style>

	<script src="<?php echo base_url(); ?>js/modernizr-2.6.2.min.js"></script>
</head>
<body>
	<div class="container cf content">
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
			<h2 style="margin: 0;">Settings</h2>

			<?php 
				$attributes = array('id' => 'settings');
				echo form_open('settings/process', $attributes); 
			?>
				
				<h3>Admin</h3>
				<a href="<?php echo base_url(); ?>login/logout">Logout</a> | <a href="<?php echo base_url(); ?>settings/password">Update Login Information</a>
				<h3>Who Are You?</h3>
				<p><label>What's Your Name?</label></p>
				<p><input name="name" type="text" class="input_full" value="<?php echo $object[0]['name']; ?>"></p>
				<p><label>Describe Yourself in 10 Words or Less</label></p>
				<p><input name="tagline" type="text" class="input_full" value="<?php echo $object[0]['tagline']; ?>"></p>
				<p><label>Describe Yourself</label></p>
				<p><textarea name ="aboutme" rows="10" cols="10" class="texteditor" style="background: #fff!important;"><?php echo $object[0]['aboutme']; ?></textarea></p>

				<h3>Your Resume</h3>
				<p>Use the text editor below to create your resume. I recommend using the headline tags (h3,h4,h5) to
				<p><label>Your Resume</label></p>
				<p><textarea name ="resume" rows="10" cols="10" class="texteditor" style="background: #fff!important;"><?php echo $object[0]['resume']; ?></textarea></p>

				<h3>Colors</h3>
				<div class="cf">
					<p><label style="margin-right: 10px;">Page Background:</label><input class="show-color" type="color" name="bgcolor" value="<?php echo $object[0]['bgcolor']; ?>"></p>
					<p><label style="margin-right: 10px;">Content Background:</label><input class="show-color" type="color" name="contentbg" value="<?php echo $object[0]['contentbg']; ?>">
							<label style="margin: 0 10px;">Invisible?</label><input type="checkbox" name="contentbgvis" value="Yes" <?php if(isset($object[0]['contentbgvis'])){ echo 'checked="checked"';} ?> ></p>
					<p><label style="margin-right: 10px;">Footer Background:</label><input class="show-color" type="color" name="footerbg" value="<?php echo $object[0]['footerbg']; ?>"></p>
					<p><label style="margin-right: 10px;">Image Border:</label><input class="show-color" type="color" name="imgborder" value="<?php echo $object[0]['imgbordercolor']; ?>"></p>
					<p><label style="margin-right: 10px;">Font Color:</label><input class="show-color" type="color" name="fontcolor" value="<?php echo $object[0]['fontcolor']; ?>"></p>
					<p><label style="margin-right: 10px;">Name Color:</label><input class="show-color" type="color" name="headercolor" value="<?php echo $object[0]['headercolor']; ?>"></p>
					<p><label style="margin-right: 10px;">Tagline Color:</label><input class="show-color" type="color" name="taglinecolor" value="<?php echo $object[0]['taglinecolor']; ?>"></p>
					<p><label style="margin-right: 10px;">Link Color:</label><input class="show-color" type="color" name="linkcolor" value="<?php echo $object[0]['linkcolor']; ?>"></p>
					<p><label style="margin-right: 10px;">Link Hover Color:</label><input class="show-color" type="color" name="linkhovercolor" value="<?php echo $object[0]['linkhovercolor']; ?>"></p>
				</div>
				<h3>Images</h3>
				<p><label>Profile Image:</label><input type="text" name="profileimg" class="pull-right input_xxlarge" value="<?php echo $object[0]['profileimg']; ?>"/></p>
				<p>Copy and paste the url (including http://) of your image above. We recommend using a service such as <a href="http://photobucket.com">Photobucket</a> to host your image.</p>

				<p><label>Background Image</label></p>
				<div class="cf">
					<select multiple id="bgpattern" name="bgpattern">
						<?php
						
						foreach(glob('images/patterns/*') as $filename){
							$url = base_url() . 'images/patterns/'. basename($filename);
							$temp = '';
							if ( basename($filename) == $object[0]['bgpattern'] ){
								$temp = 'selected="selected"';
							}
							echo '<option data-image="'. $url . '"' . $temp . '">'.basename($filename).'</option>';
							
						}
						?>
					</select>
				</div>

				<h3>Font</h3>
				<p>Header Font</p>
				<select id="headfont" name="headfont">
					<?php 
						$fonts = array('Chelsea Market', 'Droid Serif', 'Ruluko', 'Ruda', 'Magra', 'Esteban', 'Lora', 'Jura');
						foreach ($fonts as $font ){
							$temp = '';
							if ($font == $object[0]['headlinefont']) {
								$temp = 'selected="selected"';
							}
							echo '<option value="' . $font .'"' . $temp .'>'. $font .'</option>';
						}
					?>
					
				</select>
				<h3>Social Links</h3>
				<p>Put the full URL to your profile below.</p>
				<p><label>Facebook: </label><input type="text" name="facebook" class="input_xlarge" value="<?php echo $object[0]['facebook']; ?>"></p>
				<p><label>Twitter: </label><input type="text" name="twitter" class="input_xlarge" value="<?php echo $object[0]['twitter']; ?>"></p>
				<p><label>Google: </label><input type="text" name="google" class="input_xlarge" value="<?php echo $object[0]['google']; ?>"></p>
				<p><label>Pinterest: </label><input type="text" name="pinterest" class="input_xlarge" value="<?php echo $object[0]['pinterest']; ?>"></p>
				<p><label>LinkedIn: </label><input type="text" name="linkedin" class="input_xlarge" value="<?php echo $object[0]['linkedin']; ?>"></p>
				<p><label>Github: </label><input type="text" name="github" class="input_xlarge" value="<?php echo $object[0]['github']; ?>"></p>

				<p><input type="submit"></p>
			</form>

		</div> <!-- #main -->

		<aside role="complementary">
			<img src="<?php echo $object[0]['profileimg'];?>">
		</aside>
	</div>

	<footer role="contentinfo">
		<div class="container cf">
			<p>&copy; Copyright <?php echo date('Y'); ?> <?php echo $object[0]['name']; ?>, All Rights Reserved.</p>
		</div>
	</footer>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.8.3.min.js"><\/script>')</script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>js/jHtmlArea-0.7.5.js"></script>
	<script src='<?php echo base_url(); ?>js/spectrum.js'></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.sh-image-select.all.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.fontSelector.min.js"></script>

	<script src="<?php echo base_url(); ?>js/plugins.js"></script>
	<script src="<?php echo base_url(); ?>js/main.js"></script>
	<script src="<?php echo base_url(); ?>js/admin.js"></script>
</body>
</html>