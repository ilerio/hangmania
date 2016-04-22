<!DOCTYPE html>
<!--
User Profile Sidebar by @keenthemes
A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
Licensed under MIT
-->
<?php 
    session_start();
    require 'connection.php';

    // Set up connection; redirect to log in if cannot connect or not logged in
    if (filter_input(INPUT_COOKIE, "auth") != 1) {
        header("Location: index.php");
        exit();
    }
    
    $uid = $_SESSION["uid"];
    $uname = $_SESSION["uname"];
    
    $con = getConnection();
    
    $avatar_sql = "SELECT avatar FROM user WHERE uid = $uid";
    $avatar_result = mysqli_query($con,$avatar_sql) or die(mysqli_error($con));
    if (mysqli_num_rows($avatar_result) == 1)
    {
        //get the uid of the user
        $info = mysqli_fetch_array($avatar_result);
        $avatar = stripslashes($info['avatar']);
        if ($avatar == null)
        {
            unset($avatar);
        }
    }
    
    // Query done for #tablequery
    $hs_sql = "SELECT user.uid, uname, score FROM user, highscore WHERE user.uid = highscore.uid ORDER BY score DESC";
    $hs_result = mysqli_query($con,$hs_sql) or die(mysqli_error($con));
    
    if(mysqli_num_rows($hs_result) > 0)
    {
        $count = 0;
        while ($row = mysqli_fetch_array($hs_result)) 
        {
            $count++;
            $uname_lb = $row["uname"];
            if(strcmp($uname,$uname_lb) == 0)
            {
                $rank = $count;
            }
        }
    }
    else
    {
        $table_empty = "Table is empty.";
    }
?>
<html>
    <head>
        <title>Hangmania home!</title>
        
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/home.css">
        <style>
            body{
                font-family: arial, sans-serif;
            }
            #table_avatar{
                width: 30px;
                margin: auto;
            }
        </style>
    </head>
    <body>
        <div class="container"><?php include 'nav.php';?></div>
        
        <div class="container">
            <div class="row profile">
                <div class="col-md-3">
                    <div class="profile-sidebar">
                    <?php
                        if (isset($avatar) && file_exists("updir/$avatar"))
                        {
                            $pic = "updir/$avatar";
                    ?>    
                        <!-- SIDEBAR USERPIC UPLOADED -->
                        <div class="profile-userpic">
                            <img src="<?php echo $pic; ?>" class="img-responsive" alt="User Pic">
                        </div>
                        <!-- END SIDEBAR USERPIC UPLOADED -->
                    <?php 
                        }
                        else
                        {
                    ?>
                        <!-- SIDEBAR USERPIC DEFAULT -->
                        <div class="profile-userpic">
                            <img src="updir/hangmania_man_only.png" class="img-responsive" alt="Default User Pic">
                        </div>
                        <!-- END SIDEBAR USERPIC DEFAULT -->
                    <?php        
                        }
                    ?>
                        <!-- SIDEBAR BUTTONS -->
                        <div class="profile-userbuttons">
                            <a id="edit" href="fileupload.php" class = "btn btn-default btn-xs" role="button">Edit</a>
                        </div>
                        <!-- END SIDEBAR BUTTONS -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                <?php echo $uname; ?>
                            </div>
                            <div class="profile-rank">
                            <?php
                                // Put message at the top of the page if applicable
                                if (isset($rank))
                                {
                                    echo 'Rank: #'.$rank;
                                }
                                else
                                {
                                    echo 'Rank: #';
                                }
                            ?>
                            </div>
                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR MENU -- TODO --
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li>
                                    <a data-placement="bottom" data-toggle="popover" data-title="Edit Info" data-container="body" type="button" data-html="true" href="#" id="editinfo">
                                    <i class="glyphicon glyphicon-user"></i>
                                    Edit Info </a>
                                    <div id="popover-content" class="hide">
                                        <form class="form-inline" role="form" style="margin: 5px;" action="editinfo.php" method="post">
                                            <div class="form-group">
                                                <input onkeyup="CeckAvailibilityEmail(this.value)" id="email" type="text" placeholder="Email" class="form-control" maxlength="50"><br/>
                                                <input onkeyup="CeckAvailibilityUname(this.value)" id="uname" type="text" placeholder="Username" class="form-control" maxlength="20"><br/><br/>
                                                <input onkeyup="TestStrength(this.value)" id="pswd" type="password" placeholder="New Password" class="form-control" maxlength="50"><br/>
                                                <input onkeyup="ConfirmPassword(this.value)" id="cpswd" type="password" placeholder="Confirm New Password" class="form-control" maxlength="50"><br/><br/>
                                                <button type="submit" class="btn btn-primary">Update</button>                                  
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- END MENU -->
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="profile-content">
                        <h3 class="jumbotron center-block hidden" id="message"></h3> <!--TODO ajax-->
                        <h2>Leaderboard</h2>
                        <?php
                            // Put table empty message at the top of the page if applicable
                            if (isset($table_empty))
                            {
                                echo '<h3 class="jumbotron center-block">'.$table_empty.'</h3>';
                            }
                            else
                            {
                        ?>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Avatar</th>
                                    <th>Rank</th>
                                    <th>Username</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                            // Query done abouve #tablequery
                            $count = 0;
                            foreach($hs_result as $row)
                            {
                                $count++;
                                $id = $row["uid"];
                                $uname_lb = $row["uname"];
                                $score = $row["score"];
                        ?>
                                <tr>
                                    <td id="table_avatar"><img src="updir/<?php echo getAvatarName($id); ?>" class="img-responsive" alt="User Pic" width="30px"></td>
                                    <td><?php echo $count ?></td>
                                    <td><?php echo $uname_lb; ?></td>
                                    <td><?php echo $score; ?></td>
                                </tr>
                        <?php 
                            }
                        ?>
                            </tbody>
                        </table>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="footer">
                <hr/>
                &copy; 2016 Hangmania | <a href="credit.php" target="_blank">Credits</a> | Powered by <a href="http://j.mp/metronictheme" target="_blank">KeenThemes</a>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
            $("[data-toggle=popover]").popover({
                html: true, 
                content: function() {
                    return $('#popover-content').html();
                }
            });
        </script>
        <!--script> // Not yet implemented // This is suposed to be edit info validation
            var CeckAvailibilityEmail = false;
            var CeckAvailibilityUname = false;
            var TestStrength = false;
            var ConfirmPassword = false;
            
            function CeckAvailibilityEmail(str)
            {
                
            }
            
            function CeckAvailibilityUname(str)
            {
                if (str.length === 0){return;} // do nothing
                else
                {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if(xmlhttp.readyState === 4 && xmlhttp.status === 200)
                        {    
                            var response = xmlhttp.responseText;
                            
                            if (response === "false")
                            {
                                
                            }
                            else
                            {
                                
                            }
                        };
                    };
                    xmlhttp.open("POST", "save_score.php" + score, true);
                    xmlhttp.send();
                }
                
                CheckCanUpdate();
            }
            
            function TestStrength(str)
            {
                
            }
            
            function ConfirmPassword(str)
            {
                
            }
            
            // verifies if update is possible then enables update button if ture
            function CheckCanUpdate() 
            {
                
            }
        </script-->
        <?php
            function getAvatarName($id)
            {
                $con = getConnection();
                $sql_avatar = "SELECT avatar FROM user WHERE uid = ".$id;
                $result_avatar = mysqli_query($con,$sql_avatar) or die(mysqli_error($con));
    
                if (mysqli_num_rows($result_avatar) == 1)
                {
                    //get the uid of the user
                    $info = mysqli_fetch_array($result_avatar);
                    $avt = stripslashes($info['avatar']);
                    if($avt == null){
                        return "hangmania_man_only.png";
                    }else{
                        return $avt;
                    }
                }
                $con -> close();
            }
        ?>
    </body>
</html>
