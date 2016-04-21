<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
    <head>
        <title>Registration page!</title>
        
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        
        <style>
            body{
                font-family: arial, sans-serif;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="page-header text-center"><img src="logo/hangmania.png" width="80%"></div>
            <form role="form" action="validate.php" method="POST">
                <div class="form-group col-xs-5">
                    <input type="email" name="email" class="form-control" placeholder="Email" maxlength="50" required autofocus>
                </div>
                <div class="form-group col-xs-5">
                    <input type="text" name="uname" class="form-control" placeholder="Username" maxlength="20" required>
                </div>
                <div class="form-group col-xs-5">
                    <input type="password" name="pswd" class="form-control" placeholder="Password" maxlength="50" required>
                </div>
                <div class="form-group col-xs-5">
                    <input type="password" name="confpswd" class="form-control" placeholder="Confirm password" maxlength="50" required>
                </div>
                <button type="submit" class="btn btn-default">Sign up</button>
            </form>
            <div class="container"><?php include 'footer.php'; ?></div>
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
