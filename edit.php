<?php
header('Content-Type: application/json');
Session_start();
$con = mysqli_connect("localhost","root","","bbttask");
$user_id = $_SESSION['id'] ;
$username = $_SESSION['username'] ;
$id = $_POST['id'];
$message = $_POST['message'];

// $sql = "update messageboard set message = '$message',update_time = now() where id = '$id' ";
// $c = mysqli_query($con,$sql);
$sql = "update messageboard set message = '$message',update_time = now() where id = ? ";
$stmt = mysqli_prepare($con,$sql);
             mysqli_stmt_bind_param($stmt,"s",$id);
             mysqli_execute($stmt);
             mysqli_stmt_close($stmt);

// $sql1 = "select * from messageboard where id = '$id'";
// $select = mysqli_query ($con, $sql1);
$sql1 = "select * from messageboard where id = ? ";
$stmt1 = mysqli_prepare($con,$sql1);
        mysqli_stmt_bind_param($stmt1,"s",$id);
        mysqli_execute($stmt1);
        mysqli_stmt_bind_result($stmt1,$data_id,$data_user,$data_msg,$data_time);
        mysqli_stmt_fetch($stmt1);
// $array = mysqli_fetch_assoc($select);
$result = [
    'errcode' => 0,
    'errmsg' => '留言修改成功！',
    'data' => [
        "id" => $data_id,
        "username" => $data_user,
        "message" => $data_msg,
        "update_time" => $data_time,
        ]
    ];  
    mysqli_stmt_close($stmt1);
echo json_encode($result);
?>