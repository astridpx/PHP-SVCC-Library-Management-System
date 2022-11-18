<?php

include '../conn.php';

// This will prevent to access the page through typing url 
if(!isset($_SERVER['HTTP_REFERER'])){
  header('location: ../stud-login.php');
  exit;
}

session_start();
$emailLogin = $_SESSION['email-login'];

$sql_fname ="SELECT * FROM student_acc WHERE email='$emailLogin'";
$result_fname = $conn -> query($sql_fname);
if ($result_fname->num_rows > 0) {
  while($row = $result_fname -> fetch_assoc()){
    $fullname = $row['fullname'];
  }}
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SVCC LMS</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../Styles/home.css?php echo time(); ?> " />
    <!-- Boxicons CSS -->
    <link
      href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <div class="container">
      <header class="navbar">
        <div class="logo">
          <img src="../images/open-book-logo.jpg" class="logo-pic" />
          <h3>SVCC LMS</h3>
        </div>
        <div class="title">
          <h3>Library Management System</h3>
        </div>
      </header>

      <!-- ######################
          START OF SIDEBAR
         #######################-->
      <nav class="open">
        <div class="sidebar">
          <div class="underline"></div>
          <div class="menu">
            <img src="../images/student-logo.png" id="profile" />
            <span class="user-menu"><?php echo $fullname ?></span>
          </div>

          <div class="sidebar-content">
            <ul class="lists">
              <!-- dashboard -->
              <li class="list dashboard">
                <a href="home.php" class="nav-link">
                  <i class="bx bx-home-alt icon" id="active"></i>
                  <span class="link" id="active">Home</span>
                </a>
              </li>
              <!-- Issue Books -->
              <li class="list">
                <a href="issue.php" class="nav-link">
                  <i class="bx bx-book-bookmark icon"></i>
                  <span class="link">Issue Books</span>
                </a>
              </li>
              <!-- Return books -->
              <li class="list">
                <a href="return.php" class="nav-link">
                  <i class="bx bx-library icon"></i>
                  <span class="link">Return Books</span>
                </a>
              </li>
              <!-- Books -->
              <li class="list">
                <a href="book.php" class="nav-link">
                  <i class="bx bx-book icon"></i>
                  <span class="link">Books</span>
                </a>
              </li>
               <!-- Books transactions -->
               <li class="list">
                <a href="pending.php" class="nav-link">
                  <i class="bx bx-book icon" ></i>
                  <span class="link" >Transactions</span>
                </a>
              </li>
              <!-- prrofile -->
              <li class="list">
                  <a href="profileUpdate.php" class="nav-link">
                    <i class="bx bx-user-circle icon"></i>
                    <span class="link">My Account</span>
                  </a>
                </li>
                <div class="bottom-cotent">
                  <!-- logout -->
                  <li class="list">
                    <a href="../logout.php" class="nav-link">
                      <i class="bx bx-log-out icon a"></i>
                      <span class="link">Logout</span>
                    </a>
                  </li>
                </div>
            </ul>
            <!-- End of list -->
          </div>
        </div>
      </nav>
      <!-- ######################
          END OF SIDEBAR
         #######################-->

      <div class="display-content"></div>
      <!-- Wrapper Card -->
      <div class="wrapper-card">
        <div class="card issue-book-card">
          <h2>Issue Books</h2>
          <img src="../images/issue-book.jpg" class="card-icon" />
        </div>

        <div class="card return-books-card">
          <h2>Return book</h2>
          <img src="../images/return-book.jpg " class="card-icon" />
        </div>

        <div class="card book-card">
          <h2>Book List</h2>
          <img src="../images/book.jpg" class="card-icon" />
        </div>
      </div>
      <!-- end of card wrapper -->
    </div>
    <script>
      let issueBook = document.querySelector(".issue-book-card");
      let allRecords = document.querySelector(".return-books-card");
      let books = document.querySelector(".book-card");

      issueBook.addEventListener("click", () => {
        window.location.href = "issue.php";
      });

      allRecords.addEventListener("click", () => {
        window.location.href = "return.php";
      });

      books.addEventListener("click", () => {
        window.location.href = "book.php";
      });
    </script>
  </body>
  <!-- <script src="./JS/script.js"></script> -->
</html>
