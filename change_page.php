<?php
header('Content-Type: application/json');
$con = mysqli_connect("localhost","root","","bbttask");
if (!$con){
    $result = [
        'errcode' => 111,
        'errmsg' => '数据库连接失败',
        'data' => ''
           ]; 
           echo json_encode($result);
}
//接受跳转页码
$cur_page = $_POST['cur_page'];
//var_dump($cur_page);

//获取该页码显示的留言数据
$per_page = 5 ;

//这页开始显示的留言序号
$start = ($cur_page - 1) * $per_page;
//var_dump($start);

//调出留言数据
$sql1 = "select * from messageboard order by id desc limit ".$start.", 5 ";
$select1 = mysqli_query ($con, $sql1);
$data = mysqli_fetch_all($select1);

//调出评论数据
$sql2 = "select user_id, username, com_message, update_time, pic from comment";
$select2 = mysqli_query ($con, $sql2);
$sel_all = mysqli_fetch_all($select2);

$result = [
    'data' => $data,
    'comments' =>$sel_all,
];

echo json_encode($result);
?>