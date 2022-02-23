<?php
session_start();
require 'newsdb.php';

$comment_id = $_POST['comment_id'];
$comment = $_POST['comment'];
//$story_id = $_POST['story_id'];

$stmt = $mysqli->prepare("update comments set comment=? where comment_id=?");
//$stmt = $mysqli->prepare("insert into stories (title, username, body, link) values (?, ?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('si', $comment, $comment_id);

$stmt->execute();

$stmt->close();

//re-direct to displaypost.php of corresponding post
header("Location: displaypost.php?story_id=$story_id");
?>