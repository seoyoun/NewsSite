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
$story_id = $_POST['story_id'];


$stmt = $mysqli->prepare("select title, username, body, link from stories where story_id='$story_id'");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($title, $username, $body, $link); 




//check if story actually has a link
    //filter white spaces
    //follows a real link format (ex. www..., http://..)


while($stmt->fetch()){
    echo "Title: " . $title;
    echo "<br>";
    echo "<br>";
    echo "By: " . $username;
    echo "<br>";
    echo "<br>";
    if($link != NULL)
    {
        echo "Link: " . $link;
        echo "<br><br>";
    }
    echo $body;
    

}

if($_SESSION['logged_in'] && $_SESSION['user']==$username)
{
    ?>
    <!--edit button-->
    <form action="editpost.php" class = "editpost" method="post" >
        <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
        <input type="submit" value="Edit">
    </form>
    <!--delete button--> 
    <form action="deletepost.php" class = "deletepost" method="post" >
        <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
        <input type="submit" value="Delete">
    </form>
    <?php
}

$stmt->close();
?>
</body>
</html>