<?PHP
//session_start();
//
//if(empty($_SESSION['isLogin'])){
//
//    header("Location: login.php");
//
//    exit();
//
//}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
    <script type="text/javascript" src="../lib/html5shiv.js"></script>
    <script type="text/javascript" src="../lib/respond.min.js"></script>
    <![endif]-->
<link rel="stylesheet" type="text/css" href="../static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="../static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="../lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="../static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="../static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<![endif]-->
<title>订单列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户管理 <span class="c-gray en">&gt;</span> 订单列表 <a id="refresh" class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        订单状态：<span id="ready" class="select-box inline">
		<select id="orderState" name="" class="select">
			<option value="">全部</option>
			<option value="1">已支付</option>
			<option value="0">未支付</option>
		</select>
		</span>
        下单时间：
        <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')}',dateFmt: 'yyyy-MM-dd HH:mm:ss' })" id="logmin" class="input-text Wdate" style="width:180px;">
        <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d %H:%m:%s',dateFmt: 'yyyy-MM-dd HH:mm:ss' })" id="logmax" class="input-text Wdate" style="width:180px;">
        <button name="" id="search" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
    </div>
	<div class="mt-20">
		<table id="example" class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
			<thead>
				<tr class="text-c">
                    <td hidden="hidden"></td>
					<th width="80">订单号</th>
                    <th width="60">手机号</th>
                    <th width="80">微信id</th>
                    <th width="80">支付宝id</th>
                    <td hidden="hidden"></td>
					<th width="80">货架名称</th>
					<th width="40">商品总价</th>
					<th width="40">结算价格</th>
					<th width="80">优惠价格</th>
					<th width="40">随机折扣</th>
					<th width="80">微信订单号</th>
					<th width="80">支付宝订单号</th>
					<th width="60">订单状态</th>
					<th width="100">下单时间</th>
					<th width="100">支付时间</th>
				</tr>
			</thead>
			<tbody>
<!--                --><?php
//                    require_once '../mysql.php';
//                    $sql = $mysqli->query("select a.*,b.rack_name from order_info a,rack_info b where a.rack_uuid=b.uuid order by a.gmt_created desc");
//                    $datarow = mysqli_num_rows($sql); //长度
//                    //循环遍历出数据表中的数据
//                    for($i=0;$i<$datarow;$i++){
//                        $sql_arr = mysqli_fetch_assoc($sql);
//                        $id = $sql_arr['id'];
//                        $orderId = $sql_arr['order_id'];
//                        $phone = $sql_arr['phone_number'];
//                        $openid = $sql_arr['openid'];
//                        $alipayid = $sql_arr['alipayid'];
//                        $rack = $sql_arr['rack_uuid'];
//                        $rackName = $sql_arr['rack_name'];
//                        $total = $sql_arr['goods_total_price'];
//                        $settle = $sql_arr['goods_settle_price'];
//                        $benefit = $sql_arr['benefit_price'];
//                        $random = $sql_arr['random_benefit_price'];
//                        $weixinId = $sql_arr['weixin_order_id'];
//                        $alipayId = $sql_arr['alipay_order_id'];
//                        $state = $sql_arr['order_state']==0?'未支付':'已支付';
//                        $createTime = $sql_arr['gmt_created'];
//                        $payTime = $sql_arr['gmt_modified'];
//                        echo "<tr class='text-c'>
//                                <td name='orderId' class='order_id' hidden='hidden'>$id</td>
//                                <td class='text-l'><a name='orderUUId' value='$id' class=\"maincolor\" href=\"javascript:;\" onClick=\"showOrderDetails(this)\">$orderId</a></td>
//                                <td class='text-l'><a class=\"maincolor\" href=\"javascript:;\" onClick=\"showUserInfo(this)\">$phone</a></td>
//                                <td>$openid</td>
//                                <td>$alipayid</td>
//                                <td hidden='hidden' class='rack_uuid'>$rack</td>
//                                <td class='text-l'><a class=\"maincolor\" href=\"javascript:;\" onClick=\"showRackInfo(this)\">$rackName</a></td>
//                                <td>$total</td>
//                                <td>$settle</td>
//                                <td>$benefit</td>
//                                <td>$random</td>
//                                <td>$weixinId</td>
//                                <td>$alipayId</td>
//                                <td>$state</td>
//                                <td>$createTime</td>
//                                <td>$payTime</td>
//                            </tr>";
//                    }
//                ?>
			</tbody>
		</table>
	</div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="../lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="../lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="../static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="../static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="../lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="../lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    var begin = today()+" 00:00:00";
    var end = today()+" 23:59:59";
    var data = retrieveData();
    var table = $('#example').DataTable({
        "sPaginationType": "full_numbers",
        'language': {
            'emptyTable': '没有数据',
            'loadingRecords': '加载中...',
            'processing': '查询中...',
            'search': '检索:',
            'lengthMenu': '每页 _MENU_ 条',
            'zeroRecords': '没有数据',
            // 'paginate': {
            //     'first':      '第一页',
            //     'last':       '最后一页',
            //     'next':       '下一页',
            //     'previous':   '上一页'
            // },
            'info': '第 _PAGE_ 页 / 总 _PAGES_ 页 共 _TOTAL_ 条数据',
            'infoEmpty': '没有数据',
            'infoFiltered': '(过滤总件数 _MAX_ 条)'
        },
        "columns": [

            {
                data: data[0],
                render: function (data, type, row, meta) {
                    return "<td class='text-l'><a name='orderUUId' class=\"maincolor\" href=\"javascript:;\" onClick=\"showOrderDetails(this)\">"+data+"</a></td>";
                }
            },//级别
            {
                data: data[1],
                render: function (data, type, row, meta) {
                    if(data!=null){
                        return "<td class='text-l'><a class=\"maincolor\" href=\"javascript:;\" onClick=\"showUserInfo(this)\">"+data+"</a></td>";
                    } else {
                        return "<td></td>";
                    }
                }
            },//状态
            { data: data[2] },//事件类型
            { data: data[3] },//发生时间
            { data: data[4],render: function (data, type, row, meta) {
                if(data){
                    return '<td class=\'text-l rack_uuid\'><a class="maincolor rack" href="javascript:;" onClick="showRackInfo(this)">'+data+'</a></td>';
                }
            }},{ data: data[5] },{ data: data[6] },{ data: data[7] },{ data: data[8] },
            { data: data[9] },{ data: data[10] },{ data: data[11] },{ data: data[12] },{ data: data[13] }//描述
        ],
        "searching":true,
        "bPaginite": true,
        "bInfo": true,
        "bSort": false,
        "processing": false,
        "bServerSide": true,
        "sAjaxSource": "./orderSearch.php",//这个是请求的地址
        "fnServerData": retrieveData// 获取数据的处理函数

    });
    $(document).ready(function() {
        begin = today()+" 00:00:00";
        end = today()+" 23:59:59";
        $("#logmin").val(begin);
        $("#logmax").val(end);
    });
    function today(){
        var today=new Date();
        var h=today.getFullYear();
        var m=today.getMonth()+1;
        var d=today.getDate();
        m= m<10?"0"+m:m;   //  这里判断月份是否<10,如果是在月份前面加'0'
        d= d<10?"0"+d:d;        //  这里判断日期是否<10,如果是在日期前面加'0'
        return h+"-"+m+"-"+d;
    }
    $("#search").click(function () {
        begin = $("#logmin").val();
        end = $("#logmax").val();
        table.draw(false);
    });
    function retrieveData(url, aoData, fnCallback) {
        var orderState = $("#orderState").val();
        var data = [];
        $.ajax({
            url: url,//这个就是请求地址对应sAjaxSource
            data : {
                "aoData":JSON.stringify(aoData),
                "begin":begin,"end":end,"orderState":orderState
            },
            type: 'POST',
            dataType: 'json',
            async: true,
            success: function (result) {
                data = result.aaData;
                fnCallback(result);//把返回的数据传给这个方法就可以了,datatable会自动绑定数据的
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
//                alert("status:"+XMLHttpRequest.status+",readyState:"+XMLHttpRequest.readyState+",textStatus:"+textStatus);

            }
        });
        return data;
    }
    function showOrderDetails(ele) {
        var id = $(ele).html();
        var index = layer.open({
            type: 2,
            title: '订单详情',
            content: 'order-details.php?id='+id
        });
        layer.full(index);
    }
    function getEmpty(name){
        if(name == null){
            return '';
        }
        return name;
    }
    function showUserInfo(ele) {
        var phone = $(ele).html();
        $.ajax({
            type: "GET",
            url: "../base/getUserInfo.php",
            dataType: "json",
            data: {"phone": phone},
            success: function (json) {
                if (json.code == 1) {
                    layer.open({
                        type: 1,
                        area: ['600px','400px'],
                        fix: false, //不固定
                        maxmin: true,
                        shade:0.4,
                        title: '查看用户信息',
                        content: "<table class='table table-border table-bordered table-bg mt-20'><thead><tr><th colspan='2' scope='col'>用户信息</th></tr></thead><tbody>" +
                        "<tr><td>手机号</td><td>"+getEmpty(phone)+"</td></tr>" +
                        "<tr><td>微信openid</td><td>"+getEmpty(json.weixin)+"</td></tr>" +
                        "<tr><td>支付宝id</td><td>"+getEmpty(json.alipay)+"</td></tr>" +
                        "<tr><td>余额</td><td>"+json.balance+"</td></tr>" +
                        "<tr><td>注册时间</td><td>"+getEmpty(json.time)+"</td></tr></tbody></table>"
                    });
                }
            }
        });
    }
    function showRackInfo(ele) {
        var uuid = $(ele).html();
        $.ajax({
            type: "GET",
            url: "../base/getRackInfo.php",
            dataType: "json",
            data: {"uuid": uuid},
            success: function (json) {
                if (json.code == 1) {
                        layer.open({
                        type: 1,
                        area: ['600px','400px'],
                        fix: false, //不固定
                        maxmin: true,
                        shade:0.4,
                        title: '查看货架信息',
                        content: "<table class='table table-border table-bordered table-bg mt-20'><thead><tr><th colspan='2' scope='col'>货架信息</th></tr></thead><tbody>" +
                        "<tr><td>货架编号</td><td>"+uuid+"</td></tr>" +
                        "<tr><td>货架名称</td><td>"+getEmpty(json.name)+"</td></tr>" +
                        "<tr><td>货架地址</td><td>"+getEmpty(json.address)+"</td></tr>" +
                        "<tr><td>业务员</td><td>"+getEmpty(json.biz)+"</td></tr>" +
                        "<tr><td>补货员</td><td>"+getEmpty(json.replenish)+"</td></tr>" +
                        "<tr><td>上线状态</td><td>"+json.state+"</td></tr>" +
                        "<tr><td>更新时间</td><td>"+getEmpty(json.time)+"</td></tr></tbody></table>"
                    });
                }
            }
        });
    }
</script>
</body>
</html>
