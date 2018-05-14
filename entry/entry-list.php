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
            class="c-gray en">&gt;</span> 入库单列表 <a id="refresh" class="btn btn-success radius r"
                                                   style="line-height:1.6em;margin-top:3px"
                                                   href="javascript:refresh();" title="刷新"><i
                class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <div>单据编号：<input type="text" name="code" id="code" placeholder=" 单据编号" style="width:180px" class="input-text">
            单据日期：<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')}',dateFmt: 'yyyy-MM-dd' })"
                        id="logmin" class="input-text Wdate" style="width:180px;"> -
            <input type="text"
                   onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d',dateFmt: 'yyyy-MM-dd' })"
                   id="logmax" class="input-text Wdate" style="width:180px;">制表人：<input type="text" id="maker" placeholder=" 制表人" style="width:80px"
                                                                                        class="input-text"></div>
        <br/>
        <div>供应商：<span class="select-box inline"><select id="supply" class="select" style="width:200px">
            <option value="">全部</option>
                    <?php
                    require '../mysql.php';
                    $sql = $mysqli->query("select * from supply_info where is_deleted=0");
                    $datarow = mysqli_num_rows($sql); //长度
                    for ($i = 0; $i < $datarow; $i++) {
                        $sql_arr = mysqli_fetch_assoc($sql);
                        $id = $sql_arr['id'];
                        $name = $sql_arr['name'];
                        echo "<option value='$id'>$name</option>";
                    }
                    ?>
                    </select></span>&nbsp;&nbsp;&nbsp;&nbsp;
        采购人：<input type="text" id="purchaser" placeholder=" 采购人" style="width:250px" class="input-text">费用结算：<span
                    class="select-box inline">
		<select id="is_settled" class="select">
			<option value="">全部</option>
			<option value="1">已结算</option>
            <option value="0">未结算</option>
		</select>
        </span></div><br/>
        <button name="" id="search" class="btn btn-success radius" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索
        </button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" data-title="新增入库单" data-href="article-add.html" onclick="add_entry()" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 新增入库单</a></div>
    <div class="mt-20">
        <table id="example" class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="25">id</th>
                <th width="80">单据编号</th>
                <th width="180">供应商</th>
                <th width="80">采购金额</th>
                <th width="80">费用是否结算</th>
                <th width="80">制表人</th>
                <th width="80">采购人</th>
                <th width="120">采购时间</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
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
    var begin = today();
    var end = today();
    var sdata = retrieveData();
    $(document).ready(function() {
        begin = today();
        end = today();
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
        search();
    });
    $("#supply").change(function(){
        search();
    });
    $("#is_settled").change(function(){
        search();
    });
    $("#logmin").change(function(){
        search();
    });
    $("#logmax").change(function(){
        search();
    });

    function search(){
        begin = $("#logmin").val();
        end = $("#logmax").val();
        table.draw(false);
    }
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
            'info': '第 _PAGE_ 页 / 总 _PAGES_ 页',
            'infoEmpty': '没有数据',
            'infoFiltered': '(过滤总件数 _MAX_ 条)'
        },
        "columns":[
            {data: sdata[0],
                render: function (data, type, row, meta) {
                    return "<td><input type='checkbox' value='" + data + "' name=''></td>";
                }
            },
            {data: sdata[1],
                render: function (data, type, row, meta) {
                    return "<td class='list_id'>"+data+"</td>";
                }
            },
            {data: sdata[2],
                render: function(data, type, row, meta){
                    return '<td class=\'text-l rack_uuid\'><a class="maincolor rack" href="javascript:;" onClick="showEntryInfo(this,this.parentNode)">'+data+'</a></td>';
                }
            },
            {data: sdata[3]},
            {data: sdata[4]},
            {data: sdata[5],
                render:function (data, type, row, meta) {
                    if(data==1){
                        return "<td class='td-status'><span class='label label-success radius'>已结算</span></td>";
                    }else{
                        return "<td class='td-status'><span class='label label-danger radius'>未结算</span></td>";
                    }
                }
            },
            {data: sdata[6]},
            {data: sdata[7]},
            {data: sdata[8]},
            {data: sdata[8],
                render: function (data, type, row, meta) {
                    return "<td class='f-14 td-manage'>&nbsp;&nbsp;" +
                        "&nbsp;&nbsp;<a style='text-decoration:none' onClick='settle(this.parentNode)' href='javascript:;' title='结算'><i class='Hui-iconfont' style='font-size: large'>&#xe628;</i></a>" +
                        "&nbsp;&nbsp;&nbsp;&nbsp;<a style='text-decoration:none' onClick='del(this.parentNode)' href='javascript:;' title='删除'><i class='Hui-iconfont' style='font-size: large'>&#xe6e2;</i></a></td>";
                }
            },
        ],
        "searching": true,
        "bPaginite": true,
        "bInfo": true,
        "bSort": false,
        "processing": false,
        "bServerSide": true,
        "sAjaxSource": "./entrySearch.php",//这个是请求的地址
        "fnServerData": retrieveData// 获取数据的处理函数

    });
    function refresh(){
        table.draw(false);
    }
    function showEntryInfo(ele,parent){
        var entry_code = $(ele).html();
        var time = $(parent).siblings().eq(7).html();
        var supply_name = $(parent).siblings().eq(2).html();
        var purchaser = $(parent).siblings().eq(6).html();
        var is_settle = $(parent).siblings().eq(4).children().html();
        var index = layer.open({
            type: 2,
            title: '入库单货品详情',
            content: "entry-goods-list.php?entry_code="+entry_code+"&time="+time+"&supply="+supply_name+"&purchaser="+
            purchaser+"&is_settle="+is_settle
        });
        layer.full(index);
    }
    function retrieveData(url, aoData, fnCallback) {
        var code = $("#code").val();
        var maker = $("#maker").val();
        var purchaser = $("#purchaser").val();
        var is_settled = $("#is_settled").val();
        var supply = $("#supply").val();
        var data = [];
        $.ajax({
            url: url,//这个就是请求地址对应sAjaxSource
            data: {
                "aoData": JSON.stringify(aoData),
                "begin": begin,
                "end": end,
                "code": code,
                "maker": maker,
                "purchaser": purchaser,
                "is_settled": is_settled,
                "supply": supply
            },
            type: 'POST',
            dataType: 'json',
            async: true,
            success: function (result) {
                data = result.aaData;
                fnCallback(result);//把返回的数据传给这个方法就可以了,datatable会自动绑定数据的
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
//                alert("status:"+XMLHttpRequest.status+",readyState:"+XMLHttpRequest.readyState+",textStatus:"+textStatus);

            }
        });
        return data;
    }
    function settle(ele) {
        var code = $(ele).siblings().eq(2).children().html();
        var settle = $(ele).siblings().eq(5).children().html();
        if(settle==='已结算'){
            layer.msg("本入库单已结算！", {
                icon: 1,
                time: 1500
            });
            return false;
        }
        layer.confirm("确定要结算这笔入库单吗？",function(index) {
            $.ajax({
                type: "POST",
                url: "../base/entrySettle.php",
                dataType: "json",
                data: {"code": code},
                success: function (json) {
                    if (json.success == 1) {
                        layer.msg(json.msg, {
                            icon: 1,
                            time: 1500
                        },function () {
                            table.draw(false);
                        });
                    } else {
                        layer.msg(json.msg, {
                            icon: 2,
                            time: 1500
                        },function () {
                        });
                    }
                }
            });
        });
    }
    function datadel() {
        var vals = [];
        var codes = [];
        $('input:checkbox:checked').each(function (index, item) {
            var value = $(this).parent().siblings().eq(0).html();
            var code = $(this).parent().siblings().eq(1).children().html();
            if (value > 0) {
                vals.push(value);
                codes.push(code);
            }
        });
        if (vals.length < 1 || codes.length < 1) {
            layer.msg('请选择至少一行数据', {
                icon: 2,
                time: 1500
            });
        } else {
            var ids = vals.join(',');
            var code_s = codes.join(',');
            commonOnline('确定要删除这' + vals.length + '个入库单吗？',ids,code_s);
        }
    }
    function del(ele) {
        var id = $(ele).siblings().eq(1).html();
        var code = $(ele).siblings().eq(2).children().html();
        commonOnline('确定要删除吗？',id,code);
    }
    function commonOnline(msg,id,codes){
        layer.confirm(msg,function(index) {
            $.ajax({
                type: "POST",
                url: "../base/entryDel.php",
                dataType: "json",
                data: {"id": id,"codes":codes},
                success: function (json) {
                    if (json.success == 1) {
                        layer.msg(json.msg, {
                            icon: 1,
                            time: 1500
                        },function () {
                            table.draw(false);
                        });
                    } else {
                        layer.msg(json.msg, {
                            icon: 2,
                            time: 1500
                        },function () {
                        });
                    }
                }
            });
        });
    }

    function add_entry() {
        var index = layer.open({
            type: 2,
            title: '新增入库单',
            content: 'entry-edit.php?id=0'
        });
        layer.full(index);
    }
    function edit(ele){
        var entry_code = $(ele).siblings().eq(2).children().html();
        var time = $(ele).siblings().eq(8).html();
        var supply_name = $(ele).siblings().eq(3).html();
        var purchaser = $(ele).siblings().eq(7).html();
        var is_settle = $(ele).siblings().eq(5).children().html();
        var url ="entry-goods-list.php?entry_code="+entry_code+"&time="+time+"&supply="
            +supply_name+"&purchaser="+purchaser+"&is_settle="+is_settle;
        var index = layer.open({
            type: 2,
            content: url
        });
        layer.full(index);
    }
</script>
</body>
</html>
