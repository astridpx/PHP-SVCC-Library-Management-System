<!-- 
  # php script to connect in database xampp
 -->
 <?php
include 'connect.php';

error_reporting(0);

// This will prevent to access the page through typing url 
if(!isset($_SERVER['HTTP_REFERER'])){
  header('location: index.php');
  exit;
}

$sql = "SELECT * FROM book_list";
$result = $conn -> query($sql);

if (isset($_POST['submit'])){

  $isbn = $_POST['isbn'];
  $title = $_POST['title'];
  $author = $_POST['name'];
  $datePublish = $_POST['datePublish'];

  // Text Transform
  $titleTrans  = strtoupper($title);
  $authorTrans  = ucwords($author);

  	#try if the isbn is already exist
		$sql = "SELECT * FROM book_list WHERE isbn='$isbn'";
		$result = mysqli_query($conn, $sql);

		if (!$result->num_rows > 0) {

          # inserting the user input in book_list databasse
          $sql = "INSERT INTO book_list (isbn, title, author, publish_date)
              VALUES ('$isbn', '$titleTrans', '$authorTrans', '$datePublish')";

          $result = mysqli_query($conn, $sql);
          
          #if the inserting data is completed
          if ($result) {      
            echo "<script>alert('Record has been saved successfully'); window.location.href = 'books.php';</script>";  
            // header("Location: books.php");

          } else {
            # if there is an error in connecting database
            echo "<script>alert('Woops! Something Wrong Went.')</script>";  
          }
          
		} else {
			echo "<script>alert('ERROR: ISBN Must Be Unique!!')</script>";
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
    <link rel="stylesheet" href="./css/books.css" />
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
        <div class="add-form" style="background-image: url('./images/books-bg.jpg');">
          <div class="overlay"></div>
          <h3>Add Books</h3>

          <form action="" method="POST" class="hidden-form">
            <div class="form-input">
              <label for="isbn">ISBN: </label>
              <input type="text" name="isbn" id="" autocomplete="off" required/>
            </div>
            <div class="form-input">
              <label for="title">Title:</label>
              <input type="text" name="title" id="" autocomplete="off" required/>
            </div>
            <div class="form-input">
              <label for="datePublish">Published Date:</label>
              <input type="date" name="datePublish" id="date" autocomplete="off" required/>
            </div>
            <div class="form-input">
              <label for="name">Author Name:</label>
              <input type="text" name="name" id="" autocomplete="off" required/>
            </div>
          
            <div class="btn-form">
              <button name="submit" id="save">Save</button>
              <button type="button" id="cancel">Cancel</button>
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
                  <i class="bx bx-book icon" id="active"></i>
                  <span class="link" id="active">Books</span>
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
        <!-- Button ADD -->
        <div class="btn-return">
          <button id="btn-return">Add</button>
        </div>
        <h2>BOOKS LIST</h2>
        <div class="fixTableHead">
          <table>
            <thead>
              <tr>
                <th id="bookID">ISBN</th>
                <th>Book Title</th>
                <th>Name of Author</th>
                <th>Publish Date</th>
              </tr>
            </thead>
            <tbody>

              <?php
           $sql = "SELECT * FROM book_list ORDER BY title";
           $result = $conn -> query($sql);
            if ($result->num_rows > 0) {
              while($row = $result -> fetch_assoc()){
                ?>
                  <tr>
                      <td><?php echo $row['isbn']; ?></td>
                      <td><?php echo $row['title']; ?></td>
                      <td><?php echo $row['author']; ?></td>
                      <td><?php echo $row['publish_date']; ?></td>
                    </tr>
                <?php 
              }
            }else{
              ?>   
             <h4 style="text-align: center;">There is no data</h4> 
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
      let hiddenForm = document.querySelector(".hidden-form");
      
      // set the date to current date
      // let date =document.querySelector('#date').valueAsDate = new Date();

      btnAdd.addEventListener("click", () => {
        addForm.style.top = "0";
      });
      cancel.addEventListener("click", () => {
        addForm.style.top = "-100%";
        hiddenForm.reset();
      });
    </script>
  </body>
</html>
