<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <link href="images/favicon.png" rel="icon">
  <title>Tumblr Book - Login</title>

  <link rel="stylesheet" href="pages.css">
  
  <?php
  if(isset($_POST['username']) && isset($_POST['password'])){
	 require('db.php');
	 try {
		
		$pdo = db_connect();
		
		$sql = 'SELECT * FROM users WHERE username=:username;';
		
		$q = $pdo->prepare($sql);
		
		$q->execute([':username' => $_POST['username']]);
		
		$user = $q->fetch(PDO::FETCH_ASSOC);
		
		if($user){
			if($user['password'] === $_POST['password']){
				session_start();
				$_SESSION['username'] = $_POST['username'];
				echo '<meta http-equiv="refresh" content="0; url=index.php" />';
			}else{
				$invalid = True;
			}
		}else{
			$invalid = True;
		}
		
	}catch(PDOException $e){
		die("Could not connect to the database $dbname : " . $e->getMessage() );
	}
  }
  ?>
  
</head>
<body>
	<div class="heading-container">
		<h1><a href="index.php"><img class="icon" src="images/icon.png"/>tumblr book</a></h1>
		<h3>Turn any Tumblr blog into a printable book</h3>
	</div>
	<div id="main" class="shadow">
		<div class="container">
		<?php
		if(isset($invalid) && $invalid === True){
			echo '<div class="error">Invalid username or password</div>';
		}
		?>
		<form action="login.php" method="post">
			<div><label>Username<br /><input type="text" name="username" size="24"></label></div>
			<div><label>Password<br /><input type="password" name="password" size="24"></label></div>
			<input type="submit" value="Login">
		</form>
		</div>
	</div>
	<div id="login" class="container shadow light">
		<?php
			echo '<a href="signup.php">Sign Up Instead</a>';
		?>
	</div>
	<form id="search" class="shadow" action="library.php" method="get">
		<input type="text" name="user" placeholder="User Library Search">
	</form>
</body>
</html>