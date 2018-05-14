<?PHP
session_start();

if(empty($_SESSION['isLogin'])){

    header("Location: login.php");

    exit();

}
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
    <title>统计管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 统计管理 <span class="c-gray en">&gt;</span> 货架统计 <a id="refresh" class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <span id="ready" class="select-box inline">
		<select id="queryType" name="" class="select" onchange="change(this)">
			<option value="0">日</option>
			<option value="1">月</option>
			<option value="2">季</option>
			<option value="3">年</option>
		</select>
		</span>
        <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')}',dateFmt: 'yyyy-MM-dd HH:mm:ss'})" id="logmin" class="input-text Wdate" style="width:180px;">
        <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d',dateFmt: 'yyyy-MM-dd HH:mm:ss' })" id="logmax" class="input-text Wdate" style="width:180px;">
        <button name="" id="search" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
    </div>
    <div class="mt-20">
        <table id="example" class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="80">货架名称</th>
                <th width="80">货架地址</th>
                <th width="80">销售额</th>
                <th width="80">平台优惠</th>
                <th width="80">随机折扣</th>
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
    var date=new Date;
    var year = date.getFullYear();
    var month = date.getMonth()+1;
    var m_content = "";
    var q_content = "";
    var y_content = "";
    var begin = null;
    var end = null;
    for(var i =1;i<13;i++){
        if(i===month){
            m_content += "<option value='"+i+"' selected='selected'>"+i+"月</option>";
        } else {
            m_content += "<option value='"+i+"'>"+i+"月</option>";
        }
    }
    for(var i =1;i<5;i++){
        q_content += "<option value='"+i+"'>第"+i+"季度</option>";
    }
    for(var i =year;i>=year-3;i--){
        if(i===year){
            y_content += "<option value='"+i+"' selected='selected'>"+i+"年</option>";
        } else {
            y_content += "<option value='"+i+"'>"+i+"年</option>";
        }
    }
    var mhtml = "&nbsp;&nbsp;<span id='month_span' class='select-box inline'><select id='month' name='' class='select'>"+m_content+"</select></span>&nbsp;&nbsp;";
    var qhtml = "&nbsp;&nbsp;<span id='quarter_span' class='select-box inline'><select id='quarter' name='' class='select'>"+q_content+"</select></span>&nbsp;&nbsp;";
    var yhtml = "&nbsp;&nbsp;<span id='year_span' class='select-box inline'><select id='year' name='' class='select'>"+y_content+"</select></span>&nbsp;&nbsp;";
    var _queryValue = $("#ready");
    $(_queryValue).after(yhtml);
    $("#year_span").after(mhtml);
    $("#month_span").after(qhtml);
    $(document).ready(function() {
        begin = today();
        end = today();
        $("#logmin").val(today());
        $("#logmax").val(today());
        hide();
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
    function hide(){
        $("#quarter_span").css('display','none');
        $("#year_span").css('display','none');
        $("#month_span").css('display','none');
    }
    function hideTime() {
        $("#logmin").css('display','none');
        $("#logmax").css('display','none');
    }
    function change(ele) {
        var value = $(ele).val();
        if(value == 1){
            //月
            $("#year_span").css('display','inline');
            $("#month_span").css('display','inline');
            $("#quarter_span").css('display','none');
            hideTime();
        } else if(value == 2){
            //季度
            $("#year_span").css('display','inline');
            $("#quarter_span").css('display','inline');
            $("#month_span").css('display','none');
            hideTime();
        } else if(value == 3){
            //年
            $("#year_span").css('display','inline');
            $("#quarter_span").css('display','none');
            $("#month_span").css('display','none');
            hideTime();
        } else if(value == 0){
            hide();
            $("#logmin").css('display','inline');
            $("#logmax").css('display','inline');
        }

    }
    $("#search").click(function () {
        var type = $("#queryType").val();
        var year = $("#year").val();
        var month = $("#month").val();
        var quarter = $("#quarter").val();
        if(type==0){
            begin = $("#logmin").val();
            end = $("#logmax").val();
        } else if(type==1){
            if(month < 10){
                month = '0'+month;
            }
            begin = year+'-'+month+'-01';
            end = year+'-'+month+'-31';
        } else if(type==2){
            if(quarter == 1){
                begin = year+'-01-01';
                end = year+'-03-31';
            } else if(quarter == 2){
                begin = year+'-04-01';
                end = year+'-06-31';
            } else if(quarter == 3){
                begin = year+'-07-01';
                end = year+'-09-31';
            } else if(quarter == 4){
                begin = year+'-10-01';
                end = year+'-12-31';
            }
        } else if(type==3){
            begin = year +'-01-01';
            end = year+'-12-31';
        }
        table.draw(false);
    });
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
        "searching":true,
        "bPaginite": true,
        "bInfo": true,
        "bSort": false,
        "processing": false,
        "bServerSide": true,
        "sAjaxSource": "./rackSearch.php",//这个是请求的地址
        "fnServerData": retrieveData// 获取数据的处理函数

    });
    function retrieveData(url, aoData, fnCallback) {
        begin = begin == null?today()+" 00:00:00":begin+" 00:00:00";
        end = end == null?today()+" 24:00:00":end+" 24:00:00";
        $.ajax({
            url: url,//这个就是请求地址对应sAjaxSource
            data : {
                "aoData":JSON.stringify(aoData),
                "begin":begin,"end":end
            },
            type: 'POST',
            dataType: 'json',
            async: true,
            success: function (result) {
                console.log(result);
                fnCallback(result);//把返回的数据传给这个方法就可以了,datatable会自动绑定数据的
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
                alert("status:"+XMLHttpRequest.status+",readyState:"+XMLHttpRequest.readyState+",textStatus:"+textStatus);

            }
        });
    }
</script>
</body>
</html>
