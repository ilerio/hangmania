<?php
session_start();
require 'connection.php';

// Set up connection; redirect to log in if cannot connect or not logged in
if (filter_input(INPUT_COOKIE, "auth") != 1) {
    header("Location: index.php");
    exit();
}

$con = getConnection();
$uid = $_SESSION["uid"];

$file_dir = "./updir";
foreach($_FILES as $file_name => $file_array) 
{
    if (is_uploaded_file($file_array["tmp_name"])) 
    {
        $bool = move_uploaded_file($file_array["tmp_name"], "$file_dir/".$file_array["name"]);
	if ($bool)
        {
            $new = $file_array["name"];
            
            $avatar_sql = "SELECT avatar FROM user WHERE uid = $uid";
            $oldfile_result = mysqli_query($con,$avatar_sql) or die(mysqli_error($con));
            if (mysqli_num_rows($oldfile_result) == 1)
            {
                //get the uid of the user
                $info = mysqli_fetch_array($oldfile_result);
                $oldfile = stripslashes($info['avatar']);
            }
            
            $sql = "UPDATE user SET avatar = '".$new."' WHERE uid = $uid";
            $con -> query($sql) or die(mysqli_error($con));
            
            $comp = strcmp($new, $oldfile);
            
            if ($comp != 0)
            {
                unlink("updir/".$oldfile);
                echo "compear = $comp <br/> old = $oldfile <br/> new = ".$file_array["name"];
            }
            
            $con -> close();
            header("Location: home.php");
            exit();
        }
        else
        {     
            echo "path: ".$file_array["tmp_name"]."<br/>\n";
            echo "name: ".$file_array["name"]."<br/>\n";
            echo "type: ".$file_array["type"]."<br/>\n";
            echo "size: ".$file_array["size"]."<br/>\n";
            $con -> close();
            echo "<h1>Sorry, we could not upload your file. Please check that your file size is < 1mb</h1>";
            echo "<br/><a href='fileupload.php'>Back</a>";
        }
    }
}
?>