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

    try {
        // Prepare the SQL query with a placeholder for the ID to prevent SQL injection
        $sql = "SELECT * FROM student_info WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        // Bind the parameter to the placeholder
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($students) {
            // The result is an array, so we take the first (and probably only) student
            $student = $students[0]; // Get the first row as $student
        } else {
            echo "No student found with the provided ID.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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
    <form action="delete.php" method="post">
        <br>
        <a href="index.php">Home</a>
        <a href="edit.php?ID=<?= $student['id'];?>">Edit</a>
        <?php if($_SESSION['Access'] == "admin" || $_SESSION['Access'] == "adviser") { ?>
            <button type="submit" name="delete">Delete</button>
            <input type="text" name="ID" value="<?= $student['id']; ?>">
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
            <td><h4><?= $student['id'] ?></h4></td>
            <td><h4><?= $student['first_name'] ?></h4></td>
            <td><h4><?= $student['last_name'] ?></h4></td>
            <td><h4><?= $student['birthday'] ?></h4></td>
            <td><h4><?= $student['added_at'] ?></h4></td>
            <td><h4><?= $student['gender'] ?></h4></td>
        </tr>
    </table>
    
</body>
</html>