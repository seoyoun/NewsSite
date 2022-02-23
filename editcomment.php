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

        if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected");
        }
        
        
        ?>
        <div style="position: absolute; top: 10px; right: 10px; text-align:right;">
        <?php
        echo "User: ". htmlentities($_SESSION['user']); 
        ?>

        </div>
        <?php
            
        
        
        $story_id = $_POST['story_id'];
        //$_SESSION['story_id'] = $story_id;

        $stmt = $mysqli->prepare("select title, username, body, link, time from stories where story_id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $story_id);
        $stmt->execute();

        $stmt->bind_result($title, $username, $body, $link, $time); 




        //check if story actually has a link
            //filter white spaces
            //follows a real link format (ex. www..., http://..)


        while($stmt->fetch()){
            echo "Title: " . htmlentities($title);
            echo "<br>";
            echo "<br>";
            echo "By: " . htmlentities($username);
            echo "<br>";
            echo "<br>";
            if($link != NULL)
            {
                echo "Link: " . htmlentities($link);
                echo "<br><br>";
            }
            echo htmlentities($body);
            echo "<br><br>";
            echo "Created: " . $time;
            

        }
        $stmt->close();






        $comment_id = $_POST['comment_id'];
        //use this to query for story_id

        
        
        $stmt = $mysqli->prepare("select comment, username from comments where comment_id=?");
        
        //do we still want to query the username?? there's no text box to edit username

        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('i', $comment_id);
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

       
        <!--text box for comment-->
        <form action="editingcomment.php" method="POST">
        <p>
            <label for="comment">Comment:</label>
            <!--https://www.w3schools.com/tags/tag_textarea.asp-->
            <textarea id="comment" name="comment" rows="1" cols="50"><?php if($stmt->fetch()) {
            echo $comment;}?></textarea>
            
                
            <!--remember to filter comment-->

        </p>
        <?php
        $stmt->close();
        ?>
        <!--send story_id-->
        

        <!--creative portion: support posting images-->

        <input type="hidden" name = 'comment_id' value="<?php echo $comment_id;?>">
        <input type="hidden" name = 'story_id' value="<?php echo $story_id;?>">
        <input type="submit" class="submitcommentButton" value="post comment" />
        
        </form>

        <form name ="input" action='main.php'>
            <input type="submit" value="back to main page" />
        </form>
        

       

        </body>
</html>