<?php
session_start();

$h = fopen("/media/users/users.txt", "r"); //accessible??

$exists = false;



while(!feof($h))
{
    $user = trim(fgets($h));
    if($user == $_GET['user']) //$_GET['user'] or $_SESSION['user']??
    {
        $exists = true;
        $_SESSION['user'] = $user;
    }
    
}
if($exists)
{
    //go to user's page with their files
    header("Location:files.php");  
}
else
{
    //return to login.html with error message
    header("Location:login.php"); 
}


fclose($h);
?>