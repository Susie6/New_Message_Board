<?php
header('Content-Type: application/json');
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

$usernamee = $_POST['username'];
$username = htmlspecialchars($usernamee,ENT_QUOTES);
$passwordd = $_POST['password'];
$password = htmlspecialchars($passwordd,ENT_QUOTES);
$checkpwdd = $_POST['checkpwd'];
$checkpwd = htmlspecialchars($checkpwdd,ENT_QUOTES);

//$check = mysqli_query($con,"select username,password from users where username = '$username' && password = '$password'");

//$checkusername = mysqli_query($con,"select username from users where username = '$username'");
$sql = "select username,password from users where username = ?";
$stmt = mysqli_prepare($con,$sql);
        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_execute($stmt);
        mysqli_stmt_bind_result($stmt,$data_user,$data_pass);
        mysqli_stmt_fetch($stmt);

if ($data_pass == $password){
    $result = [
        'errcode' => 1,
        'errmsg' => '你已经注册了哦',
        'data' => ''
    ];
}

else if ($password != $checkpwd){
    $result = [
        'errcode' => 1,
        'errmsg' => '两次输入密码不一致',
        'data' => ''
    ];
}
else if ($username == $data_user){
    mysqli_stmt_close($stmt);
    $result = [
        'errcode' => 1,
        'errmsg' => '用户名已被占用，请更换用户名',
        'data' => ''
    ];
}
else{
    $result = [
        'errcode' => 0,
        'errmsg' => '注册成功',
        'data' => ''
    ];
    //mysqli_query($con,"insert into users (username,password,login_times) values ('$username','$password','0')");
    $sql1 = "insert into users (username,password,login_times) values (?,?,?)";
    $stmt1 = mysqli_prepare($con,$sql1);
    $times = 0 ;
    mysqli_stmt_bind_param($stmt1,"ssi",$username,$password,$times);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);
}
echo json_encode($result);
?>
