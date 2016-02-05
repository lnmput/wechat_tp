<?php

/*
 * 自定义菜单生成类
 * 
 */
namespace Home\Controller;

use Think\Log;
class CreateMenuController extends WechatController
{
	public function index()
	{
		
	}
	
	public function createMenu()
	{
		Log::write("开始创建自定义菜单");
		$access_token=$this->getAccessToken();
		$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
		$vars=C('MENU_ONE');
		$result=postCURL($url, $vars);
		Log::write("创建自定义菜单返回消息:".$result);
	}
}
