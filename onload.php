<?php
header('Content-Type: application/json');
$con = mysqli_connect("localhost","root","","bbttask");

// $sql1 = "select * from messageboard order by id desc";
// $select1 = mysqli_query ($con, $sql1);
// $data = mysqli_fetch_all($select1);

//分页功能
$per_page = 5 ;
$sql = "select id from messageboard";
$row = mysqli_query($con,$sql);
$num_rows = mysqli_num_rows($row);
$pages = ceil($num_rows / $per_page);

//默认当前为第1页
if(isset($_POST['cur_page'])){	
        $cur_page = $_POST['cur_page'];
        var_dump($cur_page);
    }
else{
    $cur_page = 1 ;
}
// $a = "select pic from users";
// $aa = mysqli_query($con,$a);
// if($aa = NULL){
//     $b = "update users set pic = 'img/yizhong.jpg'";
//     mysqli_query($con,$b);
// }
$start = ($cur_page - 1) * $per_page;
$sql1 = "select * from messageboard order by id desc limit $start, $per_page";
$select1 = mysqli_query ($con, $sql1);
$data = mysqli_fetch_all($select1);

$sql2 = "select id from messageboard order by id desc limit $start, $per_page";
$select2 = mysqli_query ($con, $sql2);
$sel_id = mysqli_fetch_all($select2);

$sql3 = "select user_id, username, com_message, update_time, pic from comment";
$select3 = mysqli_query ($con, $sql3);
$sel_all = mysqli_fetch_all($select3);

// $s = "select pic from users where username = 'aaa'";
// $ss = mysqli_query($con,$s);
// var_dump($ss);
// $arr_user_id = [];
// $arr_user = [];
// $arr_com = [];
// $arr_time = [];

// $sql_length = "select com_id from comment";
// $row_length = mysqli_query($con,$sql_length);
// $num_rows_length = mysqli_num_rows($row_length);

// for($i = 0; $i < $num_rows_length; $i++){
//     $sql_pre = "select user_id, username, com_message, update_time from comment where user_id = ?";
//     if(empty($sql_pre)){
//         $arr_user_id[$i] = "";
//              $arr_user[$i] = "";
//              $arr_com[$i] = "";
//              $arr_time[$i] = "";
//         continue;
//     }
//     else{
//         $stmt = mysqli_prepare($con,$sql_pre);
//              mysqli_stmt_bind_param($stmt, "i", $sel_id[$i][0]);
//              mysqli_execute($stmt);
//              mysqli_stmt_bind_result($stmt, $user_id, $user, $com, $time);
//              mysqli_stmt_fetch($stmt);
//              $arr_user_id[$i] = $user_id;
//              $arr_user[$i] = $user;
//              $arr_com[$i] = $com;
//              $arr_time[$i] = $time;
//              mysqli_stmt_close($stmt);
//     }
// }

$result = [
    'errcode' => 0,
    'errmsg' => '留言显示！',
    'pages' => $pages,
    'data' => $data,
    'comments' => $sel_all,
    // 'user_id' => $arr_user_id,
    // 'user' => $arr_user,
    // 'com_message' => $arr_com,
    // 'time' => $arr_time,
        ]; 

echo json_encode($result);
?>