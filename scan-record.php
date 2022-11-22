<?php

include 'connect.php';

// This will prevent to access the page through typing url 
if(!isset($_SERVER['HTTP_REFERER'])){
  header('location: index.php');
  exit;
}

if(isset($_GET['scan'])){
  $email = $_GET['email'];
  // echo $email;

  $sql = "SELECT * FROM issue_book WHERE email='$email'";
  $result = $conn -> query($sql);

  if ($result->num_rows > 0){
    $row = $result -> fetch_assoc();

    $isbn =  $row['isbn'];
    $title =  $row['title'];
    $name =  $row['stud_name'];
    $email =  $row['email']; 
    $issueDate =  $row['issue_date']; 
    // echo $nameVal;
  }
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/scan-record.css?v=<?php echo time(); ?>" />
    <link
      href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
      rel="stylesheet"
    />
    <title>SVCC LMS</title>
  </head>
  <body>
    <div class="container">
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
                  <i class="bx bx-home-alt icon"></i>
                  <span class="link" >Dashboard</span>
                </a>
              </li>
              <!-- student -->
              <li class="list">
                <a href="student-records.php" class="nav-link">
                  <i class="bx bxs-report icon"></i>
                  <span class="link">Transaction History</span>
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
      <!-- END OF NAVBAR -->

      <!-- HIDDEN FORM -->
      <form action="" method="GET" style="display: none ">
        <input type="text" name="email" id="emailScan" />
        <button type="submit" name="scan" id="btn-hidden">submit</button>
      </form>
      <!-- END OF HIDDEN FORM -->

      <div class="section">
        <h2>SCAN STUDENT RECORDS</h2>
        <div class="qr-wrapper">
          <div class="qrbox-scanner">
            <div class="box">
              <video id="preview" style="width: 100%; height: 100%"></video>
            </div>
            <div class="btn-wrapper">
              <button type="button" id="scan">Scan</button>
              <button type="button" id="stop">Stop</button>
            </div>
          </div>
          <div class="stud-details">
            <form action="">
              <div class="field">
                <h4>Name <span>:</span></h4>
               <p><?php if(isset($name)){echo $name;} ?></p>
              </div>
              <div class="field">
                <h4>Email <span>:</span></h4>
                <p><?php if(isset($email)){echo $email;} ?></p>
              </div>
            </form>
            <div class="line"></div>
            <!-- TABLE RESULT -->
            <table id="table">
              <thead>
                <tr>
                  <th>ISBN</th>
                  <th>TITLE</th>
                  <th>ISSUE DATE</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(isset($_GET['scan'])){
                  $email = $_GET['email'];
                  // echo $email;
                
                  $sql = "SELECT * FROM issue_book WHERE email='$email'";
                  $result = $conn -> query($sql);
                
                  if ($result->num_rows > 0){
                    while($row = $result -> fetch_assoc()){
                    // $row = $result -> fetch_assoc();
                ?>  
                <tr>
                    <td><?php echo $row['isbn']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['issue_date'] ?></td>
                </tr>
                <?php
                    }
                  } else{
                    ?>
                    <!-- <tr> -->
                      <h5 ><?php echo "NO RESULT FOUND." ?></h5>
                    <!-- </tr> -->
                  <?php
                  }
                } 
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </body>
  <!-- script -->
  <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"
  ></script>
  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

  <!-- scrip function -->
  <script>
    const table = document.querySelector("#table");
    const studDetails = document.querySelector(".stud-details");
    const stopScan = document.querySelector("#stop");
    const scan = document.querySelector("#scan");
    const btnHide = document.querySelector("#btn-hidden");

    // table.addEventListener("mouseenter", () => {
    //   studDetails.setAttribute("id", "showScrollbar");
    // });
    // table.addEventListener("mouseleave", () => {
    //   studDetails.removeAttribute("id", "showScrollbar");
    // });

    // SCAN
    var scanner = new Instascan.Scanner({
      video: document.getElementById("preview"),
      scanPeriod: 5,
      mirror: false,
    });
    scanner.addListener("scan", function (content) {
      const emailScan = (document.querySelector("#emailScan").value = content);
      btnHide.click();
      // alert(content);
      scanner.stop();
    });
    btnHide.addEventListener('click',()=> {console.log('hello')});

    scan.addEventListener("click", () => {
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
      scanner.stop();
    });
  </script>
</html>
