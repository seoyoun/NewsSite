<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Files</title>
    <link rel="stylesheet" type="text/css" href="files.css" />
</head>
<body>
<?php

require 'newsdb.php';

$comment = $_POST['comment'];
$user = $_SESSION['user'];
$story_id = $_POST["story_id"];




$stmt = $mysqli->prepare("insert into comments (comment, story_id, username) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sss', $comment, $story_id, $user);

$stmt->execute();

$stmt->close();

header("Location: displaypost.php?story_id=$story_id");
?>
<!--re-direct to display post of corresponding story-->
<!--
 <form action="displaypost.php" class = "displaypost" method="post" >
    <input type="hidden" name = 'story_id' value="<?php //echo $story_id?>">
</form>
-->
</body>
</html>