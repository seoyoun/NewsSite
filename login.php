<?php
session_start();

$_SESSION['logged_in'] = false;
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login:</h1>
    <form name="input" action="verifyuser.php" method="post">
        Username: <input type="text" name="user"/>
        Password: <input type="password" name="password"/>
        <input type="submit" value="Login" />
    </form>

    <h2>Sign Up:</h2>
    <form name="input" action="createuser.php" method="post">
        Username: <input type="text" name="user"/>
        Password: <input type="password" name="password"/>
        <input type="submit" value="Sign Up" />
    </form>
    
    <br>
    <br>

    <form name ="input" action='index.php'>
        <input type="submit" value="Continue as Guest" />
    </form>
   
</body>
</html>