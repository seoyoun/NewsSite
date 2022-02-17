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
        
        <!--list articles-->
        <?php 
        $stmt = $mysqli->prepare("select title from stories");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->execute();

        
        $result = $stmt->get_result();

        echo "<ul>\n";
        while($row = $result->fetch_assoc()){
            printf("\t<li> %s </li>\n",
                htmlspecialchars( $row["title"] )
            );
        }
        echo "</ul>\n";
        ?>
        </div>

    </div>
        
        <!--login button-->
        <form action="login.php">
            <input type="submit" class="loginButton" value="login" />
        </form>
        
    </div>    
    

</body>
</html>