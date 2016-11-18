<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Tumblr Book</title>

  <link rel="stylesheet" href="pages.css">
</head>
<body>
	<h1><a href="index.php">TumblrBook<a></h1>
	<h3>Turn any Tumblr blog into a printable book</h3>
	<div id="main" class="container">
	<?php
	session_start();
	if(isset($_GET['user'])){
		$user = $_GET['user'];
	}else if(isset($_SESSION['username'])){
		$user = $_SESSION['username'];
	}else{
		echo '<div>You must be logged in to view your library</div>';
	}
	if(isset($user)){
		echo '<h2>'.$user.'\'s Library</h2>';
		
		require('db.php');
		try {

			$pdo = db_connect();

			$sql = 'SELECT b.blogname, b.updated FROM blogs b, userblogs ub WHERE ub.username=:username AND ub.blogname=b.blogname ORDER BY b.updated DESC;';

			$q = $pdo->prepare($sql);

			$q->execute([':username' => $user]);

			$blogs = $q->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($blogs) === 0){
				echo '<div>'.$user.'\'s library is empty.</div>';
			}else{
				foreach($blogs as $blog){
					echo '<div class="library-entry"><a href="tumblr-book.php?blog='.$blog['blogname'].'"><img src="https://api.tumblr.com/v2/blog/'.$blog['blogname'].'.tumblr.com/avatar" /><br/>'.$blog['blogname'].'</a><br/><span class="updated">(Last Updated on '.$blog['updated'].')</span></div>';
				}
			}

		}catch(PDOException $e){
			die("Could not connect to the database $dbname : " . $e->getMessage() );
		}
		
	}
	?>
	</div>
	<div id="login" class="container">
		<?php
		if(isset($_SESSION['username'])){
			echo 'Logged in as ' . $_SESSION['username'];
			echo ' | <a href="logout.php">Logout</a>';
		}else{
			echo '<a href="login.php">Login</a> | <a href="signup.php">Sign Up</a>';
		}
		?>
	</div>
</body>
</html>