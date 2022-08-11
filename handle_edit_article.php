<?php
    require_once('conn.php');

    $id = $_POST['id'];
    $subject = $_POST['subject'];
    $classify = $_POST['article_classify'];
    $content = $_POST['article_content'];

    // search classify id
    $sql_cmd = "SELECT id FROM classifies WHERE classify_name = ?";
    $stmt = $conn->prepare($sql_cmd);
    $stmt->bind_param('s', $classify);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 0) {
        // 建立新的 classify
        $sql_cmd = "INSERT INTO classifies(classify_name) VALUES(?)";
        $stmt->prepare($sql_cmd);
        $stmt->bind_param('s', $classify);
        $result = $stmt->execute();

        // 找尋 classify 的 id
        $sql_cmd = "SELECT id FROM classifies WHERE classify_name = ?";
        $stmt = $conn->prepare($sql_cmd);
        $stmt->bind_param('s', $classify);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $classify_id = $row['id'];

        // 將文章存進資料庫
        $sql_cmd = "UPDATE articles 
            SET subject = ?, content = ?, classify_id = ?
            WHERE id = ?
        ";
        $stmt = $conn->prepare($sql_cmd);
        $stmt->bind_param('ssii',$subject, $content, $classify_id, $id);
        $result = $stmt->execute();

        header("Location: index.php");
    }
    else {
        // 找到 classify 的 id
        $row = $result->fetch_assoc();
        $classify_id = $row['id'];

        // 將文章存進資料庫
        $sql_cmd = "UPDATE articles
            SET classify_id = ?, subject = ?, content = ?
            WHERE id = ?
        ";
        $stmt = $conn->prepare($sql_cmd);
        $stmt->bind_param('issi', $classify_id, $subject, $content, $id);
        $result = $stmt->execute();

        header("Location: index.php");
    }
 
?>