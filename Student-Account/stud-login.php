<!--  
 # index page the landing page
 # include 'connect.php' file to connect in the database  from seperated file
 # login -> is for allow the user to login 
         -> listening for submit button name
-->
<?php 

include 'conn.php';

session_start();

error_reporting(0);

// if(isset($_SESSION['username'])){
//   header("Location: index.php");
// }

// login
if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

  $_SESSION['email-login'] = $email;

	$sql = "SELECT * FROM student_acc WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);
	
  if ($result->num_rows > 0) { $row = mysqli_fetch_assoc($result);
$_SESSION['email'] = $row['email']; header("Location: ./pages/home.php");
}else { 
  echo "<script>alert('Invalid!! Email or Password is Wrong.')</script>";
  } } ?>

<!-- THi is the html code -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SVCC LMS</title>
    <!-- <link rel="stylesheet" href="./stud-login.css" /> -->
    <link rel="stylesheet" href="./stud-login.css?php echo time(); ?>">

    <!-- font awesome -->
    <script
      src="https://kit.fontawesome.com/b014a35e35.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <div id="container">
      <div class="title">
        <!-- <h2>Library Management System</h2> -->
      </div>
      <div class="overlay">
        <div class="login-box">
          <div class="admin-logo">
            <img src="./images/student-logo.png" alt="" />
            <h4>Student Login</h4>
            <!-- <p class="form-txt">Student login</p> -->
          </div>

          <!-- form -->
          <form action="" method="POST" class="login-form">
            <div class="form-input">
              <i class="fa-solid fa-user icon"></i>
              <input
                type="email"
                name="email"
                placeholder="Email"
                autocomplete="off"
                required
              />
            </div>
            <div class="form-input">
              <i class="fa-solid fa-lock icon"></i>
              <input
                type="password"
                name="password"
                placeholder="Password"
                required
              />
            </div>
            <div class="bottom-content">
              <button name="submit" id="login">Login</button>
            </div>
            <p class="stud-login">
              Login as <span><a href="../index.php">Admin</a></span>
            </p>
            <div class="register-wrapp">
              <a href="./stud-register.php" class="register">Register Here</a>
            </div>
          </form>
        </div>
        <!-- end of login form -->
      </div>

      <footer>
        <div class="footer">
          <div class="left-box">
            <div class="left-content">
              <h3>SVCC LMS</h3>
              <p>
                Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                Consequuntur similique dolorem totam consequatur reprehenderit
                sapiente? Possimus excepturi ad dolore similique.
              </p>
            </div>
          </div>

          <div class="right-box">
            <div class="right-content">
              <i class="fa-solid fa-location-dot"></i>
              <p>Brgy. Mamatid Cabuyao Laguna</p>
            </div>
            <div class="right-content">
              <i class="fa-solid fa-phone"></i>
              <p>+49 531 1671</p>
            </div>
            <div class="right-content">
              <i class="fa-solid fa-globe"></i>
              <a href="#">stvincentcollege.edu.ph</a>
            </div>
            <div class="right-content">
              <i class="fa-brands fa-facebook-messenger"></i>
              <a href="https://www.facebook.com/svcccabuyaoofficial/?ti=as"
                >Send a message</a
              >
            </div>
          </div>
        </div>

        <div class="social-media">
          <i class="fa-brands fa-facebook"></i>
          <i class="fa-brands fa-twitter"></i>
          <i class="fa-brands fa-telegram"></i>
          <i class="fa-brands fa-google-plus"></i>
        </div>
        <div class="copyright">
          <p>Copyright &copy 2022 SVCC. All Rights Reserved</p>
        </div>
      </footer>
    </div>
  </body>
</html>
