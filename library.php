<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Tumblr Book</title>

  <link rel="stylesheet" href="pages.css">
</head>
<body>
	<h1><a href="index.php">TumblrBook</a></h1>
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
			echo '<h2 id="library-name">Your Library</h2>';
		}else{
			echo '<h2 id="library-name">'.$user.'\'s Library</h2>';
		}
		
		require('db.php');
		try {

			$pdo = db_connect();
			
			$sql = 'SELECT libraryheader FROM users WHERE username=:username';

			$q = $pdo->prepare($sql);

			$q->execute([':username' => $user]);

			$result = $q->fetch(PDO::FETCH_ASSOC);
			$header = $result['libraryheader'];
			
			echo '<div id="header">'.$header.'</div>';
			if($my_library){
				echo '<div id="edit-header">';
				echo '<textarea id="header-changes" placeholder="Add a description to your library!">'.$header.'</textarea>';
				echo '<button id="save">Save</button><button id="cancel">Cancel</button></div>';
				echo '<div id="open-edit" class="clickable-text">Edit Description</div>';
			}
			
			$sql = 'SELECT b.blogname, b.updated, ub.theme FROM blogs b, userblogs ub WHERE ub.username=:username AND ub.blogname=b.blogname';

			$q = $pdo->prepare($sql);

			$q->execute([':username' => $user]);

			$blogs = $q->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($blogs) === 0){
				if((isset($header) && $header !== '')|| $my_library){
					echo '<br />';
				}
				echo '<div>'.$user.'\'s library is empty.</div>';
			}else{
				echo '<div id="blogs">';
				
				if(!$my_library && isset($_SESSION['username'])){
					
					$sql = 'SELECT b.blogname, b.updated, ub.theme FROM blogs b, userblogs ub WHERE ub.username=:username AND ub.blogname=b.blogname';

					$q = $pdo->prepare($sql);

					$q->execute([':username' => $_SESSION['username']]);

					$my_blogs = $q->fetchAll(PDO::FETCH_ASSOC);
					
				}
				
				foreach($blogs as $blog){
					
					$sql = 'SELECT username FROM userblogs WHERE blogname=:blogname AND username!=:username';

					$q = $pdo->prepare($sql);

					$q->execute([':blogname' => $blog['blogname'], ':username' => $user]);

					$users = $q->fetchAll(PDO::FETCH_ASSOC);
					
					if(isset($_SESSION['username'])){
						for($i = 0; $i < count($users); $i++){
							if($users[$i]['username'] === $_SESSION['username']){
								unset($users[$i]);
								break;
							}
						}
					}
					
					echo '<div class="library-entry"><a href="tumblr-book.php?blog='.$blog['blogname'].'&theme='.$blog['theme'].'&cached=true">';
					echo '<img src="https://api.tumblr.com/v2/blog/'.$blog['blogname'].'.tumblr.com/avatar" />';
					echo '<div class="blogname">'.$blog['blogname'].'</div></a>';
					
					if(isset($my_blogs)){
						echo '<div class="library-add">';
						$shared = False;
						for($i = 0; $i < count($my_blogs); $i++){
							if($my_blogs[$i]['blogname'] === $blog['blogname']){
								$shared = True;
								echo 'In your Library';
							}
						}
						if(!$shared){
							echo 'Add to Library';
						}
						echo '</div>';
					}
					
					echo '<div class="more">';
					echo '<div class="info">Selected Theme: <span class="theme">'.$blog['theme'].'</span></div>';
					echo '<div class="info"><div>Last Updated on '.$blog['updated'].'</div>';
					echo '<a href="tumblr-book.php?blog='.$blog['blogname'].'&theme='.$blog['theme'].'">Get Latest Version</a></div>';
					if(count($users) !== 0){
						echo '<div class="info"><div>Other Users Who Saved this Blog</div><ul>';
						foreach($users as $other_user){
							echo '<li><a href="library.php?user='.$other_user['username'].'">'.$other_user['username'].'</a></li>';
						}
						echo '</ul></div>';
					}
					echo '</div><div class="slide-control clickable-text">More Info</div>';
					if($my_library){
						echo '<div class="library-remove">x</div>';
					}
					echo '</div>';
				}
				echo '</div>';
			}
				
			echo '<h2>Comments</h2>';
			echo '<div id="comments">';
			
			$sql = 'SELECT username, created, content FROM librarycomments WHERE library=:username ORDER BY id';

			$q = $pdo->prepare($sql);

			$q->execute([':username' => $user]);

			$comments = $q->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($comments as $comment){
				echo '<div class="comment"><div><a href="library.php?user='.$comment['username'].'">'.$comment['username'].'</a> <span class="comment-date">'.$comment['created'].'</span></div><div>'.$comment['content'].'</div></div>';	
			}
			echo '</div>';
			if(!$my_library && isset($_SESSION['username'])){
				echo '<textarea id="new-comment" placeholder="Leave a comment on '.$user.'\'s library..."></textarea>';
				echo '<button id="post-comment">Post Comment</button>';
			}
			
			echo '<h2>Similar Libraries</h2>';
			
			$sql = 'SELECT username, COUNT(blogname) AS shared FROM userblogs WHERE username!=:username AND blogname IN (SELECT blogname FROM userblogs WHERE username=:username) GROUP BY username ORDER BY shared DESC';

			$q = $pdo->prepare($sql);

			$q->execute([':username' => $user]);

			$libraries = $q->fetchAll(PDO::FETCH_ASSOC);
			
			for($i = 0; $i < 4 && $i < count($libraries); $i++){
				$library = $libraries[$i];
				if($library['shared'] != 0){
					echo '<div class="similar-library"><div><a href="library.php?user='.$library['username'].'">'.$library['username'].'</a></div>';
					if($library['shared'] == 1){
						echo '<div class="comment-date">'.$library['shared'].' blog in common</span></div></div>';
					}else{
						echo '<div class="comment-date">'.$library['shared'].' blogs in common</span></div></div>';
					}
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
	<script>
		<?php
		if(isset($_SESSION['username'])){
			echo 'var username="'.$_SESSION['username'].'";';
		}
		if(isset($user)){
			echo 'var library="'.$user.'";';
		}
		if($my_library){
			echo 'var myLibrary = true;';
		}else{
			echo 'var myLibrary = false;';
		}
		?>
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="library.js"></script>
</body>
</html>