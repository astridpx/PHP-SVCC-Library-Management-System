
<?php

include 'connect.php';

// This will prevent to access the page through typing url 
if(!isset($_SERVER['HTTP_REFERER'])){
  header('location: index.php');
  exit;
}


// get the value of form
if (isset($_GET['submit'])){
  #get the value in isbn
  $isbn = $_GET['isbn'];

  # connect into database
  $sql = "SELECT * FROM issue_book WHERE isbn='$isbn'";
  $result = $conn -> query($sql);

  if ($result->num_rows > 0) {
    # delete script
    $sql = "DELETE FROM issue_book WHERE isbn='$isbn'";
    $result = mysqli_query($conn, $sql);

    if($sql){
      echo "<script>alert('Deleted Successfully');window.location.href = 'return-book.php';</script>";
    }   

  }else{
    echo "<script type='text/javascript'>alert('No Records found of ISBN with value of {$isbn}');</script>";
  }
  
} 
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
    <link rel="stylesheet" href="./css/return-books.css" />
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
            <img src="./images/admin2.png" id="profile" />
            <span class="user-menu">Admin</span>
          </div>

          <div class="sidebar-content">
            <ul class="lists">
              <!-- dashboard -->
              <li class="list">
                <a href="dashboard.php" class="nav-link">
                  <i class="bx bx-home-alt icon"></i>
                  <span class="link">Dashboard</span>
                </a>
              </li>
              <!-- student -->
              <li class="list">
                <a href="student-records.php" class="nav-link">
                  <i class="bx bx-book-reader icon"></i>
                  <span class="link">Student Records</span>
                </a>
              </li>
              <!-- Issue Books -->
              <li class="list">
                <a href="issue-book.php" class="nav-link">
                  <i class="bx bx-book-bookmark icon"></i>
                  <span class="link">Issue Books</span>
                </a>
              </li>
              <!-- return books -->
              <li class="list">
                <a href="return-book.php" class="nav-link">
                  <i class="bx bx-library icon" id="active"></i>
                  <span class="link" id="active">Return books</span>
                </a>
              </li>
              <!-- Books -->
              <li class="list">
                <a href="books.php" class="nav-link">
                  <i class="bx bx-book icon"></i>
                  <span class="link">Books</span>
                </a>
              </li>
                  <!-- Available Book -->
              <li class="list">
                <a href="book-available.php" class="nav-link">
                  <i class="bx bx-book-content icon"></i>
                  <span class="link">Available Books</span>
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

      <!-- Return form -->
      <div class="form-wrapp" style="background-image: url('./images/return-book-form.jpg');">
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
             
              <input type="text" name="isbn" id="isbn" value="<?php if(isset($isbnVal)){echo $isbnVal;} ?>" autocomplete="off"  required />
            </div>
            <div class="form-input">
              <label for="title">Title:</label>
              <input type="text" name="title" id="" value="<?php if(isset($titleVal)){echo $titleVal;} ?>" autocomplete="off" required/>
            </div>
            <div class="form-input">
              <label for="dateReturn">Date Return:</label>
              <input type="date" name="dateReturn" id="date"  required />
            </div>
            <div class="form-input">
              <label for="name">Student Name:</label>
              <input type="text" name="name" id="" value="<?php if(isset($nameVal)){echo $nameVal;} ?>" autocomplete="off" required/>
            </div>
            <div class="form-input">
              <label for="email">Email:</label>
              <input type="email" name="email" id="" value="<?php if(isset($emailVal)){echo $emailVal;} ?>" autocomplete="off" required/>
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
