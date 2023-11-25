<?php

// Establish a database connection (replace these values with your database credentials)
$host = "localhost";
$username = "root";
$password = "";
$dbname = "allo";

$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

?>