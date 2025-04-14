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
  $id = $_GET['catid'];
  $sql = "SELECT * FROM `categories` WHERE category_id=$id";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $catname = $row['category_name'];
    $catdesc = $row['category_description'];
  }
  ?>

  <?php
  $showAlert = false;
  $method = $_SERVER['REQUEST_METHOD'];
  if ($method == 'POST') {
    // Get and trim the input values
    $title = trim($_POST['title']);
    $desc = trim($_POST['desc']);
    $sno = $_POST['sno'];

    $th_title = str_replace("<", "&lt;", $th_title);
    $th_title = str_replace(">", "&gt;", $th_title);
    $th_desc = str_replace("<", "&lt;", $th_desc);
    $th_desc = str_replace(">", "&gt;", $th_desc);

    // Check if the inputs are empty after trimming
    if (empty($title) || empty($desc)) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                 <strong>thread is empty!</strong> Please fill in all the fields before submitting.
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    } else {
      // Proceed with inserting into the database
      $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) 
                VALUES ('$title', '$desc', '$id', '$sno', current_timestamp())";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        $showAlert = true;
      }
      if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                 <strong>Success!</strong> Your thread has been added!
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
    }
  }
  ?>


  <div class="container mt-3" style="background-color:rgb(206, 210, 214); border-radius: 5px;">
    <div class="jumbotron">
      <h1 class="display-3">Welcome to <?php echo $catname ?> Discussions</h1>
      <p class="lead"><?php echo $catdesc ?></p>
      <hr class="my-4">
      <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is allowed. Do not post “offensive” posts, links or images.</p>
      <a class="btn btn-primary btn-lg mb-3" href="#" role="button">Learn more</a>
    </div>
  </div>
  <?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo '<div class="container">
        <h1 class="py-2">Ask Questions - </h1>
        <form action= "' . $_SERVER['REQUEST_URI'] . '" method="post"> 
          <div class="form-group">
            <label for="problemtitle">Problem Title</label>    
            <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" placeholder="Enter a short and crisp title" required>
          </div>
          <div class="form-group">
            <label for="desc">Ellaborate Your Concern</label>
            <textarea class="form-control" id="desc" name="desc" rows="3" placeholder="description..." required></textarea>
            <input type="hidden" name="sno" value="' . $_SESSION["sno"] . '">
            <button type="submit" class="btn btn-primary my-3">Submit</button>
          </div>
        </form>
       </div>';
  } else {
    echo '<div class="container">
            <h1 class="py-2">Ask Questions - </h1>
            <p class="lead">You are not logged in. Please login to be able to ask questions.</p>
         </div>';
  }
  ?>


  <div class="container">
    <h1 class="py-2">Browse Questions - </h1>
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while ($row = mysqli_fetch_assoc($result)) {
      $noResult = false;
      $title = $row['thread_title'];
      $desc = $row['thread_desc'];
      $id = $row['thread_id'];
      $thread_time = $row['timestamp'];
      $thread_user_id = $row['thread_user_id'];
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
              <div class="col-md-11">
                  <h5 class="mt-0"><a href="p3thread.php?threadid=' . $id . '" class="text-dark text-decoration-none">' . $title . '</a></h5>
                  <p>' . $desc . '</p>
                  <p class="text-start font-weight-bold my-0">Posted by: <em>' . $user_email . ' At ' . $thread_time . '</em></p>
              </div>
            </div>';
    }
    if ($noResult) {
      echo '<div class="container jumbotron" style="background-color:rgb(206, 210, 214); border-radius: 5px;">
                    <p class="display-6">No Threads Found</p>
                    <p class="lead">Be the first person to ask a question</p>
            </div>';
    }
    ?>
    <!-- <div class="row my-1">
      <div class="col-md-1">
        <img src="../images/defoultuser.png" class="mr-3" width="70px" alt="Responsive image">
      </div>
      <div class="col-md-11">
        <h5 class="mt-0"><a href="p3thread.php" class="text-dark text-decoration-none">unable to install pandas</a></h5>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit culpa, et hic reiciendis soluta
          ratione quasi voluptate. Nihil doloremque cum dolorem, culpa molestias magni rem magnam mollitia
          dolores quod recusandae!</p>
      </div>
    </div> -->
  </div>

  <?php include 'p3footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>