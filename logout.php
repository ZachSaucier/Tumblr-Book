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
  <title>Tumblr Book</title>

  <link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>TumblrBook</h1>
	<p>Logout successful</p>
	<div><a href="index.php">Back</a><div>
</body>
</html>