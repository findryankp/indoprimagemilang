<?php

function connectToDatabase() {
    $servername = "127.0.0.1";
    $username = "findryankp";
    $password = "passwordfindryan";
    $dbname = "lawancovid";

    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("Database connection failed: " . $conn->connect_error);
        }
        return $conn;
    } catch (Exception $e) {
        // Log the exception
        error_log("Exception caught: " . $e->getMessage());
        // Output a user-friendly error message
        die("Sorry, there was an issue connecting to the database.");
    }
}



?>
