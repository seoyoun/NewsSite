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
        
        

        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $story_id);

        $stmt->execute();

        $stmt->bind_result($title, $username, $body, $link);

        
        ?>

        
        <!--text box for title-->
        <form action="editing.php" method="POST">
        <p>
            <label for="title">Title:</label>
            <!--https://www.w3schools.com/tags/tag_textarea.asp-->
            <textarea id="title" name="title" rows="1" cols="50"><?php if($stmt->fetch()) {
            echo $title;?></textarea>
            
                
            

        </p>
        <!--text box for link-->
        <p>
            <label for="link">Link:</label>
            <textarea id="link" name="link" rows="2" cols="50"><?php 
            echo $link;?></textarea>

            

        </p>
        <!--text box for body-->
        <p>
            <label for="body">Body:</label>
            <textarea id="body" name="body" rows="6" cols="50"><?php 
            echo $body;}?></textarea>

            
        </p>

        <?php
        $stmt->close();
        ?>





        <!--send story_id-->
        <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
        <input type="submit" class="submitpostButton" value="post" />
        
        </form>

        <form name ="input" action='main.php'>
            <input type="submit" value="back to main page" />
        </form>
        

        </body>
</html>