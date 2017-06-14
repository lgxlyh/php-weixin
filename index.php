<?php

define("TOKEN", "qazxswedcvfrtgbnhyujmkiolp");

include('wechat.php');

$wechat = new wechat();

if (isset($_GET['echostr'])) {
    $wechat->valid();
}else{
    $wechat->responseMsg();
}

?>