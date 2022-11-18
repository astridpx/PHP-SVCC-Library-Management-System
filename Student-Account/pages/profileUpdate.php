<?php
include '../conn.php';

// This will prevent to access the page through typing url 
if(!isset($_SERVER['HTTP_REFERER'])){
  header('location: ../stud-login.php');
  exit;
}


// This will prevent to access the page through typing url 
if(!isset($_SERVER['HTTP_REFERER'])){
  header('location: ../stud-login.php');
  exit;
}

// getting the email from login
session_start();
$emailLogin = $_SESSION['email-login'];

$sql_fname ="SELECT * FROM student_acc WHERE email='$emailLogin'";
$result_fname = $conn -> query($sql_fname);
if ($result_fname->num_rows > 0) {
  while($row = $result_fname -> fetch_assoc()){
    $fullname = $row['fullname'];
  }}

  if (isset($_POST['update'])) {
    #declaring variables for to get the inputs
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // transform input
    $fullnameTrans  = ucwords($fullname);
    $emailTrans  = strtolower($email);

    #try if the email is already exist
    $sql = "SELECT * FROM student_acc WHERE email='$emailTrans'";
    $result = mysqli_query($conn, $sql);
    
    if ($result->num_rows  <= 1  ) {
      while($row = $result -> fetch_assoc()){
        $emailExist = $row['email'];
        // echo $emailExist;
      }
      if (!$result->num_rows  > 0 || $emailLogin == $emailExist ){
        // echo $emailLogin;
        // echo $emailExist;
          // UPDATE QUERY
          $query = "UPDATE student_acc SET fullname='$fullnameTrans', email='$emailTrans', password='$password'
          WHERE email='$emailLogin'";
          $resultUpdate = mysqli_query($conn, $query);

          $queryIssue = "UPDATE issue_book SET stud_name='$fullnameTrans', email='$emailTrans' 
          WHERE email='$emailLogin'";
          $resultIssue = mysqli_query($conn,$queryIssue);

          $queryHistory = "UPDATE student_all_record SET stud_name='$fullnameTrans', email='$emailTrans'
          WHERE email='$emailLogin'";
          $resultHistory = mysqli_query($conn,$queryHistory);

  
          #if the inserting data is completed
          if ($resultUpdate && $resultIssue && $resultHistory) {  
            echo "<script>alert('Congratulations! Profile Update Success. Please Login Again');
            window.location.href = '../stud-login.php';</script>";
          } else {
            # if there is an error in connecting database
            // echo "<script>alert('Woops! Something Wrong Went.')</script>";  
            echo "error ". mysqli_error($conn);
          }
      }else{
        echo "<script>alert('Woops! Email Already Existed!!.')</script>";
      }
    } else{
      echo "<script>alert('Woops! Email Already Existed In Another Person.')</script>";
    }
  
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
    <link rel="stylesheet" href="../Styles/update.css " />
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
      <div class="content-wrapper">
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
                    <i class="bx bx-book icon"></i>
                    <span class="link">Transactions</span>
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

        <section>
          <form action="" method="POST">
            <h2>Update Profile</h2>
            <div class="form-field">
              <label for="fullname">Fullname :</label>
              <input
                type="text"
                name="fullname"
                placeholder="Fullname"
                autocomplete="off"
              />
            </div>
            <div class="form-field">
              <label for="email">Email :</label>
              <input
                type="email"
                name="email"
                placeholder="Email"
                autocomplete="off"
              />
            </div>
            <div class="form-field">
              <label for="password">Password :</label>
              <input
                type="password"
                name="password"
                placeholder="Password"
                autocomplete="off"
              />
            </div>
            <button type="submit" name="update" id="btn-update">Update</button>
          </form>
        </section>
      </div>
    </div>
  </body>
</html>
