<?php

function connection() {
    try {
        // Set your database credentials
        $dsn = "mysql:host=localhost;dbname=yanski_system;charset=utf8";
        $username = "root";
        $password = "";
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,   // Enable exceptions for errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch associative arrays by default
        );
        
        // Create a new PDO instance
        $pdo = new PDO($dsn, $username, $password, $options);
        
        // Return the PDO instance
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
















?>