<?php


class wechat{

    public function valid(){

        $echoStr = $_GET["echostr"];

        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature(){
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg(){

        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        
        if (!empty($postStr)){

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            switch ($RX_TYPE){
                case "text":
                    $resultStr = $this->receiveText($postObj);
                    break;
                case "event":
                    $resultStr = $this->receiveEvent($postObj);
                    break;
            }

            echo $resultStr;
        }else {
            echo "";
            exit;
        }
    }

    private function receiveText($object){

        $funcFlag = 0;
        $keyword = trim($object->Content);

        include('simsimi.php');
        $simsimi = new simsimi();
        $contentStr = $simsimi->callSimsimi($keyword);
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);

        return $resultStr;
    }

    private function receiveEvent($object){

        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "欢迎，欢迎，热烈欢迎。。。。么么哒。。。。";
        }
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }

    private function transmitText($object, $content, $flag = 0){

        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[text]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>%d</FuncFlag>
                    </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
    }

}
?>