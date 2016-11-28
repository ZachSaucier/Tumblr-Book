<?php
session_start();
if(isset($_POST['blogname']) && isset($_POST['theme']) && isset($_SESSION['username'])){
	require('db.php');
	try {

		$pdo = db_connect();
		
		$sql = 'INSERT INTO userblogs (username, blogname, theme) VALUES (:username, :blogname, :theme);';

		$q = $pdo->prepare($sql);

		$success = $q->execute([':username' => $_SESSION['username'], ':blogname' => $_POST['blogname'], ':theme' => $_POST['theme']]);
		
		if($success){
			echo "user-blog relationship stored";
		}else{
			echo "user-blog relationship could not be stored (may already exist)";
		}
	}catch(PDOException $e){
		die("Could not connect to the database $dbname : " . $e->getMessage() );
	}
}
?>