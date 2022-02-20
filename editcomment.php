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
        
        <h1>Edit Comment</h1>

        <!--query based on story_id for default text in text boxes-->
        <?php
        require 'newsdb.php';
        $comment_id = $_POST['comment_id'];
        //use this to query for story_id

        
        $stmt = $mysqli->prepare("select comment, username from comments where comment_id='$comment_id'");
        
        //do we still want to query the username?? there's no text box to edit username

        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->execute();
        

        $stmt->bind_result($comment, $username);
        

        /*
        if($_SESSION['user'] != $username) //!$_SESSION['logged_in'] || 
        {
            echo "You are not authorized to make changes to this post.";
            ?>
            <form name ="input" action='main.php'>
                <input type="submit" value="back to main page" />
            </form>
            <?php
        }
        else
        {*/
        ?>

       
        <!--text box for title-->
        <form action="editingcomment.php" method="POST">
        <p>
            <label for="title">Comment:</label>
            <!--https://www.w3schools.com/tags/tag_textarea.asp-->
            <textarea id="title" name="title" rows="1" cols="50"><?php if($stmt->fetch()) {
            echo $comment;}?></textarea>
            
                
            <!--remember to filter title-->

        </p>
        <!--send story_id-->


        <!--creative portion: support posting images-->

        <input type="hidden" name = 'comment_id' value="<?php echo $comment_id;?>">
        <input type="submit" class="submitcommentButton" value="post comment" />
        
        </form>


        

        </body>
</html>