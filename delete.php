<?php
    session_start();

    include_once("connections/connection.php");
    $conn = connection();

    if (isset($_POST['delete'])) {
        // Sanitize input
        $id = filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);

        // Check if the ID is valid
        if ($id && is_numeric($id)) {
            try {
                // Prepare a query to check if the student exists
                $stmt = $conn->prepare("SELECT COUNT(*) FROM student_info WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                // Fetch the count
                $count = $stmt->fetchColumn();

                if ($count > 0) {
                    // Prepare the SQL statement to delete the student record
                    $stmt = $conn->prepare("DELETE FROM student_info WHERE id = :id");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                    // Execute the statement
                    if ($stmt->execute()) {
                        // Redirect with a success message
                        header("Location: index.php?msg=delete_success");
                    } else {
                        // Redirect with an error message
                        header("Location: index.php?msg=delete_error");
                    }
                } else {
                    // If student ID doesn't exist, redirect with a not_found message
                    header("Location: index.php?msg=not_found");
                }
            } catch (PDOException $e) {
                // Catch any exceptions and handle them gracefully
                echo "Error: " . $e->getMessage();
                exit();
            }
        } else {
            // Invalid ID, redirect with an error
            header("Location: index.php?msg=invalid_id");
        }
    }
?>
