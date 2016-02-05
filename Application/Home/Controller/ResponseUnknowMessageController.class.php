<?php
/*
 * 未知消息处理类
 * 
 */
namespace Home\Controller;
use Think\Log;

class ResponseUnknowMessageController extends WechatController
{
	
	/*
	 * 接收一个参数
	 * 
	 */
	public function index($arr=array())
	{
		Log::write('开始调用ResponseUnknowMessageController@index并获得参数'.json_encode($arr));
		$fromusername=$arr['fromusername'];
		$tousername=$arr['tousername'];
		$content='[Cry][Cry][Cry]暂时不支持处理您的消息类型';
		$this->sendTextMessage($fromusername, $tousername, $content);
	}
}