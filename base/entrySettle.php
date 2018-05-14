<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2018/4/20
 * Time: 14:37
 */
require_once '../mysql.php';
$code = $_POST['code'];
$mysqli->query("update entry_info set is_settled=1 where entry_code ='$code'");
if (mysqli_affected_rows($mysqli)) {
    $sql = $mysqli->query("select goods_id,sum(goods_number) as total from entry_goods_mapping where entry_code='$code' GROUP BY goods_id");
    $datarow = mysqli_num_rows($sql); //长度
    $goods_id_array = "";
    //循环遍历出数据表中的数据
    $update_sql = "update goods_info set store_number = case id ";
    for($i=0;$i<$datarow;$i++) {
        $sql_arr = mysqli_fetch_assoc($sql);
        $goods_id = $sql_arr['goods_id'];
        $number = $sql_arr['total'];
        $goods_id_array .= $goods_id . ',';
        $update_sql.= 'when '.$goods_id.' then store_number+'.$number.' ';
    }
    $goods_id_array = substr($goods_id_array,0,strlen($goods_id_array)-1);
    $update_sql .= ' else store_number end';
    $mysqli->query($update_sql);
    if(mysqli_affected_rows($mysqli)){
        $arr['success'] = 1;
        $arr['msg'] = '结算成功！';
    }
} else {
    $arr['success'] = 0;
    $arr['msg'] = '结算失败！请稍后重试';
}

echo json_encode($arr); //输出json数据