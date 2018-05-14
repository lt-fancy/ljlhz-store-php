<?php
header('Content-type: text/html; charset=utf8');
require_once('../mysql.php');
$res = $_POST['aoData'];
$begin = $_POST['begin'];
$end = $_POST['end'];
$code = $_POST['code'];
$maker = $_POST['maker'];
$purchaser = $_POST['purchaser'];
$is_settled = $_POST['is_settled'];
$supply = $_POST['supply'];
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
$sql = "select a.*,b.name from entry_info a,supply_info b where a.supply_id=b.id and a.create_time >= '$begin' and a.create_time<='$end' ";
if(!empty($code)){
    $sql .= "and a.entry_code like '%$code%' ";
}
if(!empty($maker)){
    $sql .= "and a.create_user like '%$maker%' ";
}
if(!empty($purchaser)){
    $sql .= "and a.purchase_man like '%$purchaser%' ";
}
if(!empty($supply)){
    $sql .= "and a.supply_id = $supply ";
}
if($is_settled!==''){
    $sql .= "and a.is_settled = $is_settled ";
}
$sql .= ' order by create_time desc';
$result = $mysqli->query($sql);
$count = $result->num_rows;
while ($row = $result->fetch_array()) {
    $data = array($row["id"],$row["id"],$row["entry_code"],$row["name"],$row["goods_total_price"],$row["is_settled"],$row["create_user"],$row["purchase_man"],$row["create_time"]);
    Array_push($Array, $data);
}
$json_data = array('sEcho' => $sEcho, 'iTotalRecords' => $count, 'iTotalDisplayRecords' => $count, 'aaData' => array_slice($Array, $iDisplayStart, $iDisplayLength));  //按照datatable的当前页和每页长度返回json数据
$obj = json_encode($json_data);
echo $obj;
?>