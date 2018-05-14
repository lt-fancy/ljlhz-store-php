<?php

function delCache($key){
$url = 'http://47.96.187.244:3333/cache/delCacheByKey';
if(!empty($key)){
  $url .= '?key='.$key;
}
$html = file_get_contents($url);
return $html;
}
function addPic($uuid){
$url = 'http://47.96.187.244:3333/rack/generateRackQRCode';
    if(!empty($uuid)){
        $url .= '?uuid='.$uuid;
    }
    $html = file_get_contents($url);
}
