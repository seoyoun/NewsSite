<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Comment</title>
</head>
<body>
    


<?php
require 'newsdb.php';
session_start();

if(!hash_equals($_SESSION['token'], $_POST['token'])){
    die("Request forgery detected");
}

$comment_id = $_POST['comment_id'];
$story_id = $_POST['story_id'];
$_SESSION['story_id'] = $story_id;


$stmt = $mysqli->prepare("delete from comments where comment_id=?");


if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
else
{
    echo "query prep succeeded";
}

$stmt->bind_param('i', $comment_id);


$stmt->execute();

$stmt->close();

//go back to displaypost.php of this current comment
    
header("Location: displaypost.php?story_id=$story_id"); 
?>


</body>
</html>