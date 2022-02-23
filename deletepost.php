<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post</title>
</head>
<body>
    

<?php
session_start();

require 'newsdb.php';

if(!hash_equals($_SESSION['token'], $_POST['token'])){
    die("Request forgery detected");
}

$story_id = $_POST['story_id'];

//deletes comments belonging to the story first since comments table references stories tables
$stmt = $mysqli->prepare("delete from comments where story_id=?");



if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('i', $story_id);

$stmt->execute();

$stmt->close();

$stmt = $mysqli->prepare("delete from stories where story_id=?");



if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('i', $story_id);

$stmt->execute();

$stmt->close();
header("Location: main.php");
?>

</body>
</html>