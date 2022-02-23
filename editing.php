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
// Remove all illegal characters from a url
$link = filter_var($link, FILTER_SANITIZE_URL);

// Validate url
if ($link=="" || !filter_var($link, FILTER_VALIDATE_URL) === false) {
$stmt = $mysqli->prepare("update stories set title=?, link=?, body=? where story_id=?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sssi', $title, $link, $body, $story_id);

$stmt->execute();

$stmt->close();

header("Location: main.php");
}
else
{
    echo("not a valid URL<br>");
  echo("URL must start with https:// or http://");
?>

<form name ="input" action='main.php'>
    <input type="submit" value="back to main page" />
</form>

<?php
}

?>
</body>
</html>

