<html>
<head>
	<title>403 Forbidden</title>
</head>
<body>

<p>Someone just requested that the password be reset on your "Forget Your Resume" website.</p>

<p>If this was not you, we recommend that you login to your website and change your email.</p>

<p>If you did request your password be changed, then reset your password by visiting this URL by clicking it or copying it into your browser.</p> 

<p>
	<?php
		$url = base_url() . 'login/reset_password/' . $hash;

		echo '<p stlye="text-align: center;"><a href="' . $url . '">' . $url . '</p>';
	?>
</p>

</body>
</html>