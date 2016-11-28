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
  <title>Tumblr Book</title>
  <link rel="stylesheet" href="pages.css">
  <meta http-equiv="refresh" content="1; url=index.php" />
</head>
<body>
	<h1><a href="index.php"><img class="icon" src="images/icon.png"/>TumblrBook</a></h1>
	<h3>Turn any Tumblr blog into a printable book</h3>
	<div id="main" class="container">
	<p>Logout successful</p>
	<div><a href="index.php">Back</a><div>
	</div>
</body>
</html>