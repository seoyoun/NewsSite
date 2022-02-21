<?php
session_start();
require 'newsdb.php';

$title = $_POST['title'];
$link = $_POST['link'];
$body = $_POST['body'];

$stmt = $mysqli->prepare("insert into stories (title, username, body, link) values (?, ?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ssss', $title, $_SESSION['user'], $body, $link);

$stmt->execute();

$stmt->close();

header("Location: main.php");
?>