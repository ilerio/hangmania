<?php
session_start();
require 'connection.php';

// Set up connection; redirect to log in if cannot connect or not logged in
if (filter_input(INPUT_COOKIE, "auth") != 1) {
    header("Location: index.php");
    exit;
}

$con = getConnection();

if ($con == null)
{
    echo "false1";
    exit;
}

$uid = $_SESSION["uid"];
$score = filter_input(INPUT_GET, "score");
settype($score, "int");

$sql_get_score = "SELECT score FROM highscore WHERE uid = $uid";
$result = mysqli_query($con, $sql_get_score);

if (mysqli_num_rows($result) == 1)
{
    $info = mysqli_fetch_array($result);
    $oldscore = $info["score"];
    settype($oldscore, "int");
    $score = $score + $oldscore;
    
    $sql_update_score = "UPDATE highscore SET score = $score WHERE uid = $uid";
    $flag = $con ->query($sql_update_score) or Die(mysqli_error($con));
    
    if($flag)
    {
        echo "true";
        exit;
    }
}
else 
{
    echo "false2";
    exit;
}
?>

