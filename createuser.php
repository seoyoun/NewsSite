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
$q="SELECT COUNT(1) FROM users WHERE username=$user";
$r=mysqli_query($mysqli, $q);
$row=mysqli_fetch_row($r);
//Now to check, we use an if() statement
if($row[0] >= 1) 
{
    //print "Record exists";
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
    //print "Record doesn't exist";
    //echo "username not taken";

    // hash password
    $p_hash = password_hash($pass, PASSWORD_BCRYPT);

    //add user to users table
    //$stmt = $mysqli->prepare("insert into users (username, password) values ('sally', 'sally')"); WORKS
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

}

//echo(mysqli_num_rows($query)); // this also does not :(

/*if(mysql_num_rows($query)){
        echo "This username is already taken."; // prompt for password to just login!
        ?>
        
        <form name ="input" action='login.php'>
            <input type="submit" value="back to sign up" />
        </form>
        <?php
        exit;
} 
else {
    echo "username not taken";
}

// USER CANNOT ENTER '' as a PASSWORD

// hash password
$p_hash = password_hash($pass, PASSWORD_BCRYPT);

//add user to users table
$stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
else {
    echo "user added! " . $user;
}

$stmt->bind_param('ss', $user, $p_hash);

$stmt->execute();

$stmt->close();
*/





/*if(mkdir($fullpath))
{
    //update users.txt
    //https://www.javatpoint.com/php-append-to-file
    $fp = fopen("/media/users/users.txt", 'a');//opens file in append mode  
    fwrite($fp, "\n");  
    fwrite($fp, $user);  
    fclose($fp);
    $_SESSION['user'] = $user;
    header("Location:files.php");
}
else
{
    echo "Please try another username!";
    
}
*/
?>