<?php
    require_once('conn.php');

    // 如果沒有 session 和 文章id 就回 index.php
    session_start();
    if(empty($_SESSION['id']) || empty($_GET['id']))
        header("Location: index.php");
   
    
    $sql_cmd = "UPDATE articles SET is_deleted = 1  WHERE id = ?";
    $stmt = $conn->prepare($sql_cmd);
    $stmt->bind_param('i', $_GET['id']);
    $resulr = $stmt->execute();

    header("Location: index.php");
?>