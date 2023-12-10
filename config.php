<!-- db configurations -->
<?php
define('DB_HOST', 'localhost'); // Change this to your host
define('DB_USER', 'root'); // Change this to your database user
define('DB_PASS', ''); // Change this to your password
define('DB_NAME', 'dolphin_crm'); // Change this to your database name

// Connect to the database
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check for errors
if($connection === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Close the connection
// mysqli_close($connection);
?>
