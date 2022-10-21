<!-- 
  # php script to connect in database xampp
 -->
<?php
include 'connect.php';

$sql = "SELECT * FROM student_all_record ORDER BY issue_date DESC, stud_name ASC ";
$result = $conn -> query($sql);


  


?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SVCC LMS</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./css/student-records.css" />
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
                  <i class="bx bx-book-reader icon" id="active"></i>
                  <span class="link" id="active">Student Records</span>
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
        <h2>Student All Records</h2>

        <form action="" method="GET">
        <div class="search-box">
              <input type="text" name="valSearch" placeholder="Search here..." id="search" autocomplete="off" />
              <button type="submit" class="btn-search" name="search">Search</button>

        <form action="" method="GETs">
            <div class="filter-date">
              <!-- date from -->
              <label for="date-from" class="date-label" >Date From:</label>
              <input type="date" name="from_date" class="date-from date" />
              <!-- date to -->
              <label for="date-to" class="date-label">Date To:</label>
              <input type="date" name="to_date" class="date-to date" />
            </div>
            <button name="filter" type="submit">Filter date</button>
          </form>

        </div>
        <div class="fixTableHead" style="  overflow-y: scroll; height: 22.3rem;">
          <table>
            <thead>
              <tr>
                <th id="bookID">ISBN</th>
                <th>Book Title</th>
                <th>Student name</th>
                <th>Email</th>
                <th>Issue Date</th>
                <!-- <th>Return Date</th> -->
              </tr>
            </thead>
            <tbody>

              <!-- 
                    # php table data display
                    # if the user click search the data will filter abd display
                    # else if the  user choose to filter by date
                    # else as the default table. All data will display as a table form
              -->
              <?php
              // filter by search
            if(isset($_GET['search'])){

              $valSearch = $_GET['valSearch'];
              
              $sql2 = "SELECT * FROM student_all_record WHERE CONCAT(isbn,title,issue_date,stud_name,email) 
              LIKE '%$valSearch%' ";
          
              $results = mysqli_query($conn, $sql2);   
                if(mysqli_num_rows($results) > 0){
                  foreach($results as $row){
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
                  <h4 style="text-align: center;">No Records Found</h4>
                  <?php 
                }        
            } else if(isset($_GET['filter'])){
              $from_date = $_GET['from_date'];
              $to_date = $_GET['to_date'];

              $query = "SELECT * FROM student_all_record WHERE issue_date BETWEEN '$from_date' AND '$to_date' ";
              $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result) > 0)
                {
                    foreach($result as $row)
                    {
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
                }
                else
                {
                 ?>
                  <h4 style="text-align: center;">No Records Found</h4>
                  <?php
                }

            }else if ($result->num_rows > 0) {
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

            }
             else{
              ?>   
             <h4 style="text-align: center;">There is no data</h4> 
              <?php
            }    
            ?>
            <!-- end of php table data display -->
            
            </tbody>
          </table>
        </div>
        </form>
      </div>
    </div>
  </body>
</html>
