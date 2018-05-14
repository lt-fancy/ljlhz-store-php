<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2018/4/20
 * Time: 10:30
 */
require_once '../mysql.php';
$id = $_POST['id'];
$val = $_POST['value'];
$type = $_POST['type'];
$sql = "";
if($type==1){
    $sql = "update entry_goods_mapping set goods_number=$val where id =$id";
} else {
    $sql = "update entry_goods_mapping set goods_price=$val where id =$id";
}

$mysqli->query($sql);
if (mysqli_affected_rows($mysqli)) {
    $arr['success'] = 1;
    $arr['msg'] = '更新成功！';
} else {
    $arr['success'] = 0;
    $arr['msg'] = '更新失败！请稍后重试';
}
echo $val; //输出json数据
