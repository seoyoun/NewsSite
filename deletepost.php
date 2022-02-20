<?php
require 'newsdb.php';
$story_id = $_POST['story_id'];


$stmt = $mysqli->prepare("delete from stories where story_id=?");

//do we still want to query the username?? there's no text box to edit username

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('s', $story_id);

$stmt->execute();

$stmt->close();

header("Location: main.php");
?>