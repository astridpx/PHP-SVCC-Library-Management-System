<!-- code for logout the account -->
<?php 

session_start();
session_destroy();

header("Location: ./stud-login.php");

?>