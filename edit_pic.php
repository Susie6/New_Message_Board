<?php
header('Content-Type: application/json');
Session_start();
$con = mysqli_connect("localhost","root","","bbttask");

if($_FILES['file']['error']>0){
    echo"上传错误：".$_FILES['file']['error'];
    // $result = [
    //     'errcode' => 1,
    //     'errmsg' => '头像上传失败！',
    //     'data' => '',
    //     ];
}
else if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $pic_name = $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'],"img/".$_FILES['file']['name']);
    $pic = 'img/'.$_FILES['file']['name'];
    $sql1 = "update users set pic = ? where username = ?";
    $stmt1 = mysqli_prepare($con,$sql1);
             mysqli_stmt_bind_param($stmt1,'ss',$pic,$username);
             mysqli_stmt_execute($stmt1);
             mysqli_stmt_close($stmt1);

    $sql2 = "update comment set pic = ? where username = ?";
    $stmt2 = mysqli_prepare($con,$sql2);
             mysqli_stmt_bind_param($stmt2,'ss',$pic,$username);
             mysqli_stmt_execute($stmt2);
             mysqli_stmt_close($stmt2);

    $sql3 = "update messageboard set pic = ? where username = ?";
    $stmt3 = mysqli_prepare($con,$sql3);
             mysqli_stmt_bind_param($stmt3,'ss',$pic,$username);
             mysqli_stmt_execute($stmt3);
             mysqli_stmt_close($stmt3);
    // $result = [
    //     'errcode' => 0,
    //     'errmsg' => '头像修改成功！',
    //     'data' => '',
    //     ];
}
else{
    echo "尚未登录";
    // $result = [
    // 'errcode' => 1,
    // 'errmsg' => '尚未登录，不可操作！',
    // 'data' => '',
    // ];
    // echo json_encode($result);
}

?>