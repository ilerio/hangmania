<!DOCTYPE html>
<html>
<head>
<title>validate</title>
</head>
<body>
<?php 
    session_start();
    require 'connection.php';
    
    //User passed in variables
    $uname = filter_input(INPUT_POST, 'uname');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'pswd');
    $cpassword = filter_input(INPUT_POST, 'confpswd');
    
    //Get connection
    $con = getConnection();
    
    //query the database to see if email in use.
    $sql = "SELECT * FROM user WHERE email = '".$email."'";
    $result = mysqli_query($con,$sql) or die(mysqli_error($con));
	
    if (!(mysqli_num_rows($result) > 0))
    {
	if (strcmp($password,$cpassword) === 0)
	{
            //sql query
            $sql = "INSERT INTO user VALUES (null,'".$uname."','".$email."',PASSWORD('".$password."'),null)";
            
            //query execution and error handling
            if($con -> query($sql) === TRUE)
            {
		//finding the userid of added user
		$sql = "SELECT uid FROM user WHERE uname = '".$uname."'";
		$result = mysqli_query($con,$sql) or die(mysqli_error($con));
		
		if (mysqli_num_rows($result) == 1)
		{
                    //get the uid of the user
                    $info = mysqli_fetch_array($result);
                    $uid = stripslashes($info['uid']);
                    
                    // Initiate highscore table for user
                    $sql = "INSERT INTO highscore VALUES(null,$uid,0)";
                    $con -> query($sql) or die(mysqli_error($con));
		}
				
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
                echo "<h1>Error: ".$sql."<br/>".$con->error."</h1>";
            }
    }
    else
    {
        mysqli_close($con);
	echo "<h1>Your passwords do not match.</h1>";
	echo "<a href='register.php'>Back</a>";
    }
}
else
{
    mysqli_close($con);
    echo "<h1>Sorry, this email has already been used.</h1>";
    echo "<a href='register.php'>Back</a>";
}
?>
</body>
</html>