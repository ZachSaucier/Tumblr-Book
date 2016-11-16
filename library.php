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

			$sql = 'SELECT b.blogname, b.updated FROM blogs b, userblogs ub WHERE ub.username=:username AND ub.blogname=b.blogname;';

			$q = $pdo->prepare($sql);

			$q->execute([':username' => $user]);

			$blogs = $q->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($blogs) === 0){
				echo '<div>'.$user.'\'s library is empty.</div>';
			}else{
				echo '<ul>';
				foreach($blogs as $blog){
					echo '<li><a href="tumblr-book.php?blog='.$blog['blogname'].'">'.$blog['blogname'].'</a> (Last Updated on '.$blog['updated'].')</li>';
				}
				echo '</ul>';
			}

		}catch(PDOException $e){
			die("Could not connect to the database $dbname : " . $e->getMessage() );
		}
		
	}
	?>
</body>
</html>