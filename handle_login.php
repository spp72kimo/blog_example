<?php
    require_once('conn.php');
    session_start();

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql_cmd = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql_cmd);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    if(password_verify($password, $row['password'])){
        $_SESSION['id'] = $row['id'];
        header("Location: index.php");
    } else {
        header("Location: login.php?errCode=1");
    }
?>