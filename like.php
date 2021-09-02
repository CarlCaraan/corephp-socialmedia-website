<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <?php
    require("config/config.php");
    include("includes/classes/User.php");
    include("includes/classes/Post.php");

    //Stop access when not logged in!
    if (isset($_SESSION['username'])) {
        $userLoggedIn = $_SESSION['username'];
        //$user is to select all data from users table
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
        $user = mysqli_fetch_array($user_details_query);
    }
    else {
        header("Location: register.php");
    }


        //Get id of post
        if(isset($_GET['post_id'])) {
            $post_id = $_GET['post_id'];
        }

        //Get Likes
        $get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
        $row = mysqli_fetch_array($get_likes);
        $total_likes = $row['likes'];
        $user_liked = $row['added_by'];

        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
        $row = mysqli_fetch_array($user_details_query);

        //Like button

        //Unlike button


        //Check for previous likes
        $check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
        $num_rows = mysqli_fetch_array($check_query);

        if($num_rows > 0) {
            echo '';
        }
        else {
            echo '';
        }

    ?>

</body>
</html>