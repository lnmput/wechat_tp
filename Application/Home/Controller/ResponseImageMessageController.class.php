<?php
/*
 * 图片消息处理类
 * 
 */
namespace Home\Controller;
use Think\Log;

class ResponseImageMessageController extends WechatController
{
	
	/*
	 * fromusername
	 * tousername
     * msgtype
     * picurl
     * mediaid
     * msgid
	 * 
	 */
	public function index($arr=array())
	{
		Log::write('开始调用ResponseImageMessageController@index并获得参数'.json_encode($arr));
		$fromusername=$arr['fromusername'];
		$tousername=$arr['tousername'];
		$mediaid=$arr['mediaid'];
		$this->sendImageMessage($fromusername, $tousername, $mediaid);
	}
}