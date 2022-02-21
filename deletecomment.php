<?php
require 'newsdb.php';
$comment_id = $_POST['comment_id'];
$story_id = $_POST['story_id'];
$_SESSION['story_id'] = $story_id;
echo $comment_id;

$stmt = $mysqli->prepare("delete from comments where comment_id=?");

//do we still want to query the username?? there's no text box to edit username

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
else
{
    echo "query prep succeeded";
}

if(!$stmt->bind_param('s', $comment_id))
{
    echo "could not bind parameters";
}
else{
    echo "bound parameters";
}

if(!$stmt->execute())
{
    echo "could not execute";
}
else{
    echo "executed";
}

if(!$stmt->close())
{
    echo "could not close";
}
else{
    echo "closed";
}

//go back to displaypost.php of this current comment
    //do this by querying story_id using comment_id
//header("Location: displaypost.php?story_id=$story_id");
?>