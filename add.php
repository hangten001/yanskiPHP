<?php

    include_once("connections/connection.php");
    $conn = connection();

    if(isset($_POST['submit'])){

        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];

        $date = new DateTime($birthday);
        $formatted_birthday = $date->format('Y-m-d');

        $sql = "INSERT INTO `student_info`(`first_name`, `last_name`,`birthday`,`gender`)
                VALUES ('$fname','$lname','$formatted_birthday','$gender')";
        $conn->query($sql) or die ($conn->error);

        header("Location: index.php");
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
        <input type="text" name="firstname" id="firstname">
        
        <label>Last Name</label>
        <input type="text" name="lastname" id="lastname">

        <label>Birthday</label>
        <input type="date" name="birthday" id="birthday">

        <label>Gender</label>
        <select name="gender" id="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="others">Others</option>
        </select>

        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>