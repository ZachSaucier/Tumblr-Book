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
		
		$sql = 'SELECT * FROM users u WHERE u.username="'.$_POST['username'].'";';
		
		$q = $pdo->query($sql);
		
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
	<h1>TumblrBook</h1>
	<h2>Login</h2>
	<?php
	if(isset($invalid) && $invalid === True){
		echo '<div class="error">Invalid username or password</div>';
	}
	?>
	<form action="login.php" method="post">
		<div><label>Username: <input type="text" name="username" size="24"></label></div>
		<div><label>Password: <input type="password" name="password" size="24"></label></div>
		<input type="submit" value="Submit">
	</form>
</body>
</html>