<?php
header('Content-type: text/html; charset=utf8');
require_once('../mysql.php');
$res = $_POST['aoData'];
$begin = $_POST['begin'];
$end = $_POST['end'];
$orderState = $_POST['orderState'];
$iDisplayStart = 0; // 起始索引
$iDisplayLength = 0;//分页长度
$jsonarray = json_decode($res);
$search = "";
foreach ($jsonarray as $value) {
    if ($value->name == "sEcho") {
        $sEcho = $value->value;
    }
    if ($value->name == "iDisplayStart") {
        $iDisplayStart = $value->value;
    }
    if ($value->name == "iDisplayLength") {
        $iDisplayLength = $value->value;
    }
    if ($value->name == "sSearch") {
        $search = $value->value;
    }
}
$data = array();
$Array = Array();
if(empty($search)){
    if($orderState == ''){
        $sql = "select a.*,b.rack_name from order_info a,rack_info b where a.rack_uuid=b.uuid and a.gmt_created >='$begin' and a.gmt_created <= '$end' order by a.gmt_created desc";
    }else {
        $sql = "select a.*,b.rack_name from order_info a,rack_info b where a.rack_uuid=b.uuid and a.order_state=$orderState and a.gmt_created >='$begin' and a.gmt_created <= '$end' order by a.gmt_created desc";
    }
} else {
    if($orderState == ''){
        $sql = "select a.*,b.rack_name from order_info a,rack_info b where a.rack_uuid=b.uuid and a.gmt_created >='$begin' and a.gmt_created <= '$end'
 and concat_ws('',a.order_id,
	a.phone_number,
	b.rack_name) like '%$search%'
 order by a.gmt_created desc";
    } else {
        $sql = "select a.*,b.rack_name from order_info a,rack_info b where a.rack_uuid=b.uuid and a.order_state=$orderState and a.gmt_created >='$begin' and a.gmt_created <= '$end'
 and concat_ws('',a.order_id,
	a.phone_number,
	b.rack_name) like '%$search%'
 order by a.gmt_created desc";
    }
}
$result = $mysqli->query($sql);
$count = $result->num_rows;
while ($row = $result->fetch_array()) {
    $data = array($row["order_id"],$row["phone_number"],$row["openid"],$row["alipayid"],$row["rack_name"],$row["goods_total_price"],$row["goods_settle_price"],$row["benefit_price"],
        $row["random_benefit_price"],$row["weixin_order_id"],$row["alipay_order_id"],$row["order_state"]==1?'已支付':'未支付',$row["gmt_created"],$row["gmt_modified"],$row["id"],$row["rack_uuid"]);
    Array_push($Array, $data);
}
$json_data = array('sEcho' => $sEcho, 'iTotalRecords' => $count, 'iTotalDisplayRecords' => $count, 'aaData' => array_slice($Array, $iDisplayStart, $iDisplayLength));  //按照datatable的当前页和每页长度返回json数据
$obj = json_encode($json_data);
echo $obj;
?>
