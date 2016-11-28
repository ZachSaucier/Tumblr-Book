<?php
session_start();
if(isset($_POST['library']) && isset($_SESSION['username']) && isset($_POST['content'])){
	require('db.php');
	try {

		$pdo = db_connect();

		$sql = 'INSERT INTO librarycomments (library, username, created, content) VALUES (:library, :username, :created, :content)';

		$q = $pdo->prepare($sql);
		
		$date = getdate();
		$date = $date['month'].' '.$date['mday'].', '.$date['year'];

		$success = $q->execute([':library' => $_POST['library'], ':username' => $_SESSION['username'], ':created' => $date, ':content' => $_POST['content']]);

		if($success){
			$sql = 'SELECT id FROM librarycomments WHERE library=:library AND username=:username AND created=:created AND content=:content ORDER BY id DESC';

			$q = $pdo->prepare($sql);

			$q->execute([':library' => $_POST['library'], ':username' => $_SESSION['username'], ':created' => $date, ':content' => $_POST['content']]);
			$result = $q->fetch(PDO::FETCH_ASSOC);
			
			echo $result['id'].': library comment stored successfully';
		}else{
			echo 'error storing library content';
		}

	}catch(PDOException $e){
		die("Could not connect to the database $dbname : " . $e->getMessage() );
	}
}
?>