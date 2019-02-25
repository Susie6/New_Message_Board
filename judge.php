<?php
header('Content-Type: application/json');
Session_start();
$con = mysqli_connect("localhost","root","","bbttask");

$id = $_POST['id'];
// $search = "select username from messageboard where id = '$msg_id'";
// $rel = mysqli_query($con,$search);
// $row = $rel->fetch_assoc();
$sql = "select username from messageboard where id = ?";
$stmt = mysqli_prepare($con,$sql);
        mysqli_stmt_bind_param($stmt,"s",$id);
        mysqli_execute($stmt);
        mysqli_stmt_bind_result($stmt,$checkuser);
        mysqli_stmt_fetch($stmt);

if(isset($_SESSION['username'])){
    $user_id = $_SESSION['id'] ;
    $username = $_SESSION['username'] ;

    if ($username == $checkuser){
        mysqli_stmt_close($stmt);
        $result = [
            'errcode' => 0,
            'errmsg' => '',
            'data' => $id,
            ];
    }else{
        $result = [
            'errcode' => 1,
            'errmsg' => '不可对他人账号进行操作！',
            ];
    }
}
else{
    $result = [
        'errcode' => 1,
        'errmsg' => '尚未登录，不可操作！',
        'data' => '',
        ];
}
echo json_encode($result);
?>