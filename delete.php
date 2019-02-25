<?php
header('Content-Type: application/json');
Session_start();
$con = mysqli_connect("localhost","root","","bbttask");

$id = $_POST['id'];

// $search = "select username from messageboard where id = '$id'";
// $rel1 = mysqli_query($con,$search);
$sql1 = "select * from messageboard where id = ? ";
$stmt1 = mysqli_prepare($con,$sql1);
        mysqli_stmt_bind_param($stmt1,"s",$id);
        mysqli_execute($stmt1);
        mysqli_stmt_bind_result($stmt1, $data_id, $data_user, $data_msg, $data_time, $pic);
        mysqli_stmt_fetch($stmt1);

if(isset($_SESSION['username'])){
    $user_id = $_SESSION['id'] ;
    $username = $_SESSION['username'] ;
    // if ($rel1->num_rows == 1) {
    //     $row = $rel1->fetch_assoc();
            if ($username == $data_user){
                mysqli_stmt_close($stmt1);
                // $sql = "delete from messageboard where id = '$id'";
                // $rel2 = mysqli_query($con,$sql);
                $sql2 = "delete from messageboard where id = ?";
                $stmt2 = mysqli_prepare($con,$sql2);
                        mysqli_stmt_bind_param($stmt2,"s",$id);
                        mysqli_execute($stmt2);
                        mysqli_stmt_close($stmt2);
                $sql3 = "delete from comment where user_id = ?";
                $stmt3 = mysqli_prepare($con,$sql3);
                         mysqli_stmt_bind_param($stmt3,"s",$id);
                         mysqli_execute($stmt3);
                         mysqli_stmt_close($stmt3);
                $result = [
                    'errcode' => 0,
                    'errmsg' => '留言删除成功！',
                    ];
            }else{
                $result = [
                    'errcode' => 1,
                    'errmsg' => '不可删除他人留言！',
                    ];
                } 
}
else{
    $result = [
        'errcode' => 1,
        'errmsg' => '尚未登录，不可删除留言！',
        ];
}

echo json_encode($result);
 ?>
