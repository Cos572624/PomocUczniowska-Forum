<?php
include 'connect.php';
include 'header.php';

$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT
			topic_id,
			topic_subject
		FROM
			topics
		WHERE
        topics.topic_id = ?";

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $topic_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (!$result) {
        echo 'The topic could not be displayed, please try again later.';
    } else {
        if (mysqli_num_rows($result) == 0) {
            echo 'This topic doesn&prime;t exist.';
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<table class="topic" border="1">
                        <tr>
                            <th colspan="2">' . $row['topic_subject'] . '</th>
                        </tr>';
                $posts_sql = "SELECT
                                posts.post_topic,
                                posts.post_content,
                                posts.post_date,
                                posts.post_by,
                                users.user_id,
                                users.user_name
                            FROM
                                posts
                            LEFT JOIN
                                users
                            ON
                                posts.post_by = users.user_id
                            WHERE
                                posts.post_topic = ?";

                if ($posts_stmt = mysqli_prepare($conn, $posts_sql)) {
                    mysqli_stmt_bind_param($posts_stmt, "i", $topic_id);
                    mysqli_stmt_execute($posts_stmt);
                    $posts_result = mysqli_stmt_get_result($posts_stmt);
                    
                    if (!$posts_result) {
                        echo '<tr><td>The posts could not be displayed, please try again later.</tr></td></table>';
                    } else {
                        while ($posts_row = mysqli_fetch_assoc($posts_result)) {
                            echo '<tr class="topic-post">
                                    <td class="user-post">' . $posts_row['user_name'] . '<br/>' . date('d-m-Y H:i', strtotime($posts_row['post_date'])) . '</td>
                                    <td class="post-content">' . htmlentities(stripslashes($posts_row['post_content'])) . '</td>
                                  </tr>';
                        }
                    }
                    mysqli_stmt_close($posts_stmt);
                }
                
                if (!$_SESSION['signed_in']) {
                    echo '<tr><td colspan=2>You must be <a href="signin.php">signed in</a> to reply. You can also <a href="signup.php">sign up</a> for an account.';
                } else {
                    echo '<tr><td colspan="2"><h2>Reply:</h2><br />
                        <form method="post" action="reply.php?id=' . $row['topic_id'] . '">
                            <textarea name="reply-content"></textarea><br /><br />
                            <input type="submit" value="Submit reply" />
                        </form></td></tr>';
                }
                echo '</table>';
            }
        }
        mysqli_free_result($result);
    }
    mysqli_stmt_close($stmt);
}

include 'footer.php';
?>
