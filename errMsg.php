<?php
    $Msg="";
    if(!empty($_GET['errCode'])) {
        switch($_GET['errCode']) {
            case '1':
                $Msg = "帳號密碼輸入錯誤！";
                break;
        }
    }
?>