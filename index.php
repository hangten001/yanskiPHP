<?php
    session_start();
    
    if (isset($_SESSION['UserLogin'])) {
        // Check the user's role from the session variable 'Access'
        if ($_SESSION['Access'] == 'admin') {
            echo "Welcome admin: " . $_SESSION['UserLogin'];
        } elseif ($_SESSION['Access'] == 'adviser') {
            echo "Welcome adviser: " . $_SESSION['UserLogin'];
        } else {
            // Handle other roles if necessary
            echo "Welcome user: " . $_SESSION['UserLogin'];
        }
    } else {
        // If the user is not logged in
        echo "Welcome Guest!";
    }
    
    include_once("connections/connection.php");
    $conn = connection();
     // Prepare the SQL query
     $sql = "SELECT * FROM student_info ORDER BY id DESC";
    
     // Execute the query using PDO
     $stmt = $conn->prepare($sql);
     $stmt->execute();
     $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
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
    <h1>Yanski Practice System</h1>
    
    <?php if (isset($_SESSION['UserLogin'])) { ?>
        <a href="logout.php">Logout</a>
    <?php } else { ?>
        
        <a href="login.php">Login</a>
    <?php } ?>

    <?php if (isset($_SESSION['Access']) && ($_SESSION['Access'] == "admin" || $_SESSION['Access'] == "adviser")) { ?>
        <a href="add.php">Add New</a>  
    <?php } ?>
 
    <table>
        <tr>
            <th></th>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Birthday</th>
            <th>Added_at</th>
            <th>Gender</th>
        </tr>
        <?php foreach ($students as $row) { ?>
        <tr>
            <td><a href="details.php?ID=<?= $row['id'];?>">view</a></td>
            <td><?= $row['id'] ?></td>
            <td><?= $row['first_name'] ?></td>
            <td><?= $row['last_name'] ?></td>
            <td><?= $row['birthday'] ?></td>
            <td><?= $row['added_at'] ?></td>
            <td><?= $row['gender'] ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>