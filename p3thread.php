<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>welcome to iDiscuss coading-forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'p3dbconnect'; ?>
    <?php include 'p3header.php'; ?>

    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];

        // Query the users table to find out the name of OP
        $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_email'];
    }

    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        //Insert into comment db
        $comment = $_POST['comment'];
        $comment = str_replace("<", "&lt;", $comment);
        $comment = str_replace(">", "&gt;", $comment);
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your comment has been added!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </div>';
        }
    }
    ?>

    <div class="container mt-3" style="background-color:rgb(206, 210, 214); border-radius: 5px;">
        <div class="jumbotron">
            <h1 class="display-3"><?php echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is allowed. Do not post “offensive” posts, links or images.</p>
            <p>Posted by: <em><?php echo $posted_by; ?></em></p>
        </div>
    </div>

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '<div class="container">
              <h1 class="py-2">Post a Comment</h1> 
              <form action= "' . $_SERVER['REQUEST_URI'] . '" method="post"> 
                <div class="form-group">
                    <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Write comment..."></textarea>
                    <input type="hidden" name="sno" value="' . $_SESSION["sno"] . '">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
              </form> 
              </div>';
      } 
    else {
        echo '<div class="container">
               <h1 class="py-2">Post a Comment</h1> 
               <p class="lead">You are not logged in. Please login to be able to post comments.</p>
              </div>';
        }
    ?>


    <div class="container" id="ques">
        <h1 class="py-2">Discussions</h1>
        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $thread_user_id = $row['comment_by'];

            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            // Check if $row2 is not null
            if ($row2) {
                $user_email = $row2['user_email'];
            } else {
                $user_email = "Unknown User"; // Fallback if user not found
            }

            echo '<div class="row my-3">
            <div class="col-md-1">
                <img src="../images/defoultuser.png" class="mx-4" width="50px" alt="Responsive image">
            </div>
            <div class="media-body col-md-11">
                <p class="font-weight-bold my-0">' . $user_email . ' at ' . $comment_time . '</p> ' . $content . '
            </div>
          </div>';
        }

        // echo "this is good";
        // echo var_dump($noResult);
        if ($noResult) {
            echo '<div class="container jumbotron" style="background-color:rgb(206, 210, 214); border-radius: 5px;">
                        <p class="display-4">No Comments Found</p>
                        <p class="lead"> Be the first person to comment</p>
                 </div> ';
        }

        ?>

    </div>

    <?php include 'p3footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>