<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2018/4/20
 * Time: 14:34
 */

require_once '../mysql.php';
$price = $_POST['price'];
$code = $_POST['code'];
$number = $_POST['number'];
$goods = $_POST['goods'];
$price_array = explode(',',$price);
$number_array = explode(',',$number);
$goods_array = explode(',',$goods);
if(count($price_array)!=count($number_array)&&count($price_array)!=count($goods_array)){
    $arr['success'] = 0;
    $arr['msg'] = '网络异常或已经保存！';
    echo json_encode($arr); //输出json数据
    exit(0);
}
$sql = "update entry_goods_mapping ";
$part1 = "";
$part2 = "";
$totalPrice = 0;
for($i=0;$i<count($goods_array);$i++){
    $id = $goods_array[$i];
    $innerNumber = $number_array[$i];
    $innerPrice = $price_array[$i];
    $id = $goods_array[$i];
    $part1 .= 'when '.$id.' then '.$innerNumber.' ';
    $part2 .= 'when '.$id.' then '.$innerPrice.' ';
    $totalPrice += $innerNumber * $innerPrice;
}
$sql .= 'set goods_number = case id ' . $part1 . ' else goods_number end, goods_price = case id ' . $part2 . ' else goods_price end' ;
$mysqli->query($sql);
$mysqli->query("update entry_info set goods_total_price = $totalPrice where entry_code='$code'");
if (mysqli_affected_rows($mysqli)) {
    $arr['success'] = 1;
    $arr['msg'] = '保存入库成功！';
} else {
    $arr['success'] = 0;
    $arr['msg'] = '网络异常或已经保存！';
}
echo json_encode($arr); //输出json数据
exit(0);

