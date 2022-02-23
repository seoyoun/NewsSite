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
    
</head>
<body>
        
        <h1>Edit Post</h1>

        <!--query based on story_id for default text in text boxes-->
        <?php
        require 'newsdb.php';
        if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected");
        }
        $story_id = $_POST['story_id'];
        $_SESSION['story_id']=$story_id;
        
        echo "User: ". htmlentities($_SESSION['user']) . "<br><br>"; 

        $stmt = $mysqli->prepare("select title, username, body, link from stories where story_id=?");
        
        //do we still want to query the username?? there's no text box to edit username

        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $story_id);

        $stmt->execute();

        $stmt->bind_result($title, $username, $body, $link);

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
        <form action="editing.php" method="POST">
        <p>
            <label for="title">Title:</label>
            <!--https://www.w3schools.com/tags/tag_textarea.asp-->
            <textarea id="title" name="title" rows="1" cols="50"><?php if($stmt->fetch()) {
            echo $title;?></textarea>
            
                
            <!--remember to filter title-->

        </p>
        <!--text box for link-->
        <p>
            <label for="link">Link:</label>
            <textarea id="link" name="link" rows="2" cols="50"><?php 
            echo $link;?></textarea>

            <!--remember to filter link-->

        </p>
        <!--text box for body-->
        <p>
            <label for="body">Body:</label>
            <textarea id="body" name="body" rows="6" cols="50"><?php 
            echo $body;}?></textarea>

            <!--remember to filter body-->
        </p>

        <?php
        $stmt->close();
        ?>
        <!--send story_id-->


        <!--creative portion: support posting images-->

        <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
        <input type="submit" class="submitpostButton" value="post" />
        
        </form>

        <form name ="input" action='main.php'>
            <input type="submit" value="back to main page" />
        </form>
        

        </body>
</html>