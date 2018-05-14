<?php
header('Content-type: text/html; charset=utf8');
require_once('../mysql.php');
$res = $_POST['aoData'];
$begin = $_POST['begin'];
$end = $_POST['end'];
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
    $sql = "SELECT
	*
FROM
	(
		SELECT
			sum(goods_settle_price) AS settle,
			sum(benefit_price) AS benefit,
			sum(random_benefit_price) AS random,
			b.rack_name,
			b.rack_address
		FROM
			order_info a,
			rack_info b
		WHERE
			order_state = 1
		AND a.rack_uuid = b.uuid
		AND a.gmt_modified <= '$end'
		AND a.gmt_modified >= '$begin'
		GROUP BY
			rack_uuid
	) tb
ORDER BY
	tb.settle DESC";
} else {
    $sql = "SELECT
	*
FROM
	(
		SELECT
			sum(goods_settle_price) AS settle,
			sum(benefit_price) AS benefit,
			sum(random_benefit_price) AS random,
			b.rack_name,
			b.rack_address
		FROM
			order_info a,
			rack_info b
		WHERE
			order_state = 1
		AND a.rack_uuid = b.uuid
		and concat(b.rack_name,b.rack_address) like '%$search%'
		AND a.gmt_modified <= '$end'
		AND a.gmt_modified >= '$begin'
		GROUP BY
			rack_uuid
	) tb
ORDER BY
	tb.settle DESC";
}
$result = $mysqli->query($sql);
$count = $result->num_rows;
while ($row = $result->fetch_array()) {
    $data = array($row["rack_name"],$row["rack_address"],$row["settle"],$row["benefit"],$row["random"]);
    Array_push($Array, $data);
}
$json_data = array('sEcho' => $sEcho, 'iTotalRecords' => $count, 'iTotalDisplayRecords' => $count, 'aaData' => array_slice($Array, $iDisplayStart, $iDisplayLength));  //按照datatable的当前页和每页长度返回json数据
$obj = json_encode($json_data);
echo $obj;
?>