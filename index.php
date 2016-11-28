<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <link href="images/favicon.png" rel="icon">
  <title>Tumblr Book</title>

  <link rel="stylesheet" href="pages.css">
</head>
<body>
	<h1><a href="index.php"><img class="icon" src="images/icon.png"/>TumblrBook</a></h1>
	<h3>Turn any Tumblr blog into a printable book</h3>
	<div id="main" class="container">
		<form action="tumblr-book.php" method="get">
			<div><label>Tumblr Username</label><br />
			<input type="text" name="blog" placeholder="solacingsavant" ></div>
			<div><label>Book Theme</label><br />
			<select name="theme">
				<option value="style">Default</option>
				<option>Sky</option>
				<option>Album</option>
				<option>Corkboard</option>
			</select>
			</div>
			<input type="submit" value="Create">
		</form>
	</div>
	<div id="login" class="container">
		<?php
		session_start();
		if(isset($_SESSION['username'])){
			echo 'Logged in as ' . $_SESSION['username'];
			echo ' | <a href="library.php">My Library</a>';
			echo ' | <a href="logout.php">Logout</a>';
		}else{
			echo '<a href="login.php">Login</a> | <a href="signup.php">Sign Up</a>';
		}
		?>
	</div>
</body>
</html>