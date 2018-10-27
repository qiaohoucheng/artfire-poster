<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Image;

class WeChatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function index()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $app->server->push(function($message){
            return "欢迎关注 overtrue！";
        });

        return $app->server->serve();
    }
    public function serve()
    {
        $app = app('wechat.official_account');

        $app->server->push(function ($message) use($app) {
            $openid = $message['FromUserName'];
            switch ($message['MsgType']) {
                case 'event':
                    if ($message['Event']=='subscribe') {
                        $result = $app->qrcode->forever(56);
                        if($result){
                            $content = file_get_contents($result['url']);
                            $a = file_put_contents(public_path().'/code.jpg', $content);
                            if($a){
                                $m = $app->media->uploadImage(public_path().'/code.jpg');
                                return new Image($m['media_id']);
                            }

                        }

                        return '收到关注事件消息';
                    }else if($message['Event']=='unsubscribe'){
                        return '收到取关事件消息';
                    }else if($message['Event']=='SCAN'){
                        return '收到扫码事件消息';
                    }else if($message['Event']=='CLICK'){
                        return '收到点击事件消息';
                    }
                    return '收到事件消息';
                    break;
                case 'text':
                    return '收到'.$openid.'文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }

        });

        $response = $app->server->serve();

        $response->send();

        return $response;
    }
}
