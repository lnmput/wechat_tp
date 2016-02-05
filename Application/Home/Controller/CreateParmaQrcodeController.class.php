<?php
namespace Home\Controller;

use Think\Log;
/*
 * 生成带参二维码类
 */

class CreateParmaQrcodeController extends WechatController
{
	public function index()
	{
		
	}
	
	/*
	 * 创建临时带参二维码
	 */
	public function createTempQrcode()
	{
		$ticketInfo=$this->getTempQrcodeTicket();
		$this->getQrcodeByTicket($ticketInfo['ticket']);
	}
	
	/*
	 * 创建永久带参二维码
	 */
	public function createForeverQrcode()
	{
		$ticketInfo=$this->getForverQrcodeTicket();
		$this->getQrcodeByTicket($ticketInfo['ticket']);
	}
	
	
	/*
	 * 获得临时二维码的ticket
	 * expire_seconds   二维码有效时间以秒为单位。 最大不超过2592000（即30天），此字段如果不填，则默认有效期为30秒。
	 * action_name  二维码类型，QR_SCENE为临时,QR_LIMIT_SCENE为永久,QR_LIMIT_STR_SCENE为永久的字符串参数值
	 * 
	 * action_info 二维码详细信息
	 * scene_id 场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）
	 */
	public function getTempQrcodeTicket()
	{
		$token=$this->getAccessToken();
		$expire_seconds='604800';
		$scene_id=mt_rand(0, pow(2, 10));
		$vars='{"expire_seconds": '.$expire_seconds.', "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
		Log::write('获得临时二维码ticket需要的参数:'.$vars);
		$url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$token;
		$result=postCURL($url, $vars);
		Log::write('获得临时二维码返回ticket返回值:'.$result);
		return json_decode($result,TRUE);
		
		
	}
	/*
	 * 
	 * 获得永久二维码ticket
	 */
	public function getForverQrcodeTicket()
	{
		$token=$this->getAccessToken();
		$scene_id=mt_rand(0, 100000);
		$vars='{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
		Log::write('获得永久二维码ticket需要的参数:'.$vars);
		$url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$token;
		$result=postCURL($url, $vars);
		Log::write('获得永久二维码返回ticket返回值:'.$result);
		return json_decode($result,TRUE);
		
	}
	
	
	/*
	 *通过ticket获取二维码
	 */
	public function getQrcodeByTicket($ticket){
		$url="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
		$result=getCURL($url);
		file_put_contents('Public/'.date("Y-m-d H:m:s").mt_rand(100, 999).'.png', $result);
	}
	
	
	
	
	
	
	
	
	
	
}