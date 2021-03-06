<?php
require("config/config.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Notification.php");

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'includes/head.php'; ?>
    <title></title>
</head>
<body class="iframe_body">

    <!-- Toggle comment -->
    <script>
        function toggle() {
            var element = document.getElementById("comment_section");

            if(element.style.display == "block")
                element.style.display = "none";
            else
                element.style.display = "block";
        }
    </script>

    <?php
    //Get id of post
    if(isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
    }

    $user_query = mysqli_query($con, "SELECT added_by, user_to FROM posts WHERE id='$post_id'");
    $row = mysqli_fetch_array($user_query);

    $posted_to = $row['added_by'];
    $user_to = $row['user_to'];

    if(isset($_POST['postComment' . $post_id])) {
        $post_body = $_POST['post_body'];
        $post_body = mysqli_escape_string($con, $post_body);
        $date_time_now = date("Y-m-d H:i:s");
        $insert_post = mysqli_query($con, "INSERT INTO comments VALUES ('', '$post_body', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$post_id')");

        //Insert notification
        if($user_to != 'none') {
            $notification = new Notification($con, $userLoggedIn);
            $notification->insertNotification($post_id, $posted_to, "comment");
        }

        if($user_to != 'none' && $user_to != $userLoggedIn) {
            $notification = new Notification($con, $userLoggedIn);
            $notification->insertNotification($post_id, $user_to, "profile_comment");
        }


        $get_commenters = mysqli_query($con ,"SELECT * FROM comments WHERE post_id='$post_id'");
        $notified_users = array();
        while($row = mysqli_fetch_array($get_commenters)) {

            if($row['posted_by'] != $posted_to && $row['posted_by'] != $user_to
                && $row['posted_by'] != $userLoggedIn && !in_array($row['posted_by'], $notified_users)) {

                $notification = new Notification($con, $userLoggedIn);
                $notification->insertNotification($post_id, $row['posted_by'], "comment_non_owner");

                array_push($notified_users, $row['posted_by']);
            }
        }

        echo "<p>Comment Posted!</p>";
    }

    ?>

    <!-- Get Profile Pic -->
    <?php
    $user_obj = new User($con, $userLoggedIn);

    $get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id=$post_id ORDER BY id DESC");
    $count = mysqli_num_rows($get_comments);

    if($count !=0) {

        while($comment = mysqli_fetch_array($get_comments)) {
                $posted_by = $comment['posted_by'];
            }
        }
     ?>

    <!-- Submit Comment -->
    <div class="mt-3" id="comment_container">
        <form action="comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="<?php echo $post_id; ?>" method="POST">
                <div class="row">
                    <div class="col-1">
                        <a href="<?php echo $userLoggedIn; ?>" target="_parent">
                    </div>
                            <img class="rounded-circle shadow-sm" id="comment_profilepic" src="<?php echo $user_obj->getProfilePic(); ?>" alt="" title="<?php echo $user_obj->getFirstAndLastName(); ?>">
                        </a>

                    <div class="col-8">
                        <textarea class="form-control" id="text_area" rows="1" name="post_body" placeholder="Write a comment..."></textarea>
                    </div>
                    <div class="col-1">
                        <button class="btn btn-outline-light btn-sm shadow-sm" type="submit" name="postComment<?php echo $post_id; ?>" value="">
                            <i class="far fa-paper-plane" data-fa-transform="grow-10"></i>
                        </button>
                    </div>
                </div>
        </form>
    </div>

    <!-- Autogrow Textarea -->
    <script>
        var textarea = document.querySelector('textarea');

        textarea.addEventListener('keydown', autosize);

        function autosize(){
          var el = this;
          setTimeout(function(){
            el.style.cssText = 'height:auto; padding:0';
            // for box-sizing other than "content-box" use:
            // el.style.cssText = '-moz-box-sizing:content-box';
            el.style.cssText = 'height:' + el.scrollHeight + 'px';
          },0);
        }
    </script>


    <!-- Load comments -->
    <?php
    $get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id=$post_id ORDER BY id DESC");
    $count = mysqli_num_rows($get_comments);

    if($count !=0) {

        while($comment = mysqli_fetch_array($get_comments)) {
            $comment_body = $comment['post_body'];
            $posted_to = $comment['posted_to'];
            $posted_by = $comment['posted_by'];
            $date_added = $comment['date_added'];
            $removed = $comment['removed'];


            //Timeframe
            $date_time_now = date("Y-m-d H:i:s");
            $start_date = new DateTime($date_added); //Time of post
            $end_date = new DateTime($date_time_now); //Current Time
            $interval = $start_date->diff($end_date); //Difference between dates
            if($interval->y >= 1) {
                if($interval == 1)
                    $time_message = $interval->y . " year ago"; //prints "1 year ago"
                else
                    $time_message = $interval->y . " years ago"; //prints "1+ year ago"
            }
            else if ($interval->m >= 1) {
                if($interval->d == 0){
                    $days = " ago";
                }
                else if($interval->d == 1){
                    $days = $interval->d . " day ago";
                }
                else {
                    $days = $interval->d . " days ago";
                }


                if($interval->m == 1) {
                    $time_message = $interval->m . " month" . $days;
                }
                else {
                    $time_message = $interval->m . " months" . $days;
                }

            }
            else if($interval->d >= 1) {
                if($interval->d == 1) {
                    $time_message = "Yesterday";
                }
                else {
                    $time_message = $interval->d . " days ago";
                }
            }
            else if ($interval->h >= 1) {
                if($interval->h == 1) {
                    $time_message = $interval->h . " hour ago";
                }
                else {
                    $time_message = $interval->h . " hours ago";
                }
            }
            else if ($interval->i >= 1) {
                if($interval->i == 1) {
                    $time_message = $interval->i . " minute ago";
                }
                else {
                    $time_message = $interval->i . " minutes ago";
                }
            }
            else {
                if($interval->s < 30) {
                    $time_message = "Just now";
                }
                else {
                    $time_message = $interval->s . " seconds ago";
                }
            } //-- End Timestamp --//

            $user_obj = new User($con, $posted_by);

            ?>

            <!-- load comment -->
            <div class="container" id="comment_loadposts">
                <div class="row">
                    <div class="col-1" >
                        <a href="<?php echo $posted_by; ?>" target="_parent">
                    </div>
                            <img class="rounded-circle shadow-sm" src="<?php echo $user_obj->getProfilePic(); ?>" alt="" title="<?php echo $posted_by; ?>">
                        </a>

                    <div class="col-9" id="load_textcomment">
                        <a href="<?php echo $posted_by; ?>" target="_parent">
                            <?php echo $user_obj->getFirstAndLastName(); ?>
                        </a><br>
                        <?php echo $comment_body; ?>
                    </div>
                </div> <!-- End Row -->
                <!-- Time Message -->
                <span><?php echo $time_message; ?></span><br>

            </div>

            <?php
        } //-- End While --//
    }
    else {
        echo "<div class='center'>
                No Comments to Show!
            </div>";
    } //-- End If Else --//

    ?>



<?php include 'includes/scripts.php'; ?>

</body>
</html>
