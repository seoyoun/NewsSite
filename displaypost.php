<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Post</title>
    <link rel="stylesheet" type="text/css" href="displaypost.css" />
</head>
<body>

<?php
require 'newsdb.php';
?>



<?php
if($_SESSION['logged_in'])
{
    ?>
    <div style="position: absolute; top: 10px; right: 10px; text-align:right;">
    <?php
    echo "User: ". htmlentities($_SESSION['user']); 
    ?>

    </div>
    <?php
    
}
if(isset($_POST['story_id']))
{
    $story_id = $_POST['story_id'];
}
else
{
    $story_id = $_SESSION['story_id'];
}



$stmt = $mysqli->prepare("select title, username, body, link, time from stories where story_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('i', $story_id);
$stmt->execute();

$stmt->bind_result($title, $username, $body, $link, $time); 







while($stmt->fetch()){
    ?>
    <h1><?php echo htmlentities($title); ?></h1>
    <?php
    
    echo "By: " . htmlentities($username);
    echo "<br>";
    echo "<br>";
    if($link != NULL)
    {
        echo "Link: "; ?> <a href=<?php echo $link;?>><?php echo $link; ?></a>
        <?php
        echo "<br><br>";
    }
    echo htmlentities($body);
    echo "<br><br>";
    echo "Created: " . $time;
    

}
$stmt->close();
 
echo "<br><br>";

if($_SESSION['logged_in'])
{
    if($_SESSION['user']==$username)
    {
        ?>
        <!--edit button-->
        <form action="editpost.php" class = "inline" method="post" >
            <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
            <input type="submit" value="Edit">
        </form>
    <?php
    }
    if($_SESSION['user'] == 'admin' || $_SESSION['user']==$username)
    {
        ?>
        <!--delete button--> 
        <form action="deletepost.php" class = "inline" method="post" >
            <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
            <input type="submit" value="Delete">
        </form>
        <?php
    }
}
?>




<h2>Comments: </h2>

<?php
if($_SESSION['logged_in'])
{
?>
    <form action="postcomment.php" class = "postcomment" method="post">
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" rows="1" cols="50"><?php if($stmt->fetch()) {
        echo $comment;}?></textarea>
        <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
        <input type="submit" value="Post Comment">
    </form>
<?php
}
?>
<?php
$stmt = $mysqli->prepare("select comment_id, comment, username, time from comments where story_id=? order by comment_id");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('i', $story_id);

$stmt->execute();

$stmt->bind_result($comment_id, $comment, $username, $time);


echo "<ul>\n";
while($stmt->fetch()){
    echo htmlentities($comment) . " by " . htmlentities($username);

    if($_SESSION['logged_in'])
    {
        if($_SESSION['user']==$username)
        {
            ?>
            <!--edit button-->
            <form action="editcomment.php" class = "inline" method="post" >
                <input type="hidden" name = 'comment_id' value="<?php echo $comment_id?>">
                <input type="hidden" name = 'story_id' value="<?php echo $story_id;?>">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <input type="submit" value="Edit">
            </form>
        <?php
        }
        if($_SESSION['user'] == 'admin' || $_SESSION['user']==$username)
        {
            ?>
            <!--delete button--> 
            <form action="deletecomment.php" class = "inline" method="post" >
                <input type="hidden" name = 'comment_id' value="<?php echo $comment_id?>">
                <input type="hidden" name = 'story_id' value="<?php echo $story_id;?>">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <input type="submit" value="Delete">
            </form>
            <?php
        }
    }

    echo "\tCreated: " . $time;
    ?>
    <br>
    <br>
    
    

   
     
    <?php
    
    
}
echo "</ul>\n";


$stmt->close();

if($_SESSION['logged_in'])
{
?>
<form name ="input" action='main.php'>
    <input type="submit" value="back to main page" />
</form>
<?php
}
else
{
?>
<form name ="input" action='index.php'>
    <input type="submit" value="back to main page" />
</form>
<?php
}
?>
</body>
</html>