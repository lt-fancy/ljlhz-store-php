<?php

/**

 * Created by PhpStorm.

 * User: User

 * Date: 2017/10/14

 * Time: 10:05

 */

require_once '../mysql.php';
$ids = $_POST['id'];
$mysqli->query("delete from entry_goods_mapping where id in ($ids)");
if (mysqli_affected_rows($mysqli)) {
    $arr['success'] = 1;
    $arr['msg'] = '删除成功！';
} else {
    $arr['success'] = 0;
    $arr['msg'] = '删除失败！请稍后重试';
}

echo json_encode($arr); //输出json数据
