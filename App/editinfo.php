<!DOCTYPE html>
<?php session_start(); //TODO
    // Set up connection; redirect to log in if cannot connect or not logged in
    if (filter_input(INPUT_COOKIE, "auth") != 1) {
        header("Location: index.php");
        exit();
    }
?>