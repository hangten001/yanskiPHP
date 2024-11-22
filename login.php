<?php
    session_start();

    include_once("connections/connection.php");
    $conn = connection();

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM student_users WHERE username = '$username' AND password = '$password'";
        $user = $conn->query($sql) or die ($conn->error);
        $row = $user->fetch_assoc();
        $total = $user->num_rows;

        if($total > 0){
            $_SESSION['UserLogin'] = $row['username'];
            $_SESSION['Access'] = $row['access'];
            header("Location: index.php");
        }else{
            echo "No user found";
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