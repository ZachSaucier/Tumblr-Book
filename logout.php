<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <link href="images/favicon.png" rel="icon">
  <title>Tumblr Book - Logout</title>
  <link rel="stylesheet" href="pages.css">
  <meta http-equiv="refresh" content="1; url=index.php" />
</head>
<body>
	<div class="heading-container">
		<h1><a href="index.php"><img class="icon" src="images/icon.png"/>tumblr book</a></h1>
		<h3>Turn any Tumblr blog into a printable book</h3>
	</div>
	<div id="main" class="shadow">
		<div class="container">
	<h2>Logout successful</h2>
	<div><a href="index.php">Home</a><div>
	</div>
	</div>
</body>
</html>