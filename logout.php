<?php
header('Content-Type: application/json');
Session_start();
$con = mysqli_connect("localhost","root","","bbttask");

if (isset($_SESSION['username']) && isset($_SESSION['id'])){
    unset($_SESSION['username']);
    unset($_SESSION['id']);
    $result = [
    'errcode' => 0,
    'errmsg' => '退出登录',
    'data' => ''
       ]; 
}
session_destroy();
echo json_encode($result);
?>