<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posting</title>
</head>
<body>
<?php
session_start();
require 'newsdb.php';

$title = $_POST['title'];



// Remove all illegal characters from a url
$link = $_POST['link'];
$link = filter_var($link, FILTER_SANITIZE_URL);

// Validate url
if ($link=="" || !filter_var($link, FILTER_VALIDATE_URL) === false) {
    $body = $_POST['body'];

    $stmt = $mysqli->prepare("insert into stories (title, username, body, link) values (?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    
    $stmt->bind_param('ssss', $title, $_SESSION['user'], $body, $link);
    
    $stmt->execute();
    
    $stmt->close();

    header("Location: main.php");
} else {
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