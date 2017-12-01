<?php
namespace app\home\controller;
use think\Controller;

class Wechat extends Controller {
    //获取用户openid
    public function info(){
        //1.用户同意授权,获取code
        //1.1 引导关注者打开页面:https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect
        $appid = 'wx1677dd8c02f442a0';
        $callback_url = url('home/wechat/callback','',true,true);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$callback_url}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
        //跳转
        $this->redirect($url);
    }
    //授权成功回调地址
    public function callback(){
        $appid = 'wx1677dd8c02f442a0';
        $secret = '513a0cf113e0e97eb9a0d31bf46eeff8';
        //获取code
        $code = $this->request->get('code');
//        通过code换取授权access_token,请求https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$code}&grant_type=authorization_code";
        $str = file_get_contents($url);
        $json = json_decode($str);
        $openid = $json->openid;
        var_dump($str);
    }
}
