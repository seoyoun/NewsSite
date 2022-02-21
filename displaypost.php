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
if(isset($_POST['story_id']))
{
    $story_id = $_POST['story_id'];
}
else
{
    $story_id = $_SESSION['story_id'];
}



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

echo $_SESSION['user'];
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

//$_SESSION['logged_in'] && 
if($_SESSION['user']==$username)
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

/******* comment section ***********************************/
//list all comments (text, username) order by comment_id
//add comment button
    //addcomment.php
        //addingcomment.php redirects back to displaypost.php (use a POST form by story_id)
//if comment is by current user, have an edit and delete button next to it

?>
<h2>Comments: </h2>

<form action="postcomment.php" class = "postcomment" method="post">
    <label for="comment">Comment:</label>
    <textarea id="comment" name="comment" rows="1" cols="50"><?php if($stmt->fetch()) {
    echo $comment;}?></textarea>
    <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
    <input type="submit" value="Post Comment">
</form>

<?php
$stmt = $mysqli->prepare("select comment, username from comments where story_id=? order by comment_id");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('s', $story_id);

$stmt->execute();

$stmt->bind_result($comment, $username);


echo "<ul>\n";
while($stmt->fetch()){
    echo $comment . " by " . $username;

    if($username == $_SESSION['user'])
    {
        ?>
        

        <!--edit button-->
        <form action="editcomment.php" class = "editcomment" method="post" >
            <input type="hidden" name = 'comment_id' value="<?php echo $comment_id?>">
            <input type="submit" value="Edit">
        </form>
        <!--delete button--> 
        <form action="deletecomment.php" class = "deletecomment" method="post" >
            <input type="hidden" name = 'comment_id' value="<?php echo $comment_id?>">
            <input type="hidden" name = 'story_id' value="<?php echo $story_id;?>">
            <input type="submit" value="Delete">
        </form>
    <?php
    }
    ?>
    
    
    

    <!--<a href="http://ec2-18-189-1-103.us-east-2.compute.amazonaws.com/~sallylee/displaypost.php">--><?php //printf("\t<li>%s", htmlentities($title));?><!--</a>-->
     
    <?php
    
    //printf(" %s</li>\n", htmlspecialchars($username));
}
echo "</ul>\n";

$stmt->close();







$stmt->close();
?>
</body>
</html>