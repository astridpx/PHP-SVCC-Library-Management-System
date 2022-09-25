<!-- code for connecting the database/mysql 

# This the variable value are for the connecting my sql 
# user -> is for username of database
# pass -> is none because i dont have a password
# database -> is the databasee name in phpmyadmin sql  
-->
<?php 

$server = "localhost";
$user = "root";
$pass = "";
$database = "library_system";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed)</script>");
}

?>