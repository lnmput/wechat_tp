<?php
/*
 * 文本消息处理类
 * 
 */
namespace Home\Controller;

use Think\Log;
class ResponseTextMessageController extends WechatController
{
	/*
	 * 默认调用的方法
	 * 参数为一个数组,里面有的参数;
	 * fromusername
	 * tousername
	 * msgtype
	 * content
	 * msgid
	 * 
	 */
	public function index($arr=array())
	{
		Log::write('开始调用ResponseTextMessageController@index并获得参数'.json_encode($arr));
		$fromusername=$arr['fromusername'];
		$tousername=$arr['tousername'];
		$content=$arr['content'];
		$this->sendTextMessage($fromusername, $tousername, $content);
	}
	
}