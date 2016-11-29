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
		
		$sql = 'INSERT INTO users (username, password) VALUES (:username, :password);';
		
		$q = $pdo->prepare($sql);
		
		$success = $q->execute([':username' => $_POST['username'], ':password' => $_POST['password']]);
		
		if($success){
			session_start();
			$_SESSION['username'] = $_POST['username'];
			echo '<meta http-equiv="refresh" content="0; url=index.php" />';
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
			echo '<div class="error">Sign Up failed, username may be taken</div>';
		}
		?>
		<form action="signup.php" method="post">
			<div><label>Username<br /><input type="text" name="username" size="24"></label></div>
			<div><label>Password<br /><input type="text" name="password" size="24"></label></div>
			<input type="submit" value="Create Account">
		</form>
	</div>
	</div>
</body>
</html>