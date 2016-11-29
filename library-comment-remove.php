<?php
session_start();
if(isset($_SESSION['username']) && isset($_POST['id'])){
	require('db.php');
	try {

		$pdo = db_connect();

		$sql = 'DELETE FROM librarycomments WHERE id=:id AND (library=:username OR username=:username)';

		$q = $pdo->prepare($sql);

		$success = $q->execute([':id' => $_POST['id'], ':username' => $_SESSION['username']]);

		if($success){
			echo 'comment deleted successfully';
		}else{
			echo 'error deleting comment';
		}

	}catch(PDOException $e){
		die("Could not connect to the database $dbname : " . $e->getMessage() );
	}
}
?>