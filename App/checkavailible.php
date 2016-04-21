<?php
    require 'connection.php';
    $input = filter_input(INPUT_GET, "q");
    $con = getConnection();
    $sql = "SELECT uname FROM user WHERE ";
    $result = mysqli_query($con, $sql);
    
    
    // Output handler // returns true if username in use, false otherwise
    if(mysqli_num_rows($result) > 0)
    {
        echo "true";
    }
    else
    {
        echo "false";
    }
?>