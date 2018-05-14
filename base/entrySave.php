<?php

/**

 * Created by PhpStorm.

 * User: User

 * Date: 2017/10/14

 * Time: 15:10

 */

require_once '../mysql.php';
$id = $_POST['id'];
$supply = $_POST['supply'];
$purchaser = $_POST['purchaser'];
$maker = $_POST['maker'];
$entry_code = 'RKD'.time();
if($id==0){
    //新增
    $ready = "insert into entry_info (entry_code,supply_id, purchase_man, goods_total_price, is_settled, 
create_time, create_user)
 values('$entry_code',$supply,'$purchaser',0,0,now(),'$maker')";
    $sql= $mysqli->query($ready);
} else {
    //更新
    $ready = "update entry_info set supply_id=$supply,purchase_man='$purchaser',create_user='$maker' where id=$id";
    $sql = $mysqli->query($ready);
}
if(mysqli_affected_rows($mysqli) > 0){
    $arr['success'] = 1;
    $arr['msg'] = '保存成功！';
    echo json_encode($arr,JSON_UNESCAPED_UNICODE);
} else {
    $arr['success'] = 0;
    $arr['msg'] = '保存失败！';
    echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    exit;
}
