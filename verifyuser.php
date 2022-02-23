<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify User</title>
</head>
<body>
<?php
session_start();

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
else {
    echo "valid username";
}





// This is a *good* example of how you can implement password-based user authentication in your web application.



// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), password FROM users WHERE username=?");

// Bind the parameter
$stmt->bind_param('s', $user);
//$user = $_GET['username'];
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $pwd_hash);
$stmt->fetch();

$pwd_guess = $_POST['password'];

echo $pwd_guess; //prints




// Compare the submitted password to the actual password hash

if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
	// Login succeeded!

    
	$_SESSION['user'] = $user;
    $_SESSION['logged_in'] = true;
    $_SESSION['token'] = bin2hex(random_bytes(32));

	// Redirect to your target page
    header("Location: main.php");
} else{
	// Login failed; redirect back to the login screen
    header("Location: login.php");
}
?>









</body>
</html>


































