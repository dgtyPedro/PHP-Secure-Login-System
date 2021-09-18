<?php
	// Credenciais da DB
	define("DB_HOST", 'localhost');
	define("DB_DATABASE", 'dbtest');
	define("DB_USERNAME", 'root');
	define("DB_PASSWORD", '');

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ($conn->connect_error){
        echo "CONNECTION ERROR";
        die;
    }else{}

?>