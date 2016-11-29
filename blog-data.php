<?php
if(isset($_POST['blogname']) && isset($_POST['content'])){
	require('db.php');
	try {

		$pdo = db_connect();

		$sql = 'INSERT INTO blogs VALUES (:blogname, :content, :updated)'
			. ' ON DUPLICATE KEY UPDATE content=:content, updated=:updated;';

		$q = $pdo->prepare($sql);
		
		$date = getdate();
		$date = $date['month'].' '.$date['mday'].', '.$date['year'];

		$success = $q->execute([':blogname' => $_POST['blogname'], ':content' => $_POST['content'], ':updated' => $date]);

		if($success){
			echo 'blog content stored successfully';
			session_start();
			if(isset($_SESSION['username'])){
				
				$sql = 'INSERT INTO userblogs (username, blogname, theme) VALUES (:username, :blogname, :theme)'
					. ' ON DUPLICATE KEY UPDATE theme=:theme;';

				$q = $pdo->prepare($sql);

				$success = $q->execute([':username' => $_SESSION['username'], ':blogname' => $_POST['blogname'], ':theme' => $_POST['theme']]);
				
				if($success){
					echo "\nuser-blog relationship stored";
				}else{
					echo "\nuser-blog relationship could not be stored (may already exist)";
				}
				
			}
		}else{
			echo 'error storing blog content';
		}

	}catch(PDOException $e){
		die("Could not connect to the database $dbname : " . $e->getMessage() );
	}
}
?>