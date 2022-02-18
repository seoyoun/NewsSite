<?php
session_start();
require 'newsdb.php';
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
        
        <h1>News</h1>
        
        
        
        
        <?php

        
        if($_SESSION['logged_in'])
        {
            echo "hello" . $_SESSION['user'];
            //add logout button
        ?>

            <!--create post button-->
            <form action="post.php">
                <input type="submit" class="postButton" value="post" />
            </form>
        
            <!--your posts (list of hyperlinks)
                be able to delete posts (delete button next to each post?)
                -->

                <!--once a post is clicked on (through hyperlink) show body, link (if one exists), comments-->
                <!--edit button (for each post)
                    1. should be able to update body
                    2. should be able to update title
                    3. should be able to update link
                -->
                <!--comments made by current user should have delete buttons-->
                    <!--time stamp-->
                    <!--edit button
                        1. edit comment itself
                    -->





            <!--logout button-->
            <form action="logout.php">
                <input type="submit" class="logoutButton" value="logout" />
            </form>
        <?php
            //add button for posting
        }
        else
        {

        
        ?>
        <!--login button-->
        <form action="login.php">
            <input type="submit" class="loginButton" value="login" />
        </form>
        <?php
        }

        //list all stories (title, username) order by story_id
        $stmt = $mysqli->prepare("select title, username from stories order by story_id");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->execute();

        $stmt->bind_result($title, $username);

        echo "<ul>\n";
        while($stmt->fetch()){
            ?>
            $titlelink=htmlentities($title);
            <a href="http://ec2-18-189-1-103.us-east-2.compute.amazonaws.com/~sallylee/displaypost.php">$titlelink</a>
             
            <?php
            
            printf("\t<li>%s %s</li>\n",
                htmlspecialchars($title),
                htmlspecialchars($username)
            );
        }
        echo "</ul>\n";

        $stmt->close();
        ?>

      
    

</body>
</html>