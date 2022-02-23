<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editing</title>
</head>
<body>
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

$stmt->bind_param('sssi', $title, $link, $body, $story_id);

$stmt->execute();

$stmt->close();

header("Location: main.php");
?>
</body>
</html>
