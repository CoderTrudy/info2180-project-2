<!-- logout user -->
<?php 
session_start();
session_destroy();

//close db connection
include_once 'db_functions.php';
close_db();


header('Location: index.php');
?>