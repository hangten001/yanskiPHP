<?php

    include_once("connections/connection.php");
    $conn = connection();
    $id = $_GET['ID'];

    $sql = "SELECT * FROM student_info WHERE id = '$id'";
    $students = $conn->query($sql) or die ($conn->error);
    $row = $students->fetch_assoc();

    if(isset($_POST['submit'])){

        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $gender = $_POST['gender'];

        $sql = "UPDATE `student_info` 
        SET `first_name`='$fname',`last_name`='$lname', `gender`= '$gender'
        WHERE `id`='$id'";
        $conn->query($sql) or die ($conn->error);

        header("Location: details.php?ID=".$id); 
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
        <input type="text" name="firstname" id="firstname" value="<?= $row['first_name']; ?>">
        
        <label>Last Name</label>
        <input type="text" name="lastname" id="lastname" value="<?= $row['last_name']; ?>">

        <label>Gender</label>
        <select name="gender" id="gender">
            <option value="male" <?= ($row['gender'] == "male")? 'selected' : ''?>>Male</option>
            <option value="female" <?= ($row['gender'] == "female")? 'selected' : ''?>>Female</option>
            <option value="others" <?= ($row['gender'] == "others")? 'selected' : ''?>>Others</option>
        </select>

        <input type="submit" name="submit" value="Update">
    </form>
 </body>
</html>