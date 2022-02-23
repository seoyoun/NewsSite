<?php
session_start();


require 'newsdb.php';

$comment = $_POST['comment'];
$user = $_SESSION['user'];
$story_id = $_POST["story_id"];


$_SESSION['story_id']=$story_id;

$stmt = $mysqli->prepare("insert into comments (comment, story_id, username) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sis', $comment, $story_id, $user);

$stmt->execute();

$stmt->close();

header("Location: displaypost.php?story_id=$story_id");
?>

