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
	<p>Turn any Tumblr blog into a printable book</p>
	<form action="tumblr-book.php" method="get">
		<div><label>Tumblr Username: <input type="text" name="blog" placeholder="solacingsavant" size="24"></label></div>
		<div>
		<label>Book Theme: </label>
		<select name="theme">
			<option>Default</option>
		</select>
		</div>
		<input type="submit" value="Submit">
	</form>
	<div>
<?php
session_start();
if(isset($_SESSION['username'])){
	echo 'Logged in as ' . $_SESSION['username'];
	echo '. <a href="logout.php">Logout</a>';
}else{
	echo '<a href="login.php">Login</a> | <a href="signup.php">Sign Up</a>';
}
?>
	</div>
</body>
</html>