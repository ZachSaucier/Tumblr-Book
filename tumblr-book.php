<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <link href="images/favicon.png" rel="icon">
  <title>Tumblr Book - Create</title>

  <?php
  if(isset($_GET['theme']) && $_GET['theme'] !== ''){
	echo '<link rel="stylesheet" href="stylesheets/'.strtolower($_GET['theme']).'.css">';
  }else{
	echo '<link rel="stylesheet" href="stylesheets/style.css">';
  }
  ?>
</head>
<body>
  <?php
	if(isset($_GET['cached']) && strtolower($_GET['cached']) === 'true'){
		try {
			require('db.php');
			$pdo = db_connect();

			$sql = 'SELECT content FROM blogs WHERE blogname=:blogname;';

			$q = $pdo->prepare($sql);

			$q->execute([':blogname' => $_GET['blog']]);
			
			$blog = $q->fetch(PDO::FETCH_ASSOC);
			
			if($blog && $blog['content'] !== ''){
				echo '<div id="fromTumblr">';
				echo $blog['content'];
				echo '</div>';
				echo '<a id="home" href="index.php">Home</a>';
				echo '<button id="printButton">Print this Tumblr blog</button>';
				echo '<script>var printButton = document.getElementById("printButton");'
				.'var homeButton = document.getElementById("home");'
				.'printButton.onclick = function() {'
				.'printButton.style.display = "none";'
				.'homeButton.style.display = "none";'
				.'window.print();'
				.'printButton.style.display = "block";'
				.'homeButton.sytle.display = "inline"'
				.'};</script>';
			}else{
				$contentNotFound = True;
			}

		}catch(PDOException $e){
			die("Could not connect to the database $dbname : " . $e->getMessage() );
		}
	}
	if((isset($_GET['cached']) && strtolower($_GET['cached']) === 'true' && isset($contentNotFound)) || !isset($_GET['cached']) || strtolower($_GET['cached']) !== 'true'){
		echo '<!--HERE-->';
		echo '<script>';
		if(isset($_GET['blog']) && $_GET['blog'] !== ''){
			echo 'var siteURL = "https://' . $_GET['blog'] . '.tumblr.com/";';
			echo 'var blogname = "' . $_GET['blog'] . '";';
		}else{
			// default
			echo 'var siteURL = "https://humanity-and-nature.tumblr.com/";';
			echo 'var blogname = "humanity-and-nature";';
		}
		if(isset($_GET['theme']) && $_GET['theme'] !== ''){
			echo 'var theme = "' . $_GET['theme'] . '";';
		}else{
			echo 'var theme = "Default";';
		}
		echo '</script>';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>';
		echo '<script src="tumblr-book.js"></script>';
	}
  ?>
</body>
</html>