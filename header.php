<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoring Forum</title>
    <meta name="keywords" content="" />
    <meta name='description' content="" />
    <meta name='robots' content="none" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Tutoring forum</h1>
    <div id="wrapper">
        <div id="menu">
            <a class="item" href="/forum/index.php">Home</a> -
            <a class="item" href="/forum/create_topic.php">Create a topic</a> -
            <a class="item" href="/forum/create_cat.php">Create a category</a>
            <a class="item" href="../hub/hub.html">Go Back To The Hub</a>
            <div id="userbar">
            <?php
            if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'])
            {
                echo 'Hello ' . $_SESSION['user_name'] . '. Not you? <a href="signout.php">Sign out</a>';
            }
            else
            {
                echo '<a href="signin.php">Sign in</a> or <a href="signup.php">create an account</a>.';
            }
            ?>
        </div>
        <div id="content">
