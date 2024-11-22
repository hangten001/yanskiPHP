<?php

    function connection(){
        
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "yanski_system";

        $conn = new mysqli($host, $username, $password, $database);

        if($conn->connect_error){
            error_log("Connection failed: " . $conn->connect_error);
            die("Database connection failed. Please try again later.");
        }
        return $conn;

    }
















?>