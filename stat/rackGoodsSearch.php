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
			a.rack_name,
			a.rack_address,
			d.goods_name,
			sum(c.goods_number) AS amount,
			c.price*sum(c.goods_number) as price,
			d.id
		FROM
			rack_info a,
			order_info b,
			order_details c,
			goods_info d
		WHERE
			a.uuid = b.rack_uuid
		AND a.uuid = c.rack_uuid
		AND c.goods_id = d.id
		AND b.id = c.order_id
		AND b.order_state = 1 
    and b.gmt_modified >= '$begin' and b.gmt_modified <= '$end'
		GROUP BY
			a.uuid,
			c.goods_id
	) tb
ORDER BY
	tb.amount DESC,tb.id DESC";
} else {
    $sql = "SELECT
	*
FROM
	(
		SELECT
			a.rack_name,
			a.rack_address,
			d.goods_name,
			sum(c.goods_number) AS amount,
			c.price*sum(c.goods_number) as price,
			d.id
		FROM
			rack_info a,
			order_info b,
			order_details c,
			goods_info d
		WHERE
			a.uuid = b.rack_uuid
		AND a.uuid = c.rack_uuid
		AND c.goods_id = d.id
		AND b.id = c.order_id
		AND b.order_state = 1 
		and concat(a.rack_name,a.rack_address,d.goods_name) like '%$search%'
        and b.gmt_modified >= '$begin' and b.gmt_modified <= '$end'
		GROUP BY
			a.uuid,
			c.goods_id
	) tb
ORDER BY
	tb.amount DESC,tb.id DESC";
}
$result = $mysqli->query($sql);
$count = $result->num_rows;
while ($row = $result->fetch_array()) {
    $data = array($row["rack_name"],$row["rack_address"],$row["goods_name"],$row["amount"],$row["price"]);
    Array_push($Array, $data);
}
$json_data = array('sEcho' => $sEcho, 'iTotalRecords' => $count, 'iTotalDisplayRecords' => $count, 'aaData' => array_slice($Array, $iDisplayStart, $iDisplayLength));  //按照datatable的当前页和每页长度返回json数据
$obj = json_encode($json_data);
echo $obj;
?>
