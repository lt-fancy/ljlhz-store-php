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
    <title>商品列表</title>
</head>
<body>
<nav class="breadcrumb"><a id="refresh" class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">货品名称</th>
                <th width="80">货品编码</th>
                <th width="100">货品图片</th>
                <th width="40">分类</th>
                <th width="40">规格</th>
                <th width="40">单位</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require_once '../mysql.php';
            $entry_code = $_GET['entry_code'];
            $sql = $mysqli->query("select * from goods_info where is_deleted=0 and id not in (
                SELECT
                    goods_id
                FROM
                    entry_goods_mapping
                WHERE
                    entry_code = '$entry_code'
            ) order by id desc");
            $datarow = mysqli_num_rows($sql); //长度
            //循环遍历出数据表中的数据
            for($i=0;$i<$datarow;$i++){
                $sql_arr = mysqli_fetch_assoc($sql);
                $name = $sql_arr['name'];
                $code = $sql_arr['code'];
                $url = $sql_arr['pic_url'];
                $category = $sql_arr['category'];
                $guige = $sql_arr['guige'];
                $unit = $sql_arr['unit'];
                $id = $sql_arr['id'];
                echo "<tr class='text-c'>
                                <td><input type='checkbox' value='$id' name=''></td>
                                <td>$name</td>
                                <td>$code</td>
                                <td><img width='110' class='picture-thumb' src='$url'></td>
                                <td>$category</td>
                                <td>$guige</td>
                                <td>$unit</td>
                            </tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="row cl">
        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
            <button onClick="save();" class="btn btn-primary radius" type="button"><i
                    class="Hui-iconfont">&#xe632;</i> 确定
            </button>
            <button id="cancel" onClick="layer_close();" class="btn btn-default radius" type="button">
                &nbsp;&nbsp;取消&nbsp;&nbsp;
            </button>
        </div>
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
    var uuid = '<?php echo $entry_code;?>';
    var oTable = $('.table-sort').dataTable({

    });
    function save() {
        var vals = [];
        $('input:checkbox:checked').each(function (index, item) {
            var value = $(this).val();
            if (value > 0) {
                vals.push($(this).val());
            }
        });
        if (vals.length < 1) {
            layer.msg('请选择至少一行数据', {
                icon: 2,
                time: 1500
            });
        } else {
            var ids = vals.join(',');
            commonOnline('确定要添加这' + vals.length + '个货品吗？',ids);
        }
    }
    function commonOnline(msg,ids) {
        layer.confirm(msg,function(index) {
            $.ajax({
                type: "POST",
                url: "../base/goodsSelect.php",
                dataType: "json",
                data: {"ids": ids,"uuid":uuid},
                success: function (json) {
                    if (json.success == 1) {
                        layer.msg(json.msg, {
                            icon: 1,
                            time: 1500
                        },function () {
                            window.parent.location.reload();
                        });
                    } else {
                        layer.msg(json.msg, {
                            icon: 2,
                            time: 1500
                        },function () {
                            window.parent.location.reload();
                        });
                    }
                }
            });
        });
    }
</script>
</body>
</html>
