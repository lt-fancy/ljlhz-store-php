<?php
/* 数据库的配置*/
//$host="rm-bp13qqa6glmq9p9u2.mysql.rds.aliyuncs.com";
//$host="rm-bp13qqa6glmq9p9u2eo.mysql.rds.aliyuncs.com";
$host = "localhost";
$port=3306;
$db_user="root";
$db_pass="a8594588";
$db_name="warehouse";

$mysqli = new mysqli($host, $db_user, $db_pass, $db_name,$port);
$mysqli->query("SET names UTF8");
