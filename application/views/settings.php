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

	<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css?v=1">

	<link rel="stylesheet" href="<?php echo base_url(); ?>css/colorpicker/jquery.minicolors.css" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.ui.fontSelector.css" type="text/css" rel="stylesheet" />

	<?php 
		if( isset( $object[0]['headlinefont']) ) {
			echo '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' . $object[0]['headlinefont'] .'">';
		}
	?>

	<style type="text/css">
		<?php echo $object['styles']; ?>
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
					if ( isset ($object['social_icons']) ){
						foreach( $object['social_icons'] as $icon) {
							echo $icon;
						}
					}
				?>
			</div>
		</header>

		<div class="main" role="main">
			<a href="<?php echo base_url(); ?>login/logout">Logout</a> | <a href="<?php echo base_url(); ?>settings/password">Update Login Information</a>
			
				<?php 
					$attributes = array('id' => 'settings');
					echo form_open_multipart('settings/process', $attributes); 
				?>
					<ul class="tabs">
						<li class='tab'><a href="#tabs1">About You</a></li>
						<li class='tab'><a href="#tabs2">Colors</a></li>
						<li class='tab'><a href="#tabs3">Images</a></li>
						<li class='tab'><a href="#tabs4">Social</a></li>
						<li class='tab'><a href="#tabs5">Target Company</a></li>
						<li class='tab'><a href="#tabs6">Other</a></li>
					</ul>

					<div id="tabs1">
						<p><label>What's Your Name?</label></p>
						<p><input name="name" type="text" class="input_full" value="<?php echo $object[0]['name']; ?>"></p>
						<p><label>Describe Yourself in 10 Words or Less</label></p>
						<p><input name="tagline" type="text" class="input_full" value="<?php echo $object[0]['tagline']; ?>"></p>
						<p><label>Describe Yourself</label></p>
						<p><textarea name ="aboutme" rows="10" cols="10" class="texteditor" style="background: #fff!important;"><?php echo $object[0]['aboutme']; ?></textarea></p>

						<h3>Your Resume</h3>
						<p>Use the text editor below to create your resume. I recommend using the headline tags (h3,h4,h5) to separate your content.</p>
						<p><label>Your Resume</label></p>
						<p><textarea name ="resume" rows="10" cols="10" class="texteditor" style="background: #fff!important;"><?php echo $object[0]['resume']; ?></textarea></p>

					</div>

					<div id="tabs2">
						<div class="cf">
							<p><label style="margin-right: 10px;">Content Background:</label><input class="minicolors minicolors-input opacity" type="text" name="contentbg" value="<?php echo $object[0]['contentbg']; ?>" data-selector=".content" data-selecttype="background">
									<label style="margin: 0 10px;">Invisible?</label><input type="checkbox" name="contentbgvis" value="Yes" <?php if($object[0]['contentbgvis'] == 'Yes'){ echo 'checked="checked"';} ?> ></p>
							<p><label style="margin-right: 10px;">Footer Background:</label><input class="minicolors minicolors-input opacity" type="text" name="footerbg" value="<?php echo $object[0]['footerbg']; ?>" data-selector="footer" data-selecttype="background"></p>
							<p><label style="margin-right: 10px;">Image Border:</label><input class="minicolors minicolors-input opacity" type="text" name="imgborder" value="<?php echo $object[0]['imgbordercolor']; ?>" data-selector='[role="complementary"] img' data-selecttype="border-color"></p>
							<p><label style="margin-right: 10px;">Font Color:</label><input class="minicolors minicolors-input opacity" type="text" name="fontcolor" value="<?php echo $object[0]['fontcolor']; ?>" data-selector="body" data-selecttype="color"></p>
							<p><label style="margin-right: 10px;">Name Color:</label><input class="minicolors minicolors-input opacity" type="text" name="headercolor" value="<?php echo $object[0]['headercolor']; ?>" data-selector='[role="banner"] h1 a' data-selecttype="color"></p>
							<p><label style="margin-right: 10px;">Tagline Color:</label><input class="minicolors minicolors-input opacity" type="text" name="taglinecolor" value="<?php echo $object[0]['taglinecolor']; ?>" data-selector='[role="banner"] h2' data-selecttype="color"></p>
							<p><label style="margin-right: 10px;">Link Color:</label><input class="minicolors minicolors-input opacity" type="text" name="linkcolor" value="<?php echo $object[0]['linkcolor']; ?>" data-selector='[role="main"] a' data-selecttype="color"></p>
							<p><label style="margin-right: 10px;">Link Hover Color:</label><input class="minicolors minicolors-input opacity" type="text" name="linkhovercolor" value="<?php echo $object[0]['linkhovercolor']; ?>"data-selector='[role="main"] a:hover' data-selecttype="color"></p>
						</div>
					</div>

					<div id="tabs3">
						<p>Here, you have the ability to select a background image and a profile image for your page. Please note that the profile image
						will not appear until you submit the form.</p>
						<p><label>Profile Image</label></p>
						<p><input type="file" name="userfile" /></p>
						<input type="hidden" name="profileimgval" value="<?php echo $object[0]['profileimg']; ?>">
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
						<div class="cf" id="bgselector">

						</div>
					</div>

					<div id="tabs4">
						<p>Put the full URL to your profiles below.</p>
						<p><label>Facebook: </label><input type="text" name="facebook" class="input_xlarge" value="<?php echo $object[0]['facebook']; ?>"></p>
						<p><label>Twitter: </label><input type="text" name="twitter" class="input_xlarge" value="<?php echo $object[0]['twitter']; ?>"></p>
						<p><label>Google: </label><input type="text" name="google" class="input_xlarge" value="<?php echo $object[0]['google']; ?>"></p>
						<p><label>Pinterest: </label><input type="text" name="pinterest" class="input_xlarge" value="<?php echo $object[0]['pinterest']; ?>"></p>
						<p><label>LinkedIn: </label><input type="text" name="linkedin" class="input_xlarge" value="<?php echo $object[0]['linkedin']; ?>"></p>
						<p><label>Github: </label><input type="text" name="github" class="input_xlarge" value="<?php echo $object[0]['github']; ?>"></p>
					</div>

					<div id="tabs5">
						<?php 
							if ( isset($object[0]['employers']) ){
								$employerList = explode(';', $object[0]['employers']);
							}

							if ( isset($object[0]['employerMessage']) ){
								$employerMsgList = explode(';', $object[0]['employerMessage']);
							}

							$i = 0;
							while ($i < count($employerList) - 1){
								$companySlug = preg_replace("/[\s_]/", "-", strtolower($employerList[$i]));
								echo '<div class="cf">';
								echo '<a href="#" class="icon-remove-circle removeCompany pull-right">  Delete</a>';
								echo '<p style="margin-top: 0;"><label>Enter Company Name</label><br><input class="companyName" type="text" value="' . $employerList[$i] . '"></p>';
								echo '<p><label>Enter Message to Company</label><br><textarea rows="10" class="companyMsg">' . $employerMsgList[$i] . '</textarea></p>';
								echo '<p><label>Company URL</label><br><input class="input_full" type="text" value="' . base_url() . 'main/company/' . $companySlug . '" readonly></p>';
								echo '</div>';
								echo '<hr>';
								$i++;
							}
						?>

						<a href="#" class="icon-plus-sign add-employer">  Add Target Company</a>
						<input type="hidden" name="companyNames">
						<input type="hidden" name="companyMsgs">
					</div>

					<div id="tabs6" style="min-height: 300px;">
						<p><label>Name Font</label></p>
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

						<p><label>Google Analytics ID</label></p>
						<p><input type="text" name="googleAnalytics" class="input_xlarge" value="<?php echo $object[0]['googleAnalyticsId']; ?>"></p>
					</div>
					<p style="text-align: center"><input type="submit" class="green"></p>
				</form>
		</div> <!-- #main -->

		<aside role="complementary">
			<img src="
			<?php 
				if ( !isset($object[0]['profileimg']) || $object[0]['profileimg'] == '' || $object[0]['profileimg'] == ' '){
					echo 'http://dummyimage.com/320x400/efefef/000&text=Your+Image+Here';
				}
				else {
					echo $object[0]['profileimg'];
				}
			?>
			">
			
			<div class="optin hide">
				<hr>
				<h3 style="text-align: center;">Sign Up Now for Forget Your Resume Updates!</h3>
				<p>When you sign up for updates, you'll get exlusive access to advice for getting a dream job.</p>
				<p>You will receive <em>infrequent</em> emails from us. We don't like spam either!</p>
				<form action="https://app.getresponse.com/add_contact_webform.html" method="post">
				<div style="text-align: center;">
					<p><input class="name" tabindex="600" onfocus="if (this.value == 'Enter your name') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Enter your name';}" type="text" name="name" value="Enter your name" size="25"></p>
					<p><input class="email" tabindex="601" onfocus="if (this.value == 'Enter your email') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Enter your email';}" type="text" name="email" value="Enter your email" size="25"></p>
					<p><input type="hidden" name="webform_id" value="357026">
						<input tabindex="602" type="submit" name="submit" value="Signup Now!"></p>
				</div>
				</form>
				<p id="hideOpt" style="color: #999; font-size: 10px; text-align: center; cursor: pointer; margin-top: 30px;">X - Please do not show me this again.</p>
			</div>
		</aside>
	</div>

	<footer role="contentinfo">
		<div class="container cf">
			<p>&copy; Copyright <?php echo date('Y'); ?> <?php echo $object[0]['name']; ?>, All Rights Reserved.</p>
		</div>
	</footer>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.8.3.min.js"><\/script>')</script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>  


	<script type="text/javascript" src="<?php echo base_url(); ?>tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/colorpicker/jquery.minicolors.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/fontSelector/jquery.ui.fontSelector.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.cookie.js"></script>

	<script src="<?php echo base_url(); ?>js/plugins.js"></script>
	<script src="<?php echo base_url(); ?>js/main.js"></script>
	<script src="<?php echo base_url(); ?>js/admin.js"></script>
</body>
</html>