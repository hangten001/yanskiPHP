<?php

    include_once("connections/connection.php");
    $conn = connection();
    
    $id = $_GET['ID'];

    try {
        $sql = "SELECT * FROM student_info WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        // Bind the parameter to the placeholder
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $students = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($students === false) {
            // If no student found with the provided ID
            echo "No student found with the provided ID.";
            exit();
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }

    if (isset($_POST['submit'])) {
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $gender = $_POST['gender'];
    
        try {
            // Prepare the SQL query to update student data
            $sql = "UPDATE student_info 
                    SET first_name = :firstname, last_name = :lastname, gender = :gender
                    WHERE id = :id";
            $stmt = $conn->prepare($sql);
    
            // Bind parameters to prevent SQL injection
            $stmt->bindParam(':firstname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lname, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Execute the update query
            $stmt->execute();
    
            // Redirect to the details page after updating
            header("Location: details.php?ID=" . $id);
            exit();
    
        } catch (PDOException $e) {
            // Handle any exceptions (e.g., query errors, connection issues)
            echo "Error: " . $e->getMessage();
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yanski Management System</title>
    <link rel="stylesheet" href="css/style.css">  
</head>
<body>
    <form action="" method="post">

        <label>First Name</label>
        <input type="text" name="firstname" id="firstname" value="<?= $students['first_name']; ?>">
        
        <label>Last Name</label>
        <input type="text" name="lastname" id="lastname" value="<?= $students['last_name']; ?>">

        <label>Gender</label>
        <select name="gender" id="gender">
            <option value="male" <?= ($students['gender'] == "male")? 'selected' : ''?>>Male</option>
            <option value="female" <?= ($students['gender'] == "female")? 'selected' : ''?>>Female</option>
            <option value="others" <?= ($students['gender'] == "others")? 'selected' : ''?>>Others</option>
        </select>

        <input type="submit" name="submit" value="Update">
    </form>
 </body>
</html>