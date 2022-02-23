<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
</head>
<body>

<?php
require 'newsdb.php';

$user = $_POST['user'];
$pass = $_POST['password'];

// check for valid username
if( !preg_match('/^[\w_\-]+$/', $user) || $user == ''){
    echo "Invalid username";
    ?>
    
    <form name ="input" action='login.php'>
        <input type="submit" value="back to sign up" />
    </form>
 
    <?php
    exit; // will not hash password
}



$stmt = $mysqli->prepare("select count(*) from users where username=?");
if(!$stmt){
	printf("Query Prep count Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $user);

$stmt->execute();

$stmt->bind_result($count);

if($stmt->fetch())
{
    $stmt->close();
    if($count > 0)
    {
        echo "This username is already taken."; 
        ?>
        
        <form name ="input" action='login.php'> 
            <input type="submit" value="back to sign up" />
        </form>
        <?php
        exit;
    }
    else 
    {
        $_SESSION['user'] = $user;
        $_SESSION['logged_in'] = true;
        $_SESSION['token'] = bin2hex(random_bytes(32));
        // hash password
        $p_hash = password_hash($pass, PASSWORD_BCRYPT);
    
        //add user to users table
        
        $stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
    
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
       
    
        if(!$stmt->bind_param('ss', $user, $p_hash))
        {
            printf("Query bind Failed: %s\n", $mysqli->error);
            exit;
        }
    
        if(!$stmt->execute())
        {
            printf("Query execute Failed: %s\n", $mysqli->error);
            exit;
        }
    
        $stmt->close();
    
        header("Location: main.php");
    
    }
}




?>