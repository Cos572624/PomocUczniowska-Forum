<?php

include 'connect.php';
include 'header.php';

echo '<h3>Sign in</h3>';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {

    header('Location: index.php');
    exit(); 
}

if($_SERVER['REQUEST_METHOD'] != 'POST') {

    echo '<form method="post" action="">
            Username: <input type="text" name="user_name" />
            Password: <input type="password" name="user_pass">
            <input type="submit" value="Sign in" />
          </form>';
} else {



    if(!isset($_POST['user_name']) || !isset($_POST['user_pass'])) {

        echo 'Uh-oh.. a couple of fields are not filled in correctly..';
    } else {

        $sql = "SELECT user_id, user_name, user_level FROM users WHERE user_name = ? AND user_pass = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $_POST['user_name'], sha1($_POST['user_pass']));
        $result = mysqli_stmt_execute($stmt);

        if(!$result) {

            echo 'Something went wrong while signing in. Please try again later.';
        } else {

            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 0) {

                echo 'You have supplied a wrong user/password combination. Please try again.';
            } else {

                $_SESSION['signed_in'] = true;
                while ($row = mysqli_fetch_assoc($result)) {
                    $_SESSION['user_id'] 	= $row['user_id'];
                    $_SESSION['user_name'] 	= $row['user_name'];
                    $_SESSION['user_level'] = $row['user_level'];
                }
                header('Location: index.php');
                exit(); 
            }
        }
    }
}

include 'footer.php';

?>
