<?php

include 'connect.php';
$sql = "SELECT * FROM issue_book";
$sql_list = "SELECT * FROM books_pending";
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
            echo "<script>alert('Record has been saved successfully');window.location.href = 'issue-book.php';</script>";  
    
          } else {
            # if there is an error in connecting database
            echo "<script>alert('Woops! Something Wrong Went.');</script>";  
          }
          
        } else {
        echo "<script>alert('Oooops!. This book is already taken');</script>";
        // window.location.href = 'issue.php';
          } 

      }else if ($isbn == $isbn_list && $title_list !== $titleTrans ){
        echo "<script>alert('ERROR: [ {$titleTrans} ] Title must be correct.');window.location.href = 'issue-book.php';</script>";  
      }
    } //row 
  }else{
    echo "<script>alert('Data NOT exist in Book list');window.location.href = 'issue-book.php';</script>"; 
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
    <!-- <link rel="stylesheet" href="./css/issue-book.css" /> -->
    <link rel="stylesheet" href="./css/issue-book.css?v=<?php echo time(); ?>">

    <!-- Boxicons CSS -->
    <link
      href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
      rel="stylesheet"
    />
    <title>SVCC LMS</title>
  </head>

  <body>
    <div class="container">
      <!-- hidden form -->
      <div class="screen-overlay">
        <div class="add-form"style="background-image: url('./images/issueForm-bg.jpg');">
          <div class="overlay"></div>
         
          <h3>Add Student</h3>

          <!-- qrcode -->
          <div class="qrcode-box">
            <h4>QR-Code</h4>
            <p>Take a pic of this before submiting</p>
            <div class="image-box">
              <p class="qr-text">QR CODE Appear Here </p>
              <img src=""  id="qrcode">
            </div>
            <!-- <button type="button" id="btn-qr">Download</button> -->
          </div>

          <!-- form -->
          <form action="" method="POST" class="hidden-form">
            <div class="form-input">
              <label for="isbn">ISBN: </label>
              <input type="text" name="isbn" id="isbn" autocomplete="off" required/>
            </div>
            <div class="form-input">
              <label for="title">Title:</label>
              <input type="text" name="title" id="title" autocomplete="off"  required/>
            </div>
            <div class="form-input">
              <label for="dateIssue">Date Issue:</label>
              <input type="date" name="dateIssue" id="date" required/>
            </div>
            <div class="form-input">
              <label for="name">Student Name:</label>
              <input type="text" name="name" id="name" autocomplete="off" required/>
            </div>
            <div class="form-input">
              <label for="email">Email:</label>
              <input type="email" name="email" id="email" autocomplete="off" required/>
            </div>
            <div class="btn-form">
              <button  name="submit" id="save">Save</button>
              <button type="button" id="cancel">Close</button>
            </div>
          </form>
        </div>
      </div>
      <!-- End of hidden form -->

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
                  <i class="bx bxs-report icon"></i>
                  <span class="link">Transaction History</span>
                </a>
              </li>
              <!-- Issue Books -->
              <li class="list">
                <a href="issue-book.php" class="nav-link">
                  <i class="bx bx-book-bookmark icon" id="active"></i>
                  <span class="link" id="active">Issue Books</span>
                </a>
              </li>
              <!-- All Records -->
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
      <!-- ######################
          END OF SIDEBAR
         #######################-->

      <div class="table-wrapper">
        <!-- button add -->
        <div class="btn-add">
          <button id="btn-add">Add</button>
        </div>
        <h2>Issue Books</h2>
        <!-- table -->
        <div class="fixTableHead">
          <table>
            <thead>
                <th id="bookID">ISBN</th>
                <th>Book Title</th>
                <th>Student name</th>
                <th>Email</th>
                <th>Issue Date</th>
              </tr>
            </thead>
            <tbody>

             <!-- php table script to display database data on table form-->
             <?php
            if ($result->num_rows > 0) {
              while($row = $result -> fetch_assoc()){
                ?>
                  <tr>
                      <td><?php echo $row['isbn']; ?></td>
                      <td><?php echo $row['title']; ?></td>
                      <td><?php echo $row['stud_name']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td><?php echo $row['issue_date']; ?></td>
                    </tr>
                <?php 
              }
            }else{
              ?>   
             <h4 style="text-align: center;">There is no data</h4> 
              <?php
            }   
            ?>
            <!-- end of php table data display -->
            
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- JS script -->
    <script>
      // variables
      let btnAdd = document.querySelector("#btn-add");
      let showForm = document.querySelector(".screen-overlay");
      let save = document.querySelector("#save");
      let cancel = document.querySelector("#cancel");
      let qrcode = document.querySelector('#qrcode');
      let isbn = document.querySelector('#isbn');
      let preValue;

      //  set the date to current date
      let date =document.querySelector('#date').valueAsDate = new Date();
      
      
      btnAdd.addEventListener("click", () => {
        showForm.style.top = "0";
        
      });
      
      let hiddenForm = document.querySelector('.hidden-form');
      cancel.addEventListener("click", () => {
        showForm.style.top = "-100%";
        hiddenForm.reset();
        qrcode.src='';
      });
      
      isbn.addEventListener('input',()=>{
        let qrValue = isbn.value.trim(); 
        if (!qrValue || preValue === qrValue) return;
        preValue = qrValue;
        // generateBtn.innerText = "Generating QR Code...";
        qrcode.src = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${qrValue}`; 
        // showForm.style.top = "0";
      });
  

     
    </script>
  </body>
</html>
