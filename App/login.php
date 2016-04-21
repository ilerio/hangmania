<?php
    session_start();
    require 'connection.php';
    
    if (!(isset($_POST["uname"])&&isset($_POST["pswd"])))
    {
        header("Location: index.php");
        exit;
    }
    
    $uname = filter_input(INPUT_POST, "uname");
    $pswd = filter_input(INPUT_POST, "pswd");
    
    $con = getConnection();
    if ($con == NULL)
    {
        header("Location: index.php");
        exit;
    }
    
    //query the database to see if email in use.
    $sql = "SELECT * FROM user WHERE uname = '".$uname."' AND password = PASSWORD('".$pswd."')";
    $result = mysqli_query($con,$sql) or die(mysqli_error($con));
    
    if (mysqli_num_rows($result) == 1) //TODO insert into highscore
    {
        //if authorized, get the values of FirstName LastName
        $info = mysqli_fetch_array($result);
        $uid = stripslashes($info['uid']);
		
        //set session items for user to be used throughout website
        $_SESSION["uid"] = $uid;
        $_SESSION["uname"] = $uname;
                
        //set authorization cookie
        setcookie("auth", "1", time()+60*30*24, "/", "", 0);
				
        mysqli_close($con);
        header("Location: home.php");
        exit;
    }
    else
    {
        mysqli_close($con);
        echo "<h1>Sorry, something went wrong. Please check your email and password and try again.</h1>";
        echo "<a href='index.php'>Back</a>";
    }
?>