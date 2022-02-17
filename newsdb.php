<?php
// Content of database.php

$mysqli = new mysqli('localhost', 'kgeorge', 'Blueger53', 'newsdb');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>