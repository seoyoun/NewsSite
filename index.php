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
    <link rel="stylesheet" type="text/css" href="index.css" />
</head>
<body>
        
        <h1>News</h1>
        
        
        
        
        

       
        <!--login button-->
        <form action="login.php">
            <input type="submit" class="loginButton" value="login" />
        </form>
        <?php
        $_SESSION['logged_in'] = false;

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

            <!--leads to another page that displays the contents of the selected story-->
            <form action="displaypost.php" class = "open" method="post" >
                <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
                <input type="submit" value="Open">
            </form>

   
             
            <br>
            <br>
            <?php
            
            
        }
        

        $stmt->close();
        ?>

      
    

</body>
</html>