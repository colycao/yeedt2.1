<?php

//提交数据至一个地址，不需要跳转，
//PostHttpRequest("http://o2.dev.transn.net/api/order/createorder/","order_info={$enarr}");
function PostHttpRequest($url, $params="")
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, 1.0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        ob_start();
        curl_exec($ch);
        $data=ob_get_contents();
        ob_end_clean();
        curl_close ($ch);
        return $data;
    }
?>