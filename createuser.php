<?php
session_start();

require 'newsdb.php';

$user = $_GET['user'];
$pass = $_GET['password'];

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

//$sql = "select * from 'users' where name = '$user'";
//echo($sql); // this prints!
/*$stmt = $mysqli->prepare("select * from users where name = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $user);
$stmt->execute();
$stmt->bind_result($res);
$stmt->fetch();
$stmt->close();
*/

//https://blog.arvixe.com/how-to-check-if-record-exists-in-sql-database-table-with-php/
$q="SELECT COUNT(1) FROM users WHERE username='$user'";
$r=mysqli_query($mysqli, $q);
$row=mysqli_fetch_row($r);
//Now to check, we use an if() statement
if($row[0] >= 1) 
{
  
    echo "This username is already taken."; // prompt for password to just login!
    ?>
    
    <form name ="input" action='login.php'>
        <input type="submit" value="back to sign up" />
    </form>
    <?php
    exit;
} 
else 
{

    // hash password
    $p_hash = password_hash($pass, PASSWORD_BCRYPT);

    //add user to users table
    
    $stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");

    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    else {
        echo "user added! " . $user; //this prints!
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



?>