<?php
session_start();
if(isset($_SESSION['username']) && isset($_POST['header'])){
	require('db.php');
	try {

		$pdo = db_connect();

		$sql = "UPDATE users SET libraryheader=:header WHERE username=:username;";

		$q = $pdo->prepare($sql);

		$success = $q->execute([':header' => $_POST['header'], ':username' => $_SESSION['username']]);

		if($success){
			echo 'library description updated successfully';
		}else{
			echo 'error updating library successfully';
		}

	}catch(PDOException $e){
		die("Could not connect to the database $dbname : " . $e->getMessage() );
	}
}
?>