<?php 
    // Starting the session
    session_start();

    define('SITE_URL','http://localhost/Food-Order-Complete-Website/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-order');

    $databaseConnection = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); // Database Connection
    $databaseSelection = mysqli_select_db($databaseConnection, DB_NAME) or die(mysqli_error()); // Dataabse Selecting
?>