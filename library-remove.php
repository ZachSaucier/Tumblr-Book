<?php
session_start();
if(isset($_SESSION['username']) && isset($_POST['blogname'])){
	require('db.php');
	try {

		$pdo = db_connect();

		$sql = 'DELETE FROM userblogs WHERE username=:username AND blogname=:blogname';

		$q = $pdo->prepare($sql);

		$success = $q->execute([':username' => $_SESSION['username'], ':blogname' => $_POST['blogname']]);

		if($success){
			echo 'user-blog relationship deleted successfully';
		}else{
			echo 'error deleting user-blog relationship';
		}

	}catch(PDOException $e){
		die("Could not connect to the database $dbname : " . $e->getMessage() );
	}
}
?>