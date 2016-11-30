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
	<div class="heading-container">
		<h1><a href="index.php"><img class="icon" src="images/icon.png"/>tumblr book</a></h1>
		<h3>Turn any Tumblr blog into a printable book</h3>
	</div>
	
	<div id="main" class="shadow">
		<div class="container">
			<form action="tumblr-book.php" method="get">
				<div><label>Tumblr Username</label><br />
				<input type="text" name="blog" placeholder="humanity-and-nature" ></div>
				<label>Book Theme</label>
				<input type="hidden" name="theme" value="Default">
				<div id="theme" class="flex">
					<div class="selected"><img src="images/preview-default.png"><div>Default</div></div>
					<div><img src="images/preview-sky.png"><div>Sky</div></div>
					<div><img src="images/preview-corkboard.png"><div>Corkboard</div></div>
					<div><img src="images/preview-album.png"><div>Album</div></div>
				</div>
				<input type="submit" value="Create">
			</form>
		</div>
	</div>
	<div id="login" class="container shadow light">
		<?php
		session_start();
		if(isset($_SESSION['username'])){
			echo $_SESSION['username'];
			echo ' | <a href="library.php">My Library</a>';
			echo ' | <a href="logout.php">Logout</a>';
		}else{
			echo '<a href="login.php">Login</a> | <a href="signup.php">Sign Up</a>';
		}
		?>
	</div>
	<form id="search" class="shadow" action="library.php" method="get">
		<input type="text" name="user" placeholder="User Library Search">
	</form>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="preview.js"></script>
</body>
</html>