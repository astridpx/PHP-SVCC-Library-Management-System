<?php
include 'conn.php';

error_reporting(0);
session_start();

// if (isset($_SESSION['username'])) {
//   header("Location: index.php");
// }

if (isset($_POST['submit'])) {
#declaring variables for to get the inputs
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

// input transform
// $titleTrans  = strtoupper($title);
$fullnameTrans  = ucwords($fullname);
$emailTrans  = strtolower($email);

#try if the password match in confirm field of password
if ($password == $cpassword) {
  #try if the email is already exist
  $sql = "SELECT * FROM student_acc WHERE email='$emailTrans'";
  $result = mysqli_query($conn, $sql);

// if name is existt
  $sql2 = "SELECT * FROM student_acc WHERE fullname='$fullnameTrans'";
  $result2 = mysqli_query($conn, $sql2);

  if (!$result->num_rows > 0 && !$result2->num_rows > 0) {
    # inserting the user input data in database/mysql
    $sql = "INSERT INTO student_acc (fullname, email, password)
        VALUES ('$fullnameTrans', '$emailTrans', '$password')";
    $result = mysqli_query($conn, $sql);
    #if the inserting data is completed
    if ($result) {  
      echo "<script>alert('Congratulations! Registration Completed.')</script>";
      $fullnameTrans = "";
      $emailTrans = "";
      $_POST['password'] = "";
      $_POST['cpassword'] = "";

    } else {
      # if there is an error in connecting database
      echo "<script>alert('Woops! Something Wrong Went.')</script>";  
    }

  } else if ($result->num_rows > 0 && !$result2->num_rows > 0) {
    echo "<script>alert('Woops! Email Already Exist.')</script>";
  }else if (!$result->num_rows > 0 && $result2->num_rows > 0) {
    echo "<script>alert('Woops! Name is Already Exist.')</script>";
  } else {
    #alert if the email is already exist
    echo "<script>alert('Woops! Thos Person is Already Exist.')</script>";
  }
  
} else {
  #alert if the password didnt matched
  echo "<script>alert('Password Not Matched.')</script>";
}
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="stud-register.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SVCC LMS</title>
  </head>
  <body>
    <div class="banner">
      <div class="overlay">
        <div class="container">
          <div class="title">Registration</div>
          <div class="content">
            <!-- form -->
            <form action="#" method="POST">
              <div class="user-details">
                <div class="input-box">
                  <span class="details">Full Name</span>
                  <input
                    type="text"
                    placeholder="Enter your name"
                    name="fullname"
                    autocomplete="off"
                    required
                  />
                </div>
              
                <div class="input-box">
                  <span class="details">Email</span>
                  <input
                    type="text"
                    placeholder="Enter your email"
                    name="email"
                    autocomplete="off"
                    required
                  />
                </div>
                <div class="input-box">
                  <span class="details">Password</span>
                  <input
                    type="password"
                    placeholder="Enter your password"
                    name="password"
                    required
                  />
                </div>
                <div class="input-box">
                  <span class="details">Confirm Password</span>
                  <input
                    type="password"
                    placeholder="Confirm your password"
                    name="cpassword"
                    required
                  />
                </div>
              </div>
              <div class="button">
                <input type="submit" name="submit" value="Register" />
              </div>
              <div class="login">
                <a href="./stud-login.php">Login Here</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
