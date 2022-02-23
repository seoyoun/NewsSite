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
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>


<h1>Hello <?php echo htmlentities($_SESSION['user'])?>!</h1>

<div class="split left">


        
        <h2>News</h2>
            
        <?php
 
        //list all stories (title, username) order by story_id
        $stmt = $mysqli->prepare("select story_id, title, username from stories order by story_id");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->execute();

        $stmt->bind_result($story_id, $title, $username);

  
        while($stmt->fetch()){
            echo htmlentities($title) . " by " . htmlentities($username);
            ?>
            <!--make this a form that sends title and username through GET or POST-->
            
            <form action="displaypost.php" class = "open" method="post" >
                <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
                <input type="submit" value="Open">
            </form>

            <!--<a href="../news_comment/comment_delete.php?cmnt_id=<?php //echo $comment['comment_id']; ?>">[Delete]</td>-->
            
            <!--<a href="http://ec2-18-189-1-103.us-east-2.compute.amazonaws.com/~sallylee/displaypost.php">--><?php //printf("\t<li>%s", htmlentities($title));?><!--</a>-->
             <br>
             <br>
            <?php
            
            //printf(" %s</li>\n", htmlspecialchars($username));
        }
      

        $stmt->close();
        ?>

    </div>











    <div class="split right">
        <?php
        if($_SESSION['user']!='admin')
        {

        ?>
            <h2>Your Posts:</h2>
            <?php
            //list all stories (title, username) order by story_id
            $stmt = $mysqli->prepare("select story_id, title, username from stories where username=? order by story_id");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }

            $stmt->bind_param('s', $_SESSION['user']);

            $stmt->execute();

            $stmt->bind_result($story_id, $title, $username);

            
            while($stmt->fetch()){
                echo htmlentities($title);
                ?>
                <!--make this a form that sends title and username through GET or POST-->
                
                <form action="displaypost.php" class = "open" method="post" >
                    <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
                    <input type="submit" value="Open">
                </form>

                <!--<a href="../news_comment/comment_delete.php?cmnt_id=<?php //echo $comment['comment_id']; ?>">[Delete]</td>-->
                
                <!--<a href="http://ec2-18-189-1-103.us-east-2.compute.amazonaws.com/~sallylee/displaypost.php">--><?php //printf("\t<li>%s", htmlentities($title));?><!--</a>-->
                
                <br>
                <br>
                <?php
                
                //printf(" %s</li>\n", htmlspecialchars($username));
            }
            

            $stmt->close();

            
            ?>

            <!--create post button-->
            <form action="post.php" method="post">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <input type="submit" class="postButton" value="post" />
                
                
            </form>

        <?php
        }
        ?>
         






            <!--logout button-->
            <form action="logout.php">
                <input type="submit" class="logoutButton" value="logout" />
            </form>
            <?php
        
      ?>
    
    </div>
</body>
</html>