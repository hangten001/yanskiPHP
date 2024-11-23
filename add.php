<?php
    // Include database connection
    include_once("connections/connection.php");
    $conn = connection();

    if(isset($_POST['submit'])){

        // Get the form data
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];

        // Format the birthday
        $date = new DateTime($birthday);
        $formatted_birthday = $date->format('Y-m-d');

        // Check if student with the same first and last name already exists
        $sql = "SELECT COUNT(*) FROM student_info WHERE first_name = :fname AND last_name = :lname";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
        $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
        $stmt->execute();
        
        // Fetch the result
        $count = $stmt->fetchColumn();

        if($count > 0) {
            // If the student already exists, show an error message
            echo "<p style='color: red;'> Error: A student with the name $fname $lname already exists.";
        } else {
            // If student does not exist, insert the new record
            $sql = "INSERT INTO student_info (first_name, last_name, birthday, gender) 
                    VALUES (:fname, :lname, :birthday, :gender)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt->bindParam(':birthday', $formatted_birthday, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            
            // Execute the query
            if($stmt->execute()) {
                // Redirect to the index page after successful insertion
                header("Location: index.php");
                exit();
            } else {
                // If insert fails, show an error message
                echo "Error: Failed to add student.";
            }
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
        <input type="text" name="firstname" id="firstname" required>

        <label>Last Name</label>
        <input type="text" name="lastname" id="lastname" required>

        <label>Birthday</label>
        <input type="date" name="birthday" id="birthday" required>

        <label>Gender</label>
        <select name="gender" id="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="others">Others</option>
        </select>

        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
