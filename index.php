<?php

require_once('settings.php');

?>
<html>
<head>
<style type="text/css">

#login-button {
	display: block;
	text-align: center;
	margin: 100px 0;
}


#information-container {
	width: 500px;
	height: 300px;
	margin: 100px auto;
	padding: 20px;
	border: 1px solid #cccccc;
}

</style>
</head>

<body>
<h3 align="center">
	User Management system
</h3>
<div id="information-container">

<a id="login-button" href="<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>"><img src="images/sign-in-with-google.png"></a>
</div>
</body>
</html>