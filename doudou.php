<?php


class doudou{

    function callDoudou($keyword){

        $params = array();
        $params['key'] = "UlA9dzN6S3ZvOCs5Uklrb1Y9VjRBL1hFTlFVQUFBPT0";
        $params['msg'] = $keyword;

        $url = "http://api.douqq.com/?" . http_build_query($params);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);

        $messageResult = json_decode($output,true);

        return $output;
    }

}



?>