<?php
header('Content-Type: application/json');
//登录状态
Session_start();
$con = mysqli_connect("localhost","root","","bbttask");
if (!$con){
    $result = [
        'errcode' => 1,
        'errmsg' => '数据库连接失败',
        'data' => ''
           ]; 
           echo json_encode($result);
}
$user_id = $_POST['user_id'];
$com_msg = $_POST['com_message'];
$com_message = htmlspecialchars($com_msg,ENT_QUOTES);

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $choose_pic = "select pic from users where username = ?";
    $stmt0 = mysqli_prepare($con,$choose_pic);
    mysqli_stmt_bind_param($stmt0,"s",$username);
    mysqli_execute($stmt0);
    mysqli_stmt_bind_result($stmt0,$user_pic);
    mysqli_stmt_fetch($stmt0);
    mysqli_stmt_close($stmt0);

    //评论内容插入
    $sql = "insert into comment (user_id, username, com_message, pic, update_time) values (?, ?, ?, ?, now())";
    $stmt = mysqli_prepare($con,$sql);
    mysqli_stmt_bind_param($stmt, "isss", $user_id, $username, $com_message, $user_pic);
    mysqli_execute($stmt);
    mysqli_stmt_close($stmt);

    //评论内容返回前端显示
    $sql1 = "select username, com_message, update_time, pic from comment where username = ? && com_message = ?";
    $stmt1 = mysqli_prepare($con,$sql1);
             mysqli_stmt_bind_param($stmt1, "ss", $username, $com_message);
             mysqli_execute($stmt1);
             mysqli_stmt_bind_result($stmt1, $user, $com, $time, $pic);
             mysqli_stmt_fetch($stmt1);

    $result = [
        'errcode' => 0,
        'errmsg' => '评论成功！',
        'data' => [
            "username" => $user,
            "com_message" => $com,
            "time" => $time,
            "pic" => $pic,
        ]
           ]; 
           mysqli_stmt_close($stmt1);
}
else{
    $result = [
        'errcode' => 1,
        'errmsg' => '尚未登录，不可评论',
        'data' => ''
           ]; 
}
echo json_encode($result);
?>