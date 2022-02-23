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
        
        <h1>New Post</h1>
        <?php
        
        if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected");
        }

        echo "User: ". htmlentities($_SESSION['user']) . "<br><br>"; 
        ?>
        <!--text box for title-->
        <form action="posting.php" method="POST">
        <p>
            <label for="title">Title:</label>
            <!--https://www.w3schools.com/tags/tag_textarea.asp-->
            <textarea id="title" name="title" rows="1" cols="50"></textarea>



        </p>
        <!--text box for link-->
        <p>
            <label for="link">Link:</label>
            <textarea id="link" name="link" rows="2" cols="50"></textarea>

          

        </p>
        <!--text box for body-->
        <p>
            <label for="body">Body:</label>
            <textarea id="body" name="body" rows="6" cols="50"></textarea>

            
        </p>
        




        <input type="submit" class="submitpostButton" value="post" />
        
        </form>
        
        <form name ="input" action='main.php'>
            <input type="submit" value="back to main page" />
        </form>
        </body>
</html>