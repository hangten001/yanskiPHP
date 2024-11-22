<?php
    session_start();

    // Check if the user has permission
    // if (!isset($_SESSION['Access']) || $_SESSION['Access'] != "admin") {
    //     header("Location: index.php");
    //     exit();
    // }

    // include_once("connections/connection.php");
    // $conn = connection();

    // if(isset($_POST['delete'])){

    //     $id = $_POST['ID'];
    //     $sql = "DELETE FROM student_info WHERE id = '$id'";
    //     $conn->query($sql) or die ($conn->error);

    //     header("Location: index.php");

    // }

   
    include_once("connections/connection.php");
    $conn = connection();
    
    if (isset($_POST['delete'])) {
        // Sanitize input
        $id = filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);
        
        // Check if the ID is valid
        if ($id && is_numeric($id)) {
            // Prepare a query to check if the student exists
            $stmt = $conn->prepare("SELECT COUNT(*) FROM student_info WHERE id = ?");
            $stmt->bind_param("i", $id); // 'i' is the type for integer
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
    
            if ($count > 0) {
                // Prepare the SQL statement to delete the student record
                $stmt = $conn->prepare("DELETE FROM student_info WHERE id = ?");
                $stmt->bind_param("i", $id); // 'i' is the type for integer
                
                // Execute the statement
                if ($stmt->execute()) {
                    // Redirect with a success message
                    header("Location: index.php?msg=delete_success");
                } else {
                    // Redirect with an error message
                    header("Location: index.php?msg=delete_error");
                }
    
                // Close the statement
                $stmt->close();
            } else {
                // If student ID doesn't exist, redirect with a not_found message
                header("Location: index.php?msg=not_found");
            }
        } else {
            // Invalid ID, redirect with an error
            header("Location: index.php?msg=invalid_id");
        }
    }
    
    
?>
