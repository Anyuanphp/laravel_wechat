<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    private $token = 'zayweixin';

    public function index(Request $request)
    {
        $signature  = $request->signature;
        $timestamp  = $request->timestamp;
        $nonce      = $request->nonce;
        $echostr    = $request->echostr;

        $tmp_arr = [$this->token,$timestamp,$nonce];
        sort( $tmp_arr );

        $tmp_str = sha1(implode($tmp_arr));

        if($signature == $tmp_str){
            echo $echostr;
        }else{
            $this->reponseMsg();
        }
    }

    //判断消息类型并调用相应类型回复方法
    private function reponseMsg()
    {
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        /*<xml>
         <ToUserName><![CDATA[toUser]]></ToUserName>
         <FromUserName><![CDATA[fromUser]]></FromUserName>
         <CreateTime>1348831860</CreateTime>
         <MsgType><![CDATA[text]]></MsgType>
         <Content><![CDATA[this is a test]]></Content>
         <MsgId>1234567890123456</MsgId>
         </xml>    消息推送的xml数据结构*/

        $postObj = simplexml_load_string($postArr);
        //判断消息类型
        if(strtolower($postObj->MsgType == 'event')){
//            echo 'event';
//            $this->eventSubscribe($postObj);
        }else if(strtolower($postObj->MsgType) == 'text'){
//            echo 'text';
//            $this->textTypeMsg($postObj);
        }

    }
}
