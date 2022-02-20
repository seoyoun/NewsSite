<?php
require 'newsdb.php';
$comment_id = $_POST['comment_id'];


$stmt = $mysqli->prepare("delete from comments where comment_id=?");

//do we still want to query the username?? there's no text box to edit username

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('s', $comment_id);

$stmt->execute();

$stmt->close();

//go back to displaypost.php of this current comment
    //do this by querying story_id using comment_id
?>