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
	$my_library = False;
	if(isset($_GET['user'])){
		$user = $_GET['user'];
		if(isset($_SESSION['username']) && $user === $_SESSION['username']){
			$my_library = True;
		}
	}else if(isset($_SESSION['username'])){
		$user = $_SESSION['username'];
		$my_library = True;
	}else{
		echo '<div>You must be logged in to view your library</div>';
	}
	if(isset($user)){
		if($my_library){
			echo '<h2>Your Library</h2>';
		}else{
			echo '<h2>'.$user.'\'s Library</h2>';
		}
		
		require('db.php');
		try {

			$pdo = db_connect();

			$sql = 'SELECT b.blogname, b.updated FROM blogs b, userblogs ub WHERE ub.username=:username AND ub.blogname=b.blogname';

			$q = $pdo->prepare($sql);

			$q->execute([':username' => $user]);

			$blogs = $q->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($blogs) === 0){
				echo '<div>'.$user.'\'s library is empty.</div>';
			}else{
				foreach($blogs as $blog){
					
					$sql = 'SELECT username FROM userblogs WHERE blogname=:blogname;';

					$q = $pdo->prepare($sql);

					$q->execute([':blogname' => $blog['blogname']]);

					$users = $q->fetchAll(PDO::FETCH_ASSOC);
					
					for($i = 0; $i < count($users); $i++){
						if($users[$i]['username'] === $user){
							unset($users[$i]);
						}
					}
					
					echo '<div class="library-entry"><a href="tumblr-book.php?blog='.$blog['blogname'].'&cached=true">';
					echo '<img src="https://api.tumblr.com/v2/blog/'.$blog['blogname'].'.tumblr.com/avatar" />';
					echo '<div class="blogname">'.$blog['blogname'].'</div></a>';
					echo '<div class="more">';
					echo '<div class="info"><div>Last Updated on '.$blog['updated'].'</div>';
					echo '<a href="tumblr-book.php?blog='.$blog['blogname'].'">Get Latest Version</a></div>';
					if(count($users) !== 0){
						echo '<div class="info"><div>Other Users Who Saved this Blog</div><ul>';
						foreach($users as $other_user){
							echo '<li><a href="library.php?user='.$other_user['username'].'">'.$other_user['username'].'</a></li>';
						}
						echo '</ul></div>';
					}
					echo '</div><div class="slide-control">More Info</div>';
					if($my_library){
						echo '<div class="library-remove">x</div>';
					}
					echo '</div>';
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
			echo ' | <a href="library.php">My Library</a>';
			echo ' | <a href="logout.php">Logout</a>';
		}else{
			echo '<a href="login.php">Login</a> | <a href="signup.php">Sign Up</a>';
		}
		?>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="library.js"></script>
</body>
</html>