<!DOCTYPE html>
<?php 
    session_start();
    // Set up connection; redirect to log in if cannot connect or not logged in
    if (filter_input(INPUT_COOKIE, "auth") != 1) {
        header("Location: index.php");
        exit();
    }
?>
<html lang="en">
    <head>
        <title>Avatar update!</title>
        
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
        <div class="container"><?php include 'nav.php';?></div>
        <div class="container">
            <form action="do_upload.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                <div class="form-group">
                    <p>Select Picture:</p>
                    <input type="file" name="fileupload"/>
                    <p class="help-block">Please only use .png and .jpg files. All files must be under 1mb.</p>
                </div>
                <button type="submit" class="btn btn-default btn-md">Upload</button>
            </form>
        </div>
        <div class="container"><?php include 'footer.php';?></div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>

