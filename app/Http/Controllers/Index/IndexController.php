<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    private $token = 'zayweixin';

    public function index()
    {
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];

        $arr = array($this->token,$timestamp,$nonce);
        sort($arr);
        $tmpstr = sha1(implode( $arr ));

        if($tmpstr == $signature && $_GET['echostr']){
            echo $_GET['echostr'];
            exit;
        }else{
            $this->reponseMsg();
        }
    }

    //实例化回复控制器对象
    private function getReplyObject()
    {
        return new ReplyController();
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
            $this->eventSubscribe($postObj);
        }else if(strtolower($postObj->MsgType) == 'text'){
            $this->textTypeMsg($postObj);
        }

    }
}
