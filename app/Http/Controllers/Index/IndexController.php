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
        $tmp_str = sha1(implode(sort( $tmp_arr )));

        if($signature == $tmp_str){
            echo $echostr;
        }else{
            $this->reponseMsg();
        }
    }
}
