<?php

// This will prevent to access the page through typing url 
if(!isset($_SERVER['HTTP_REFERER'])){
  header('location: index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SVCC LMS</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./css/dashboard.css" />
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
          <img src="./images/open-book-logo.jpg" class="logo-pic" />
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
            <img src="images/admin2.png" id="profile" />
            <span class="user-menu">Admin</span>
          </div>

          <div class="sidebar-content">
            <ul class="lists">
              <!-- dashboard -->
              <li class="list dashboard">
                <a href="student-records.php" class="nav-link">
                  <i class="bx bx-home-alt icon" id="active"></i>
                  <span class="link" id="active">Dashboard</span>
                </a>
              </li>
              <!-- student -->
              <li class="list">
                <a href="student-records.php" class="nav-link">
                  <i class="bx bx-book-reader icon"></i>
                  <span class="link">Student</span>
                </a>
              </li>
              <!-- Issue Books -->
              <li class="list">
                <a href="issue-book.php" class="nav-link">
                  <i class="bx bx-book-bookmark icon"></i>
                  <span class="link">Issue Books</span>
                </a>
              </li>
              <!-- Return books -->
              <li class="list">
                <a href="return-book.php" class="nav-link">
                  <i class="bx bx-library icon"></i>
                  <span class="link">Return Books</span>
                </a>
              </li>
              <!-- Books -->
              <li class="list">
                <a href="books.php" class="nav-link">
                  <i class="bx bx-book icon"></i>
                  <span class="link">Books</span>
                </a>
              </li>
              <div class="bottom-cotent">
                <!-- logout -->
                <li class="list">
                  <a href="index.php" class="nav-link">
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
        <div class="card student-card">
          <h2>Student</h2>
          <img src="./images/student-reading.jpg" class="card-icon" />
        </div>

        <div class="card issue-book-card">
          <h2>Issue Books</h2>
          <img src="./images/issue-book.jpg" class="card-icon" />
        </div>

        <div class="card return-books-card">
          <h2>Return book</h2>
          <img src="./images/return-book.jpg " class="card-icon" />
        </div>

        <div class="card book-card">
          <h2>Books</h2>
          <img src="./images/book.jpg" class="card-icon" />
        </div>
      </div>
      <!-- end of card wrapper -->
    </div>
  </body>
  
  <!-- <script src="JS/script.js"></script> -->
  <script type="">
    let wrapperCard = document.querySelector(".wrapper-card");
let students = document.querySelector(".student-card");
let issueBook = document.querySelector(".issue-book-card");
let allRecords = document.querySelector(".return-books-card");
let books = document.querySelector(".book-card");

// student card link
students.addEventListener("click", () => {
  // console.log("hello");
  window.location.href = "student-records.php";
});

issueBook.addEventListener("click", () => {
  // console.log("hello");
  window.location.href = "issue-book.php";
});

allRecords.addEventListener("click", () => {
  window.location.href = "return-book.php";
});

books.addEventListener("click", () => {
  window.location.href = "books.php";
});

  </script>
</html>
