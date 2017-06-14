<?php 

class simsimi{

    function callSimsimi($keyword){

        $params = array();
        $params['key'] = "795a0202-d949-4215-8fcb-9c0e645f898c";
        $params['lc'] = "ch";
        $params['ft'] = "1.0";
        $params['text'] = $keyword;

        $url = "http://sandbox.api.simsimi.com/request.p?" . http_build_query($params);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);

        $messageResult = json_decode($output,true);

        $result = "";

        if ($messageResult['result'] == 100){
            $result = $messageResult['response'];
        }else{
            
            include('doudou.php');
            $doudou = new doudou();
            $result = $doudou->callDoudou($keyword)
        }

        return $result;
    }

}


?>