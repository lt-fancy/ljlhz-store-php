<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2018/4/20
 * Time: 16:26
 */
require_once 'mysql.php';
$sql = $mysqli->query("select * from goods_info where is_deleted=0 order by convert(name using gb2312) asc");
$datarow = mysqli_num_rows($sql); //长度
//循环遍历出数据表中的数据
for($i=0;$i<$datarow;$i++) {
    $sql_arr = mysqli_fetch_assoc($sql);
    $name = $sql_arr['name'];
    $url = $sql_arr['pic_url'];
    $guige = $sql_arr['guige'];
    $eanCode = $sql_arr['code'];
    $unit = $sql_arr['unit'];
    $id = $sql_arr['id'];
    $storeNumber = $sql_arr['store_number'];
    $storeNumber = isset($storeNumber)!=1?0:$storeNumber;
    echo "id=".$id.":".$storeNumber.'</br>';
}