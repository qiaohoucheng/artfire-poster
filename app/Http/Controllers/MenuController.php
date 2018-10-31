<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $app;
    public function __construct()
    {
        $this->app = app('wechat.official_account');
    }

    public function index(Request $request)
    {
        $list = $this->app->menu->list();
        return $list;
    }

    public function create()
    {
        $buttons = [
            [
                "type" => "view",
                "name" => "三板头条",
                "url"  => "http://www.dudong.com"
            ],
            [

                "type" => "view",
                "name" => "白皮书",
                "url" => "http://poster.qiaohoucheng.com/74175740.pdf"

            ],
            [
                "name"       => "加入我们",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "招聘编辑 | 实习生",
                        "url"  => "http://mp.weixin.qq.com/s/4l8w7yKx9uBl2zJRG2m9Dg"
                    ],
                    [
                        "type" => "click",
                        "name" => "投稿",
                        "key"  => "读懂新三板」招募特约研究员，欢迎赐稿，投稿邮箱：dudong@dudong.com。"
                    ],
                    [
                        "type" => "click",
                        "name" => "联系我们",
                        "key" => "如有合作，请联系读懂君，微信号：ddxinsanban3"
                    ],
                ],
            ],
        ];
        $this->app->menu->create($buttons);
        exit;
    }
    public function current()
    {
        $current = $this->app->menu->current();
        return $current;
    }
    public function delete($menuid)
    {
        if($menuid >0){
            $this->app->menu->delete($menuid);
        }else{
            $this->app->menu->delete();
        }

    }
}
