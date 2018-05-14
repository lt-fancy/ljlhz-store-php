<?PHP
session_start();

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
    <script type="text/javascript" src="../lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
<title>商品列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 商品管理 <span class="c-gray en">&gt;</span> 商品列表 <a id="refresh" class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" data-title="添加商品" data-href="article-add.html" onclick="add_news()" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加商品</a></div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
			<thead>
				<tr class="text-c">
					<th width="25"><input type="checkbox" name="" value=""></th>
					<th hidden="hidden">id</th>
					<th width="80">商品名称</th>
					<th width="80">商品编码</th>
					<th width="120">商品图片</th>
					<th width="80">商品分类</th>
					<th width="60">规格</th>
					<th width="60">单位</th>
					<th width="60">货储容量</th>
					<th width="80">添加时间</th>
					<th width="80">修改时间</th>
					<th width="60">操作</th>
				</tr>
			</thead>
			<tbody>
                <?php
                    require_once '../mysql.php';
                    $sql = $mysqli->query("select * from goods_info where is_deleted=0 order by convert(name using gb2312) asc");
                    $datarow = mysqli_num_rows($sql); //长度
                    //循环遍历出数据表中的数据
                    for($i=0;$i<$datarow;$i++){
                        $sql_arr = mysqli_fetch_assoc($sql);
                        $name = $sql_arr['name'];
                        $url = $sql_arr['pic_url'];
                        $guige = $sql_arr['guige'];
                        $eanCode = $sql_arr['code'];
                        $unit = $sql_arr['unit'];
                        $storeNumber = $sql_arr['store_number'];
                        $category = $sql_arr['category'];
                        $create_time = $sql_arr['gmt_created'];
                        $modify_time = $sql_arr['gmt_modified'];
                        $id = $sql_arr['id'];
                        $operate='';
                        $storeNumber = isset($storeNumber)!=1?0:$storeNumber;
                        $operate="<td class='f-14 td-manage'><a style='text-decoration:none' onClick='online(this.parentNode,1)' href='javascript:;' title='删除'><i class='Hui-iconfont' style='font-size: large'>&#xe6e2;</i></a>
                                    &nbsp;&nbsp;<a style='text-decoration:none' onClick='edit(this.parentNode)' href='javascript:;' title='编辑'><i class='Hui-iconfont' style='font-size: large'>&#xe6df;</i></a>
                                </td>";
                        echo "<tr class='text-c'>
                                <td><input type='checkbox' value='$id' name=''></td>
                                <td class='list_id' hidden='hidden'>$id</td>
                                <td class='editable-cname'>$name</td>
                                <td>$eanCode</td>
                                <td><img width='110' class='picture-thumb' src='$url'></td>
                                <td>$category</td>
                                <td>$guige</td>
                                <td>$unit</td>
                                <td>$storeNumber</td>
                                <td>$create_time</td>
                                <td>$modify_time</td>
                                ",$operate,"
                            </tr>";
                    }
                ?>
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
<script type="text/javascript" src="../lib/datatables/jquery.jeditable.js"></script>
<script type="text/javascript" src="../lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    $(window).load(function () {
        $("#refresh").click();
    });
    var oTable = $('.table-sort').dataTable({

    });
//    $('.editable-cname', oTable.fnGetNodes()).editable('../base/editGoodsName.php', {
//
//        "callback": function (sValue, y) {
//
//            var aPos = oTable.fnGetPosition( this );
//
//            oTable.fnUpdate( sValue, aPos[0], aPos[1]);
//
//        },
//
//        "submitdata": function (value, settings) {
//
//            var name = $(this).val();
//
//            var id = $(this).siblings('.list_id').html();
//
//            return {
//
//                "name":name,
//
//                "id": id
//
//            };//这里你编辑的内容默认以“value”发送到后台
//
//        },
//
//        "height": "20px",
//
//        "width": "120px"
//
//    });
$(".table-sort tbody tr").dblclick(function (){
//    var isOn =$(this).children('.is_on').html();
//    if(isOn == 1){
//        layer.msg('已下线不能编辑！', {
//            icon: 2,
//            time: 1500
//        });
//        return false;
//    }
    var id =$(this).children('.list_id').html()
    var url ='goods-edit.php?id='+id;
    var index = layer.open({
        type: 2,
        title: '商品编辑',
        content: url
    });
    layer.full(index);
});
function edit(ele) {
//    var isOn =$(ele).siblings('.is_on').html();
//    if(isOn == 1){
//        layer.msg('已下线不能编辑！', {
//            icon: 2,
//            time: 1500
//        });
//        return false;
//    }
    var id = $(ele).siblings('.list_id').html();
    var url ='goods-edit.php?id='+id;
    var index = layer.open({
        type: 2,
        title: '新闻编辑',
        content: url
    });
    layer.full(index);
}
function datadel() {
    var vals = [];
    $('input:checkbox:checked').each(function (index, item) {
        var value = $(this).val();
        if (value > 0) {
            vals.push($(this).val());
        }
    });
    var text = '确定要删除这';
    if (vals.length < 1) {
        layer.msg('请选择至少一行数据', {
            icon: 2,
            time: 1500
        });
    } else {
        var ids = vals.join(',');
        commonOnline(text + vals.length + '个商品吗？',ids);
    }
}
function online(ele) {
    var id = $(ele).siblings('.list_id').html();
    commonOnline('确定要删除吗？',id);
}
function commonOnline(msg,id){
    layer.confirm(msg,function(index) {
        $.ajax({
            type: "POST",
            url: "../base/goodsOnline.php",
            dataType: "json",
            data: {"id": id},
            success: function (json) {
                if (json.success == 1) {
                    layer.msg(json.msg, {
                        icon: 1,
                        time: 1500
                    },function () {
                        window.location.href = $("#refresh").attr('href');
                    });
                } else {
                    layer.msg(json.msg, {
                        icon: 2,
                        time: 1500
                    },function () {
                        window.location.href = $("#refresh").attr('href');
                    });
                }
            }
        });
    });
}
function add_news() {
    var index = layer.open({
        type: 2,
        title: '添加商品',
        content: 'goods-edit.php?id=0'
    });
    layer.full(index);
}

</script> 
</body>
</html>
