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
	tb.goods_name,
	tb.amount,
	tb.goods_now_price,
	tb.goods_old_price,
	tb.goods_discount,
	tb.goods_now_price * tb.amount AS total_now,
	tb.goods_old_price * tb.amount AS total_old,
	tb.goods_discount * tb.amount AS total_discount
FROM
	(
		SELECT
			sum(a.goods_number) AS amount,
			b.id,
			b.goods_name,
			b.goods_now_price,
			b.goods_old_price,
			b.goods_discount
		FROM
			order_details a,
			goods_info b,
			order_info c
		WHERE
			a.goods_id = b.id
		AND a.rack_uuid = c.rack_uuid
		AND a.order_id = c.id
		AND c.order_state = 1
		AND c.gmt_modified >= '$begin'
		AND c.gmt_modified <= '$end'
		GROUP BY
			a.goods_id
	) tb
ORDER BY
	tb.amount DESC";
} else {
    $sql = "SELECT
	tb.goods_name,
	tb.amount,
	tb.goods_now_price,
	tb.goods_old_price,
	tb.goods_discount,
	tb.goods_now_price * tb.amount AS total_now,
	tb.goods_old_price * tb.amount AS total_old,
	tb.goods_discount * tb.amount AS total_discount
FROM
	(
		SELECT
			sum(a.goods_number) AS amount,
			b.id,
			b.goods_name,
			b.goods_now_price,
			b.goods_old_price,
			b.goods_discount
		FROM
			order_details a,
			goods_info b,
			order_info c
		WHERE
			a.goods_id = b.id
		and a.rack_uuid=c.rack_uuid
and a.order_id=c.id
and b.goods_name like '%$search%'
and c.order_state=1
and c.gmt_modified >= '$begin' and c.gmt_modified <= '$end'
		GROUP BY
			goods_id
	) tb
ORDER BY
	tb.amount desc,tb.id DESC";
}
$result = $mysqli->query($sql);
$count = $result->num_rows;
while ($row = $result->fetch_array()) {
    $data = array($row["goods_name"],$row["amount"],$row["goods_now_price"],$row["goods_old_price"],$row["goods_discount"],
        $row["total_now"],$row["total_old"],$row["total_discount"]);
    Array_push($Array, $data);
}
$json_data = array('sEcho' => $sEcho, 'iTotalRecords' => $count, 'iTotalDisplayRecords' => $count, 'aaData' => array_slice($Array, $iDisplayStart, $iDisplayLength));  //按照datatable的当前页和每页长度返回json数据
$obj = json_encode($json_data);
echo $obj;
?>