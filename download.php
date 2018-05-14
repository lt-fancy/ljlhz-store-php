<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2018/1/22
 * Time: 13:00
 */
require_once 'http.php';
$uuid = $_GET['uuid'];
$name = $_GET['name'];
$file = "/app/images/rack/".$uuid.".jpg";
addPic($uuid);
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=".$name.".jpg;");
readfile($file);
exit;