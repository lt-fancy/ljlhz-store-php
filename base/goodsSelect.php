<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2018/1/22
 * Time: 10:40
 */
require_once '../mysql.php';
$uuid = $_POST['uuid'];
$ids = $_POST['ids'];
$array = explode(',',$ids);
$sql= "insert into entry_goods_mapping (entry_code,goods_id) values";
for($i = 0;$i<count($array);$i++){
    $sql.= " ('$uuid',$array[$i]),";
}
$sql = substr($sql,0,strlen($sql)-1);
$mysqli->query($sql);
if (mysqli_affected_rows($mysqli)) {
    $arr['success'] = 1;
    $arr['msg'] = '保存成功！';
} else {
    $arr['success'] = 0;
    $arr['msg'] = '保存失败！请稍后重试';
}
echo json_encode($arr); //输出json数据