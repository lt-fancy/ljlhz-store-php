<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2018/4/20
 * Time: 16:00
 */
require_once '../mysql.php';
$ids = $_POST['id'];
$codes = $_POST['codes'];
$mysqli->query("delete from entry_info where id in ($ids) and is_settled != 1");
$mysqli->query("delete from entry_goods_mapping where entry_code in ('$codes')");
if (mysqli_affected_rows($mysqli)) {
    $arr['success'] = 1;
    $arr['msg'] = '删除成功！';
} else {
    $arr['success'] = 0;
    $arr['msg'] = '网络异常或入库单已结算不允许删除！';
}

echo json_encode($arr); //输出json数据