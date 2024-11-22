<?php
    session_start();
    
    if (isset($_SESSION['Access']) && $_SESSION['Access'] == "admin" || $_SESSION['Access'] == "adviser") {
        if ($_SESSION['Access'] == 'admin') {
            echo "Welcome admin: " . $_SESSION['UserLogin'];
        } elseif ($_SESSION['Access'] == 'adviser') {
            echo "Welcome adviser: " . $_SESSION['UserLogin'];
        } else {
            // Handle other roles if necessary
            echo "Welcome user: " . $_SESSION['UserLogin'];
        }
    } else {
        echo header("Location: index.php");
        exit();
    }
    
    include_once("connections/connection.php");
    $conn = connection();

    $id = $_GET['ID'];

    $sql = "SELECT * FROM student_info WHERE id = '$id'";
    $students = $conn->query($sql) or die ($conn->error);
    $row = $students->fetch_assoc();
       
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
    <form action="delete.php" method="post">
        <br>
        <a href="index.php">Home</a>
        <a href="edit.php?ID=<?= $row['id'];?>">Edit</a>
        <?php if($_SESSION['Access'] == "admin" || $_SESSION['Access'] == "adviser") { ?>
            <button type="submit" name="delete">Delete</button>
            <input type="hidden" name="ID" value="<?= $row['id']; ?>">
        <?php } ?>
    </form>

    <h1>Student Details</h1>
    <table>
        <tr>
            <th><h3>ID</h3></th>
            <th><h3>First Name</h3></th>
            <th><h3>Last Name</h3></th>
            <th><h3>Birthday</h3></th>
            <th><h3>Added_at</h3></th>
            <th><h3>Gender</h3></th>
        </tr>
        <tr>
            <td><h4><?= $row['id'] ?></h4></td>
            <td><h4><?= $row['first_name'] ?></h4></td>
            <td><h4><?= $row['last_name'] ?></h4></td>
            <td><h4><?= $row['birthday'] ?></h4></td>
            <td><h4><?= $row['added_at'] ?></h4></td>
            <td><h4><?= $row['gender'] ?></h4></td>
        </tr>
    </table>
    
</body>
</html>