<?php
session_start();
echo '<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark" >
  <div class="container-fluid">
    <a class="navbar-brand" href="p3index.php">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="p3index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="p3about.php">About</a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Top Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
          $sql = "SELECT category_name, category_id FROM `categories` LIMIT 3";
          $result = mysqli_query($conn, $sql); 
          while($row = mysqli_fetch_assoc($result)){
          echo '<a class="dropdown-item" href="p3threads.php?catid='. $row['category_id']. '">' . $row['category_name']. '</a>'; 
         }
        echo '</div>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="p3contact.php">Contact</a>
        </li>
      </ul>';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  echo '<form class="d-flex" role="search" action="p3search.php" method="get">
        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-primary me-2" type="submit">Search</button>
        <button  class="btn btn-primary me-2" href="p3logout.php">' . $_SESSION['useremail'] . '</button>
        <a role="button" href="p3logout.php" class="btn btn-outline-primary me-2">Logout</a>
        </form>';
} else {
  echo '<form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-primary me-2" type="submit">Search</button>
        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#loginmodal">login</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signupmodal">signup</button>
        </form>';
}

echo '</div>
  </div>
</nav>';


include 'p3loginmodal.php';
include 'p3signupmodal.php';
if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
  echo '<div class="alert mb-0 alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> You can now login
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
