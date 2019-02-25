<?php
header('Content-Type: application/json');
Session_start();
$con = mysqli_connect("localhost","root","","bbttask");
if (!$con){
    $result = [
        'errcode' => 111,
        'errmsg' => '数据库连接失败',
        'data' => ''
           ]; 
           echo json_encode($result);
}

$usernamee = $_POST['username'];
$username = htmlspecialchars($usernamee,ENT_QUOTES);
$passwordd = $_POST['password'];
$password = htmlspecialchars($passwordd,ENT_QUOTES);
 
//$check = mysqli_query($con,"select id,username,password from users where username = '$username' && password = '$password'");
$sql = "select id,username,password from users where username = ?";
$stmt = mysqli_prepare($con,$sql);
        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_execute($stmt);
        mysqli_stmt_bind_result($stmt,$id,$data_user,$data_pass);
        mysqli_stmt_fetch($stmt);
    
//$checkusername = mysqli_query($con,"select username from users where username = '$username'");
//var_dump(mysqli_stmt_affected_rows($stmt));
if (empty($data_user)){
    $result = [
        'errcode' => 1,
        'errmsg' => '用户不存在',
        'data' => ''
           ]; 
    echo json_encode($result);
}

else if($password == $data_pass){
    mysqli_stmt_close($stmt);
    //mysqli_query($con,"update users set login_times = login_times +1 where username = '$username'");
    $sql1 = "update users set login_times = login_times +1 where username = ?";
     $stmt1 = mysqli_prepare($con,$sql1);
             mysqli_stmt_bind_param($stmt1,"s",$username);
             mysqli_execute($stmt1);
            mysqli_stmt_close($stmt1);
            
    // $selecttimes = mysqli_query($con,"select login_times,last_login_time from users where username = '$username'");
    $sql2 = "select login_times,last_login_time from users where username = ?";
    $stmt2 = mysqli_prepare($con,$sql2);
             mysqli_stmt_bind_param($stmt2,"s",$username);
             mysqli_execute($stmt2);
             mysqli_stmt_bind_result($stmt2,$login_times,$last_login_time);
             mysqli_stmt_fetch($stmt2);
    //$array = mysqli_fetch_assoc($selecttimes);
    $result = [
        'errcode' => 0,
        'errmsg' => '登陆成功',
         'data' =>  [
                "number_of_times" => $login_times,
                "last_login_time" => $last_login_time,
                ]
                // 'data' =>  [
                //      "number_of_times" => $array['login_times'],
                //      "last_login_time" => $array['last_login_time']
                //      ]
    ];
    echo json_encode($result);
    mysqli_stmt_close($stmt2);
    //mysqli_query($con,"update users set last_login_time = now() where username = '$username'");
    $sql3 = "update users set last_login_time = now() where username = ?";
    $stmt3 = mysqli_prepare($con,$sql3);
             mysqli_stmt_bind_param($stmt3,"s",$username);
             mysqli_execute($stmt3);
             mysqli_stmt_close($stmt3);
     // $arr = mysqli_fetch_array ($check);
    //  $_SESSION['id'] = $arr['id'] ;
    //  $_SESSION['username'] = $arr['username'] ;
    //  $_SESSION['password'] = $arr['password'] ;
    $_SESSION['id'] = $id;
    $_SESSION['username'] = $username;
    $_SESSION['password'] =$password;

}
else {
    $result = [
        'errcode' => 1,
        'errmsg' => '密码错误',
        'data' => ''
         ];
    echo json_encode($result);
        }
?>