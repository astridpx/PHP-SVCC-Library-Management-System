<?php
include '../conn.php';

error_reporting(0);

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

$sql = "SELECT * FROM book_list";
$result = $conn -> query($sql);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSS -->
    <link rel="stylesheet" href="../Styles/book.css" />
    <!-- Boxicons CSS -->
    <link
      href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
      rel="stylesheet"
    />
    <title>SVCC LMS</title>
  </head>

  <body>
    <div class="container">
      <!-- End of hidden form -->

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
            <span class="user-menu"><?php echo $fullname?></span>
          </div>

          <div class="sidebar-content">
            <ul class="lists">
              <!-- dashboard -->
              <li class="list">
                <a href="home.php" class="nav-link">
                  <i class="bx bx-home-alt icon"></i>
                  <span class="link">Home</span>
                </a>
              </li>
              <!-- Issue Books -->
              <li class="list">
                <a href="issue.php" class="nav-link">
                  <i class="bx bx-book-bookmark icon"></i>
                  <span class="link">Issue Books</span>
                </a>
              </li>
              <!-- All Records -->
              <li class="list">
                <a href="return.php" class="nav-link">
                  <i class="bx bx-library icon"></i>
                  <span class="link">Return Books</span>
                </a>
              </li>
              <!-- Books -->
              <li class="list">
                <a href="book.php" class="nav-link">
                  <i class="bx bx-book icon" ></i>
                  <span class="link" >Books</span>
                </a>
              </li>
              <!-- Books transactions -->
              <li class="list">
                <a href="pending.php" class="nav-link">
                  <i class="bx bx-book icon" id="active"></i>
                  <span class="link" id="active">Transactions</span>
                </a>
              </li>
            </ul>
            <!-- End of list -->

            <div class="bottom-cotent">
              <!-- logout -->
              <li class="list">
                <a href="../logout.php" class="nav-link">
                  <i class="bx bx-log-out icon a"></i>
                  <span class="link">Logout</span>
                </a>
              </li>
            </div>
          </div>
        </div>
      </nav>
      <!-- ######################
          END OF SIDEBAR
         #######################-->

      <div class="table-wrapper">
        <h2 style="background-color:#E14D2A;">TRANSACTIONS</h2>
        
        <div class="fixTableHead">
          <table>
            <thead >
              <tr>
                <th style="background-color: #E14D2A;" id="bookID">ISBN</th>
                <th style="background-color: #E14D2A;">Book Title</th>
                <th style="background-color: #E14D2A;">Name of Author</th>
                <th style="background-color: #E14D2A;">Date Issue</th>
              </tr>
            </thead>
            <tbody>
         <?php
          
              // select * from TableB where Accountid not in (select ID from TableA)
              // SELECT * FROM Customers ORDER BY Country;
             $sql = "SELECT  * FROM issue_book WHERE stud_name ='$fullname'";
             $result = mysqli_query($conn, $sql);
          
           if ($result->num_rows > 0) {
             while($row = $result -> fetch_assoc()){

               // fetching the author where isbn is = isbn of the acc
              $sql2 = "SELECT  * FROM book_list WHERE isbn ='$row[isbn]'";
              $result2 = mysqli_query($conn, $sql2);
              if ($result2->num_rows > 0) {
                while($row2 = $result2 -> fetch_assoc())
                $author = $row2['author'];
              }
  
               ?>
                 <tr>
                     <td><?php echo $row['isbn']; ?></td>
                     <td><?php echo $row['title']; ?></td>
                     <td><?php echo $author; ?></td>
                     <td><?php echo $row['issue_date']; ?></td>
                   </tr>
               <?php 
               
       
             }
           }else{
             ?>   
            <h4 style="text-align: center;">No Books Borrowed</h4> 
             <?php
           }   
           ?>
           
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script>
      // variables
      let btnAdd = document.querySelector("#btn-return");
      let addForm = document.querySelector(".screen-overlay");
      let save = document.querySelector("#save");
      let cancel = document.querySelector("#cancel");

      btnAdd.addEventListener("click", () => {
        addForm.style.top = "0";
      });
      cancel.addEventListener("click", () => {
        console.log("hello button was clicked");
        // addForm.style.top = "0";
      });
    </script>
  </body>
</html>
