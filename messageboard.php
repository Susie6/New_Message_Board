<?php
header('Content-Type: application/json');
Session_start();
$con = mysqli_connect("localhost","root","","bbttask");
if (!$con){
    $result = [
        'errcode' => 1,
        'errmsg' => '数据库连接失败',
        'data' => ''
           ]; 
           echo json_encode($result);
           exit();
}

$messagee = $_POST['message'] ;
$message = htmlspecialchars($messagee,ENT_QUOTES);
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    //$sql2 = "insert into messageboard (username, message, update_time) values ('$username', '$message', now() )" ;
    //$insert = mysqli_query ($con, $sql2);
    $choose_pic = "select pic from users where username = ?";
    $stmt0 = mysqli_prepare($con,$choose_pic);
    mysqli_stmt_bind_param($stmt0,"s",$username);
    mysqli_execute($stmt0);
    mysqli_stmt_bind_result($stmt0,$user_pic);
    mysqli_stmt_fetch($stmt0);
    mysqli_stmt_close($stmt0);

    $sql = "insert into messageboard (username, message, pic, update_time) values (?, ?, ?, now())";
    $stmt = mysqli_prepare($con,$sql);
    mysqli_stmt_bind_param($stmt, "sss", $username, $message, $user_pic);
    mysqli_execute($stmt);
    mysqli_stmt_close($stmt);

    // $sql3 = "select * from messageboard where username = '$username' && message ='$message'";
    // $select = mysqli_query ($con, $sql3);
    // $array = mysqli_fetch_assoc($select);
    $sql1 = "select * from messageboard where username = ? && message = ?";
    $stmt1 = mysqli_prepare($con,$sql1);
             mysqli_stmt_bind_param($stmt1,"ss",$username,$message);
             mysqli_execute($stmt1);
             mysqli_stmt_bind_result($stmt1, $id, $user, $msg, $time, $pic);
             mysqli_stmt_fetch($stmt1);
    $result = [
        'errcode' => 0,
        'errmsg' => '留言成功！',
        'data' => [
            "id" => $id,
            "username" => $user,
            "message" => $msg,
            "update_time" => $time,
            "pic" => $pic,
        ]
           ]; 
           mysqli_stmt_close($stmt1);
}
else{
    $result = [
        'errcode' => 1,
        'errmsg' => '尚未登录，请先登录再留言',
        'data' => ''
           ]; 
}

echo json_encode($result);
?>