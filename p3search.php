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

  <!-- Search starts here -->
  <div class="container my-4">
    <h1>search result for <em>"<?php echo $_GET['search']?>"</em></h1>
    <?php
    $query = $_GET['search'];
    $sql="select * from threads where match (thread_title,thread_desc) against ('$query')";
    $result=mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $thread_id=$row['thread_id'];
        echo '
        <div class="result">
            <h3><a href="/program2/projects/p3thread.php?threadid='.$thread_id.'" class="text-dark">'. $title .'</a></h3>
            <p>'. $desc .'</p>
        </div>
        ';
    }
    if(mysqli_num_rows($result) == 0){
        echo '<div class="alert alert-danger" role="alert">
        <strong>Sorry!</strong> No result found for this search.
        </div>';
    }
    ?>
  </div>



  <?php include 'p3footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>