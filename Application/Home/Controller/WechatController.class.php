<?php
/*
 *所有微信处理类的公共父类
 *实现一些基本的方法
 *
 */
namespace Home\Controller;
use Think\Controller;
use Think\Log;
class WechatController extends Controller
{
	 public $fromusername='';
	 public $tousername='';
	 public $msgtype='';
	
	
	public function test(){
		echo "test";
	}
	/*
	 * 获取access_token
	 * 返回 
	 */
	public function getAccessToken()
	{
		$appID=C('appID');
		$appsecret=C('appsecret');
		$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appID . "&secret=" . $appsecret;
		$result=getCURL($url);
		$data=json_decode($result,true);
		return $data['access_token'];
	}
	/*
	 * 获取微信服务器ip地址
	 * 返回 数组
	 */
	public function getWechatServerIp(){
		$access_token=$this->getAccessToken();
		$url="https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$access_token;
		$result=getCURL($url);
	    $data=json_decode($result,true);
	    return $data;
	}
	
/*
 * ===========================================
 * 获得消息
 * ===========================================
 */
	
	/*
	 * 获得解析后的用户消息,转化成关联数组
	 * 将数组的所有的 KEY 都转换为小写
	 */
	public function requestMessage(){
		$xml = (array) simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA);
	    Log::write("接收到用户消息:".json_encode($xml));
		return  array_change_key_case($xml);
	}
	/*
	 * 根据数组的键名获得键值
	 * 
	 */
	public function getRequest($param=FALSE)
	{
		$requestMessage=$this->requestMessage();
		if ($param === FALSE) {
			return $requestMessage;
		}
		//转化成小写
		$param = strtolower($param);
		if (isset($requestMessage[$param])) {
			return $requestMessage[$param];
		}
		return NULL;
	}
	/*
	 * 获得所有类型消息的基本参数
	 * fromusername
	 * tousername
	 * msgtype
	 */
	public function getBasicRequestMessage()
	{
		$arrayMessage=array(
				"fromusername"=>$this->getRequest('fromusername'),
				"tousername"=>$this->getRequest('tousername'),
				"msgtype"=>$this->getRequest('msgtype')
		);
		if($arrayMessage['msgtype']=="event"){
			$arrayMessage["event"]=$this->getRequest('event');
		}
		return $arrayMessage;
	}
	
	/*
	 * 获得文字消息的关键参数
	* @parma Content
	* @parma MsgId
	*/
	public function getKeyRequestTextMessage()
	{
		return array(
				'content'=>$this->getRequest('content'),
				'msgid'=>$this->getRequest('msgid')
		);
	}
	
	
	/*
	 * 获得图片消息的关键参数
	* @parma PicUrl
	* @parma MediaId
	* @parma MsgId
	*/
	public function getKeyRequestImageMessage()
	{
		return array(
				"picurl"=>$this->getRequest('picurl'),
				"mediaid"=>$this->getRequest('mediaid'),
				'msgid'=>$this->getRequest('msgid')
		);
	}
	/*
	 * 获得地理位置消息的关键参数
	 * Latitude	地理位置纬度
	 * Longitude	地理位置经度
	 * Precision	地理位置精度
	 * 
	*/
	public function getKeyRequestLocationMessage()
	{
		return array(
				"latitude"=>$this->getRequest('Latitude'),
				"longitude"=>$this->getRequest('Longitude'),
				"precision"=>$this->getRequest('Precision')
		);
	}
	/*
	 * 扫描带参二维码事件
	 * 如果用户还未关注公众号，则用户可以关注公众号，关注后微信会将带场景值关注事件推送给开发者。
	 * Event	事件类型，subscribe
     * 如果用户已经关注公众号，则微信会将带场景值扫描事件推送给开发者。
     * Event	事件类型，SCAN
	 */
	public function getKeyRequestScanQrcodeMessage()
	{
		return array(
				"event"=>$this->getRequest("Event"),
				"eventkey"=>$this->getRequest("EventKey"),
				"ticket"=>$this->getRequest("Ticket"),
		);
	}
	
	/*
	 * 点击自定义菜单事件
	 * 点击菜单拉取消息时的事件推送 Event	事件类型，CLICK
	 * 点击菜单跳转链接时的事件推送 Event	事件类型，VIEW
	 * 
	 */
	public function getKeyRequestClickMenu()
	{
		return array(
				"event"=>$this->getRequest("Event"),
				"eventkey"=>$this->getRequest("EventKey"),
		);
	}
	
	
	
	
	
	
	
	
	
	
	/*
	 * ===========================================
	* 发送被动响应消息
	* ===========================================
	*/

	
	
	/*
	 * 回复普通文本消息函数
	* 需要参数：$fromusername,$tousername,$content(文本内容)
	*/
	
	function sendTextMessage($fromusername,$tousername,$content)
	{
		$tpl="<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
		$resultStr = sprintf($tpl, $fromusername, $tousername, time(),$content);
		echo $resultStr;
	}
	
	/*
	 * 回复图片消息
	* 需要参数：$fromusername, $tousername,$mediaid
	*/
	function sendImageMessage($fromusername, $tousername,$mediaid){
		$tpl="<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<Image>
<MediaId><![CDATA[%s]]></MediaId>
</Image>
</xml>";
		 
		$resultStr = sprintf($tpl, $fromusername, $tousername, time(),$mediaid);
		echo $resultStr;
	}
	
	
	/*
	 * ===========================================
	 *  其他方法
	 * ===========================================
	 */


	
}