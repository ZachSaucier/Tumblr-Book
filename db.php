<?php

/*
$host = '';
$username = 'root';
$password = '';
*/
$dbname = 'tumblrbook';

function db_connect(){
	return new PDO("mysql:host=;dbname=tumblrbook", 'root', '');
}

?>