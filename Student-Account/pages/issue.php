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
  
$sql = "SELECT * FROM issue_book";
// $sql_list = "SELECT * FROM books_pending";
$result = $conn -> query($sql);


// for handling the insert book in database
if (isset($_POST['submit'])) {

	$isbn = $_POST['isbn'];
	$title = $_POST['title'];
	$dateIssue = $_POST['dateIssue'];
	$name = $_POST['name'];
	$email = $_POST['email'];

  // input transform
  $titleTrans  = strtoupper($title);
  $nameTrans  = ucwords($name);
  $emailTrans  = strtolower($email);
 
   #try if the isbn is already exist
   $sql = "SELECT * FROM issue_book WHERE isbn='$isbn'";
   $result = mysqli_query($conn, $sql); 


  //  BOOKL LIST QUERY
  $sql_list = "SELECT  * FROM book_list WHERE isbn='$isbn'";
  $result_list = mysqli_query($conn, $sql_list);

  if ($result_list !== false && $result_list->num_rows > 0) {
    if($row = $result_list -> fetch_assoc()){
      $isbn_list = $row['isbn'];  
      $title_list = $row['title'];
  

      if ($isbn == $isbn_list && $title_list == $titleTrans ){
        // echo "<script>alert('{$titleTrans} ');</script>";
        if (!$result->num_rows > 0) {
          # inserting the user input in issue_book databasse
          $sql = "INSERT INTO issue_book (isbn, title, issue_date, stud_name, email)
              VALUES ('$isbn', '$titleTrans', '$dateIssue', '$nameTrans', '$emailTrans')";
    
          # inserting the user input im student_all_record database
          $sql2 = "INSERT INTO student_all_record (isbn, title, issue_date, stud_name, email)
              VALUES ('$isbn', '$titleTrans', '$dateIssue', '$nameTrans', '$emailTrans')";
    
          # ressult for issue book insert and student_all_record insert
          $result = mysqli_query($conn, $sql);
          $result2 = mysqli_query($conn, $sql2);
          
          #if the inserting data is completed
          if ($result) {      
            echo "<script>alert('Record has been saved successfully');window.location.href = 'issue.php';</script>";  
    
          } else {
            # if there is an error in connecting database
            echo "<script>alert('Woops! Something Wrong Went.');</script>";  
          }
          
        } else {
        echo "<script>alert('Oooops!. This book is already taken');</script>";
        // window.location.href = 'issue.php';
          } 

      }else if ($isbn == $isbn_list && $title_list !== $titleTrans ){
        echo "<script>alert('ERROR: No title: [ {$titleTrans} ]  found in the book list.');</script>";  
      }
    } //row 
  }else{
    echo "<script>alert('Data is NOT exist in Book list');</script>"; 
  }


	
		
}



?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSS -->
    <link rel="stylesheet" href="../Styles/issue.css" />
    <!-- Boxicons CSS -->
    <link
      href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
      rel="stylesheet"
    />
    <title>SVCC LMS</title>
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
                <li class="list">
                  <a href="home.php" class="nav-link">
                    <i class="bx bx-home-alt icon"></i>
                    <span class="link">Home</span>
                  </a>
                </li>

                <!-- Issue Books -->
                <li class="list">
                  <a href="issue.php" class="nav-link">
                    <i class="bx bx-book-bookmark icon" id="active"></i>
                    <span class="link" id="active">Issue Books</span>
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
          <h2>Issue Books</h2>
          <div class="add-form">
            <div class="overlay"></div>
            <!-- qrcode -->
            <div class="qrcode-box">
              <h4>QR-Code</h4>
              <p>You must have this</p>
              <div class="image-box">
                <p class="qr-text">QR CODE Appear Here</p>
                <img src="" id="qrcode" />
              </div>
              <!-- <button type="button" id="btn-qr">Download</button> -->
            </div>

            <!-- form -->
            <form action="" method="POST" class="hidden-form">
              <div class="form-input">
                <label for="isbn">ISBN: </label>
                <input type="text" name="isbn" id="isbn" required autocomplete="Off"  />
              </div>
              <div class="form-input">
                <label for="title">Title:</label>
                <input type="text" name="title" id="" required  autocomplete="Off" />
              </div>
              <div class="form-input">
                <label for="dateIssue">Date Issue:</label>
                <input type="date" name="dateIssue" id="date"  required />
              </div>
              <div class="form-input">
                <label for="name">Student Name:</label>
                <input type="text" name="name" id="name" required autocomplete="Off" readonly="readonly" value="<?php echo $fullname?>"  />
              </div>
              <div class="form-input">
                <label for="email">Email:</label>
                <input type="email" name="email" id="" required autocomplete="Off" readonly="readonly" value="<?php echo $emailLogin ?>" />
              </div>
              <div class="btn-form">
                <button name="submit" id="save">Save</button>
                <button type="button" id="cancel">Clear</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- JS script -->
    <script>
      // variables
      let save = document.querySelector("#save");
      let cancel = document.querySelector("#cancel");
      let qrcode = document.querySelector("#qrcode");
      let isbn = document.querySelector("#isbn");
      let qrText = document.querySelector(".qr-text");
      let hiddenForm = document.querySelector(".hidden-form");
      let preValue;
      let date = (document.querySelector("#date").valueAsDate = new Date());

      cancel.addEventListener("click", () => {
        hiddenForm.reset();
        qrText.style.opacity = "1";
        qrcode.src = false;
      });

      isbn.addEventListener("input", () => {
        let qrValue = isbn.value.trim();

        if (isbn) {
          qrText.style.opacity = "0";
          if (!qrValue || preValue === qrValue) return;
          preValue = qrValue;
          // generateBtn.innerText = "Generating QR Code...";
          qrcode.src = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${qrValue}`;
        } else {
          qrcode.style.display = "none";
          qrText.style.opacity = "1";
        }
      });
    </script>
  </body>
</html>
