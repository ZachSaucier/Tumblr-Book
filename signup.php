<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Tumblr Book - Login</title>

  <link rel="stylesheet" href="style.css">
  
  <?php
  if(isset($_POST['username']) && isset($_POST['password'])){
	 require('db.php');
	 try {
		
		$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
		
		$sql = 'INSERT INTO users VALUES (:username, :password);';
		
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
	<h1>TumblrBook</h1>
	<h2>Sign Up</h2>
	<?php
	if(isset($invalid) && $invalid === True){
		echo '<div class="error">Sign Up failed, username may be taken</div>';
	}
	?>
	<form action="signup.php" method="post">
		<div><label>Username: <input type="text" name="username" size="24"></label></div>
		<div><label>Password: <input type="text" name="password" size="24"></label></div>
		<input type="submit" value="Submit">
	</form>
</body>
</html>