<?php
    session_start(); // Ensure session is started

    include_once("connections/connection.php");
    $conn = connection();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Prepare the SQL query with placeholders for security (avoid SQL injection)
        $sql = "SELECT * FROM student_users WHERE username = :username AND password = :password";
        $stmt = $conn->prepare($sql);
        
        // Bind the parameters to the prepared statement
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        
        // Execute the query
        $stmt->execute();

        // Fetch the result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user exists
        if ($row) {
            $_SESSION['UserLogin'] = $row['username'];
            $_SESSION['Access'] = $row['access'];
            header("Location: index.php");
            exit; // Make sure to stop further script execution after redirect
        } else {
            echo "No user found";
        }

    } catch (PDOException $e) {
        // Handle any errors (e.g., connection issues)
        echo "Error: " . $e->getMessage();
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
    
    <h1>Login Page</h1>
    <form action="login.php" method="post">
        <label>Username</label>
        <input type="text" name="username" id="username">
        <label>Password</label>
        <input type="text" name="password" id="password">
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>