
<?php

include '../conn.php';

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
  


// $sql_issue = "SELECT * FROM issue_book WHERE stud_name='$fullname'"; 
// $result_issue = $conn -> query($sql_issue);
// if ($result_issue->num_rows > 0) {
//   while($row_issue = $result_issue -> fetch_assoc()){
//     $vali_isbn= $row_issue['isbn'];
//     $vali_title = $row_issue['title'];
//     $vali_name = $row_issue['stud_name'];
//      $vali_email = $row_issue['email'];
//   }}

// get the value of form
if (isset($_GET['submit'])){
  #get the value in isbn
  $isbn = $_GET['isbn'];
  $title =$_GET['title'];
  $name =$_GET['name'];
  $email =$_GET['email'];


  # connect into database
  $sql = "SELECT * FROM issue_book WHERE isbn='$isbn'";
  $result = $conn -> query($sql);

  if ($result->num_rows > 0) {
    while($row = $result -> fetch_assoc()){
      $valid_isbn= $row['isbn'];
      $valid_title= $row['title'];
      $valid_name= $row['stud_name'];
      $valid_email = $row['email'];
    }
        # delete script
        if($valid_isbn == $isbn && $valid_title == $title && $email == $emailLogin  && $email == $valid_email && $name == $fullname){
          $sql_delete = "DELETE FROM issue_book WHERE isbn='$isbn'";
          $result_delete = mysqli_query($conn, $sql_delete);
          
          if($result_delete){

            echo "<script>alert('Deleted Successfully');window.location.href = 'return.php';</script>";
          }
          // echo "$valid_isbn = $isbn";
          // echo "$valid_email = $email";
          // echo "$fullname = $name";
          // echo "$valid_title = $title";
          
          // $sql2 = "DELETE FROM issue_book WHERE title='$title'";
          // $sql3 = "DELETE FROM issue_book WHERE stud_name='$fullname'";
          // $sql4 = "DELETE FROM issue_book WHERE email='$emailLogin'";
  
        
        }else if($valid_isbn != $isbn && $valid_title == $title && $email == $emailLogin  &&  $email == $valid_email && $name == $fullname){
          echo "<script type='text/javascript'>alert('Your ISBN must be correct. ERROR: \"{$isbn}\"');</script>";

        }else if($valid_isbn == $isbn && $valid_title != $title && $email == $emailLogin  &&  $email == $valid_email && $name == $fullname){
          echo "<script type='text/javascript'>alert('You don\'t borrow book with name of: \"{$title}\"');</script>";
        
        }else if($valid_isbn == $isbn && $valid_title == $title && $email != $emailLogin &&  $email == $valid_email && $name == $fullname){
          echo "<script type='text/javascript'>alert('The email in this account is not yours: \"{$email}\"');</script>";
       
        }else if($valid_isbn == $isbn && $valid_title == $title && $email != $emailLogin &&  $email != $valid_email && $name == $fullname){
          echo "<script type='text/javascript'>alert('There is no email registered here: \"{$email}\"');</script>";
       
        }else if($valid_isbn == $isbn && $valid_title == $title && $email == $emailLogin &&  $email != $valid_email && $name == $fullname){
          echo "<script type='text/javascript'>alert('You cannot return books that is not in your email \"{$email}\"');</script>";
       
        }else if($valid_isbn == $isbn && $valid_title == $title && $email == $emailLogin  &&  $email == $valid_email && $name != $fullname){
          echo "<script type='text/javascript'>alert('You cannot return books that is not in your name \"{$name}\"');</script>";
       
        } else{
          echo "<script type='text/javascript'>alert('WE CAN\'T FIND THE DATA YOU ENTER. MAKE SURE THE SPELLING IS CORRECT');</script>";
          // echo "$name = $valid_name = $fullname" ;
        }
}else{
  echo "<script type='text/javascript'>alert('No records found with ISBN of \"{$isbn}\".');</script>";
}
} // END OF SUBMIT

 // get the value of scann
 if(isset($_GET['scan'])){
  
    # get the value of isbn scanned from hidden form
    $isbnScan = $_GET['isbnScan'];
    
    $sql = "SELECT * FROM issue_book WHERE isbn='$isbnScan'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0){
      $row = $result -> fetch_assoc();

      $isbnVal =  $row['isbn'];
      $titleVal =  $row['title'];
      $nameVal =  $row['stud_name'];
      $emailVal =  $row['email'];  
    }else{
      echo "<script type='text/javascript'>alert('No Records found of ISBN with value of {$isbnScan}');</script>";
      
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
      <link rel="stylesheet" href="../Styles/return.css" />   
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
              <!-- return books -->
              <li class="list">
                <a href="return.php" class="nav-link">
                  <i class="bx bx-library icon" id="active"></i>
                  <span class="link" id="active">Return books</span>
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

      <!-- Return form -->
      <div class="form-wrapp" style="background-image: url('../images/return-book-form.jpg');">
        <div class="overlay"> </div>

        <div class="add-form">
          <h3>Return Books</h3>

          <!-- video scan -->
          <div class="qrcode-box">
            <h4>Scan by QR CODE</h4>
            <div class="image-box">
              <p class="qr-text">Camera is Off</p>
              <video id="preview"></video>
            </div>
            <div class="qr-buttons">
              <button type="button" id="btn-scan">Scan</button>
              <button type="button" id="btn-stop">Stop</button>
            </div>
          </div>
          
          <!-- hidden scan form -->
          <form action="" method="GET" style="display: none;" >
          <input type="text" name="isbnScan"  id="isbnScan">
          <button type="submit" name="scan" id="scanClick">auto click</button>
          </form>

          <!-- form  input -->
          <form action="" method="GET" class="return-form">
            <div class="form-input">
              <label for="isbn">ISBN: </label>
             
              <input type="text" name="isbn" id="isbn" value="<?php if(isset($isbnVal)){echo $isbnVal; }?>" <?php if(isset($isbnVal)){ ?>readonly="readonly"<?php ;}?> autocomplete="off"  required />
            </div>
            <div class="form-input">
              <label for="title">Title:</label>
              <input type="text" name="title" id="" value="<?php if(isset($titleVal)){echo $titleVal;} ?>"  <?php if(isset($isbnVal)){ ?>readonly="readonly"<?php ;}?> autocomplete="off" required/>
            </div>
            <div class="form-input">
              <label for="dateReturn">Date Return:</label>
              <input type="date" name="dateReturn" id="date" <?php if(isset($isbnVal)){ ?>readonly="readonly"<?php ;}?> required />
            </div>
            <div class="form-input">
              <label for="name">Student Name:</label>
              <input type="text" name="name" id="" value="<?php if(isset($nameVal)){echo $nameVal;}else{ echo $fullname;} ?>" <?php if(isset($isbnVal)){ ?>readonly="readonly"<?php ;}?> autocomplete="off" required/>
            </div>
            <div class="form-input">
              <label for="email">Email:</label>
              <input type="email" name="email" id="" value="<?php if(isset($emailVal)){echo $emailVal;}else{ echo $emailLogin;} ?>" <?php if(isset($isbnVal)){ ?>readonly="readonly"<?php ;}?> autocomplete="off" required/>
            </div>
            <div class="btn-form">
              <button name="submit" id="save">Save</button>
              <button type="button" id="cancel">Clear</button>
            </div>  
          </form>
        </div>
      </div>
      <!-- End of form -->
    </div>

    <!-- js script -->
    <script>
      // variables
      let btnAdd = document.querySelector("#btn-return");
      let addForm = document.querySelector(".return-form");
      let save = document.querySelector("#save");
      let cancel = document.querySelector("#cancel");
      let startScan = document.querySelector("#btn-scan");
      let stopScan = document.querySelector("#btn-stop");

      // set the date to current date
      let date =document.querySelector('#date').valueAsDate = new Date();


      cancel.addEventListener("click", () => {
        console.log("hello button was clicked");
        addForm.reset();
      });
    </script>

    <!-- ===============
      QR CODE SCANNER SCRIPT
    ====================-->
    <!-- jquery script -->
    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous"
    ></script>
    <!-- isntaScan script -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    
    <script type="text/javascript">
      var scanner = new Instascan.Scanner({
        video: document.getElementById("preview"),
        scanPeriod: 5,
        mirror: false,
      });
 
      scanClick.addEventListener('click',()=>{
          console.log("heladpja");
        })
      // display the value decode
      scanner.addListener("scan", function (content) {
        let isbnScan = document.querySelector('#isbnScan').value = content;
        let scanClick = document.querySelector('#scanClick');
        
        // automatic click
        scanClick.click();
        scanner.stop();
        

      });

      // start camera scan when button click
      let qrtxt = document.querySelector(".qr-text");

      startScan.addEventListener("click", () => {
        qrtxt.style.zIndex = "-1";
        Instascan.Camera.getCameras()
          .then(function (cameras) {
            if (cameras.length > 0) {
              scanner.start(cameras[0]);
              $('[name="options"]').on("change", function () {
                if ($(this).val() == 1) {
                  if (cameras[0] != "") {
                    scanner.start(cameras[0]);
                  } else {
                    alert("No Front camera found!");
                  }
                } else if ($(this).val() == 2) {
                  if (cameras[1] != "") {
                    scanner.start(cameras[1]);
                  } else {
                    alert("No Back camera found!");
                  }
                }
              });
            } else {
              console.error("No cameras found.");
              alert("No cameras found.");
            }
          })
          .catch(function (e) {
            console.error(e);
            alert(e);
          });
      });

      stopScan.addEventListener("click", () => {
        qrtxt.style.zIndex = "1";
        scanner.stop();
      });
    </script>
  </body>
</html>
