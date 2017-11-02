<?php
    $host = 'localhost'; 
	$user ='root';
	$pass = '';
	$db = 'wikiblog_mohamad_abdulkafi';	
	$connection = new mysqli($host,$user,$pass,$db);
	if($connection->connect_errno)
	{
		die('Failed to connect');
	}
	
?>