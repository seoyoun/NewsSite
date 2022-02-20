<?php
session_start();
require 'newsdb.php';

$title = $_POST['title'];
$link = $_POST['link'];
$body = $_POST['body'];
$story_id = $_POST['story_id'];

$stmt = $mysqli->prepare("update stories set title=?, link=?, body=? where story_id=?");
//$stmt = $mysqli->prepare("insert into stories (title, username, body, link) values (?, ?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ssss', $title, $link, $body, $story_id);

$stmt->execute();

$stmt->close();

header("Location: main.php");
?>