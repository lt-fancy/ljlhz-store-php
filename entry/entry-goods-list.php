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
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="../lib/html5shiv.js"></script>
    <script type="text/javascript" src="../lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="../static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="../static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="../lib/Hui-iconfont/1.0.8/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="../static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="../static/h-ui.admin/css/style.css"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="../lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>入库管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 入库管理 <span
        class="c-gray en">&gt;</span> 入库单详情 <a id="refresh" class="btn btn-success radius r"
                                               style="line-height:1.6em;margin-top:3px"
                                               href="javascript:location.replace(location.href);" title="刷新"><i
            class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <div>单据编号：<input id="entry_code" type="text" readonly="readonly" style="width:180px;color:red" class="input-text">
            单据日期：<input id="entry_time" type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd' })" class="input-text Wdate" style="width:180px;"></div>
        <br/>
        <div>供应商：<input id="supply" type="text" class="input-text" style="width:180px;">
            采购人：<input id="purchase_man" type="text" style="width:250px" class="input-text"></div>
    </div>
    <div id="tool" class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a id="add_goods" class="btn btn-primary radius" data-title="新增货品" data-href="article-add.html" onclick="increase()" href="javascript:;"><i class="Hui-iconfont">&#xe632;</i> 新增货品</a>
            &nbsp;&nbsp;<a class="btn btn-primary radius" data-title="保存入库" data-href="article-add.html" onclick="save()" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 保存入库</a>
    </div>
    <div class="mt-20">
        <table id="example" class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th class="is_hidden" width="25"></th>
                <th class="need_add" width="80">货品名称</th>
                <th width="180">货品编码</th>
                <th width="80">分类</th>
                <th width="80">规格</th>
                <th width="80">单位</th>
                <th width="80">数量</th>
                <th width="80">单价</th>
                <th hidden="hidden"></th>
            </tr>
            </thead>
            <tbody>
            <?php
                require_once '../mysql.php';
                $entryCode = $_GET['entry_code'];
                $sql = $mysqli->query("select a.id,a.goods_number,a.goods_price,b.name,b.code,b.category,b.guige,
                b.unit from entry_goods_mapping a,goods_info b where a.goods_id=b.id and entry_code='$entryCode'");
                $datarow = mysqli_num_rows($sql); //长度
                $is_settled = $_GET['is_settle'];
                //循环遍历出数据表中的数据
                for($i=0;$i<$datarow;$i++){
                    $sql_arr = mysqli_fetch_assoc($sql);
                    $id = $sql_arr['id'];
                    $name = $sql_arr['name'];
                    $code = $sql_arr['code'];
                    $category = $sql_arr['category'];
                    $guige = $sql_arr['guige'];
                    $unit = $sql_arr['unit'];
                    $goods_number = $sql_arr['goods_number'];
                    $goods_price = $sql_arr['goods_price'];
                    //<td><input type='checkbox' value='$id' name=''></td>
                    echo "<tr class='text-c'>
                                <td class='f-14 td-manage is_hidden'><a style='text-decoration:none' onClick='increase()' href='javascript:;' title='新增'><i class='Hui-iconfont' style='font-size: large'>&#xe600;</i></a>
                                    &nbsp;&nbsp;<a style='text-decoration:none' onClick='decrease(this.parentNode)' href='javascript:;' title='删除'><i class='Hui-iconfont' style='font-size: large'>&#xe6a1;</i></a>
                                </td>
                                <td>$name</td>
                                <td>$code</td>
                                <td>$category</td>
                                <td>$guige</td>
                                <td>$unit</td>
                                <td class='number'><input class='first' type='number' value='$goods_number'></td>
                                <td class='price'><input class='second' type='number' value='$goods_price'></td>
                                <td hidden='hidden' class='mapping_id'>$id</td>
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
    var is_settle = "<?php echo $is_settled;?>";
    var entry_code = "<?php echo $entryCode;?>";
    $("#entry_code").val(entry_code+"【"+is_settle+"】");
    $("#entry_time").val("<?php echo $_GET['time'];?>");
    $("#supply").val("<?php echo $_GET['supply'];?>");
    $("#purchase_man").val("<?php echo $_GET['purchaser'];?>");
    $("#entry_time").removeAttr("onfocus").attr("class","input-text").attr("readonly","readonly");
    $("#supply").attr("readonly","readonly");
    $("#purchase_man").attr("readonly","readonly");
    var oTable = $('.table-sort').dataTable({

    });
    if("已结算"===is_settle){
        cannotedit();
    } else {
//            $('.number', oTable.fnGetNodes()).editable('../base/updateMapping.php', {
//                "callback": function (sValue, y) {
//                    var aPos = oTable.fnGetPosition(this);
//                    oTable.fnUpdate( sValue, aPos[0], aPos[1]);
//                },
//                "submitdata": function (value, settings) {
//                    var id = $(this).siblings('.mapping_id').html();
//                    return {
//                        "id": id,
//                        "type":1
//                    };//这里你编辑的内容默认以“value”发送到后台
//                },
//                "height": "20px",
//                "width": "120px"
//            });
//
//            $('.price', oTable.fnGetNodes()).editable('../base/updateMapping.php', {
//                "callback": function (sValue, y) {
//                    var aPos = oTable.fnGetPosition( this );
//                    oTable.fnUpdate( sValue, aPos[0], aPos[1]);
//                },
//                "submitdata": function (value, settings) {
//                    var id = $(this).siblings('.mapping_id').html();
//                    return {
//                        "id": id,
//                        "type":2
//                    };//这里你编辑的内容默认以“value”发送到后台
//                },
//                "height": "20px",
//                "width": "120px"
//            });
    }

    function save(){
        var data = oTable.api().data();
        if(data.length<1){
            layer.msg("没有可保存的数据！", {
                icon: 2,
                time: 1500
            });
            return false;
        }
        var number_array=[];
        var price_array=[];
        var goods_array = [];
        data.each(function (d) {
            goods_array.push(d[8]);
        });
        var cells = oTable
            .api()
            .cells('.number')
            .nodes();
        cells.each(function (cell,i) {
            var value = $(cell).children().val();
            if(value!==''){
                number_array.push(value);
            }
        });
        cells = oTable
            .api()
            .cells('.price')
            .nodes();
        cells.each(function (cell,i) {
            var value = $(cell).children().val();
            if(value!==''){
                price_array.push(value);
            }
        });
        if(goods_array.length!=number_array.length || goods_array.length!=price_array.length){
            layer.msg("请输入数量和单价！", {
                icon: 2,
                time: 1500
            });
            return false;
        }
        $.ajax({
            type: "POST",
            url: "../base/saveEntryTotalPrice.php",
            dataType: "json",
            data: {"code":entry_code,"price":price_array.join(','),"number":number_array.join(","),"goods":goods_array.join(",")},
            async: false,
            success: function (json) {
                if (json.success == 1) {
                    layer.msg(json.msg, {
                        icon: 1,
                        time: 1000
                    },function () {
                        oTable.api().draw(false);
                    });
                } else {
                    layer.msg(json.msg, {
                        icon: 2,
                        time: 1000
                    },function () {
                    });
                }
            }
        });
    }

    function increase() {
        var array=["<td class='f-14 td-manage'>&nbsp;&nbsp;<a style='text-decoration:none' onClick='increase(this.parentNode,1)' href='javascript:;' title='新增'><i class='Hui-iconfont' style='font-size: large'>&#xe600;</i></a>&nbsp;&nbsp;&nbsp;<a style='text-decoration:none' onClick='decrease(this.parentNode)' href='javascript:;' title='删除'><i class='Hui-iconfont' style='font-size: large'>&#xe6a1;</i></a></td>"];
        array.push("<td><a style='text-decoration:none' onClick='openGoods()' href='javascript:;' title=''><i class='Hui-iconfont' style='font-size: large'>&#xe665;</i></a></td>");
        array.push("<td></td>");
        array.push("<td></td>");
        array.push("<td></td>");
        array.push("<td></td>");
        array.push("<td><input type=number></td>");
        array.push("<td><input type=number></td>");
        array.push("<td hidden='hidden'></td>");
        oTable.api().row.add(array).draw();
    }
    function decrease(ele) {
        var id=$(ele).siblings('.mapping_id').html();
        if(typeof(id)!=='undefined'){
            $.ajax({
                type: "POST",
                url: "../base/entryGoodsDel.php",
                dataType: "json",
                data: {"id": id},
                async: false,
                success: function (json) {
                    if (json.success == 1) {
                        layer.msg(json.msg, {
                            icon: 1,
                            time: 1000
                        },function () {
                            oTable.api().row($(ele).parents('tr')).remove().draw();
                        });
                    } else {
                        layer.msg(json.msg, {
                            icon: 2,
                            time: 1000
                        },function () {
//                            window.location.href = $("#refresh").attr('href');
                        });
                    }
                }
            });
        } else {
            oTable.api().row($(ele).parents('tr')).remove().draw();
        }
    }
    function cannotedit() {
        $("#entry_code").attr("style","width:180px;color:green");
        $("#tool").hide();
        $(".is_hidden").hide();
        $(".number").children().attr("readonly","readonly");
        $(".price").children().attr("readonly","readonly");
    }
    function openGoods() {
        layer.open({
            type: 2,
            title: '新增货品入库',
//            shadeClose: true,
//            shade: 0.8,
            area: ['1200px', '500px'],
            content: 'entry-goods-select.php?entry_code='+entry_code
        });
    }
</script>
</body>
</html>
