<?php
/*
 * 模板消息发送类
 */
namespace Home\Controller;

use Think\Log;
class TempletMessageController extends WechatController
{
	public function index()
	{
		echo "TempletMessageController index";
	}
	
	/*
	 * 说明通过@function1和@function2发送的模板消息数需要手动在
	 * 微信后台中增加模板消息,并获得模板id
	 * 
	 * 
	 */
	
	
	/*
	 * 调用发送模板消息
	 * @function1
	 */
	public function sendTempMessage()
	{
		$access_token=$this->getAccessToken();
		$vars=$this->getTempMessage();
		$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
		$result=postCURL($url, $vars);
		Log::write('发送模板消息参数url:'.$url);
		Log::write('发送模板消息参数vars:'.$vars);
		$info=(array) simplexml_load_string($result);
		Log::write("发送模板消息最后返回数据".json_encode($info));
	}
	/*
	 * 
	 * 组装模板消息
	 * @function2
	 */
	public function getTempMessage()
	{
// 		{{first.DATA}}
// 		签到时间：{{keyword1.DATA}}
// 		签到地点：{{keyword2.DATA}}
// 		登录密码：{{keyword3.DATA}}
// 		{{remark.DATA}}
		$touser_openid = 'oJUknswxI-hnF6aBQsZhRhYiUYmk';
		$template_id = 'tiR_ei6vqi05GOZLzU-BnjJc_EzmAAReJLfcriGOy3U';
		
		$url="http://weixin.com";
		
		$data = array(
				'keyword1' => array(
						"value" => "张三",
						"color" => "#173177"
				),
				'keyword2' => array(
						"value" => "高级经理",
						"color" => "#173177"
				),
				'keyword3' => array(
						"value" => "通过",
						"color" => "#173177"
				),
		);
		$arrayData = array(
				"touser" => $touser_openid,
				"template_id" => $template_id,
				"url" => $url,
				"topcolor" => "#FF0000",
				"data" => $data
		);
		$sendJsonData = json_encode($arrayData);
		return $sendJsonData;
	}
	
	/*
	 * ==========================
	 *  自动获根据模板库中的模板编号获得模板id
	 * 需要实现挑选好自己要用的模板,并获得模板编号
	 * 例子:使用模板编号为OPENTM203763477 的购票成功通知
	 *  
	 *  {{first.DATA}}
	 *	展会名称：{{keyword1.DATA}}
	 *	展会地点：{{keyword2.DATA}}
	 *	门票有效期：{{keyword3.DATA}}
	 *	购票数量：{{keyword4.DATA}}
	 *	{{remark.DATA}}
	 *  您好，你已购票成功！
	 *  展会名称：2015 第十六届上海国际汽车工业展览会
	 *  展会地点：国家会展中心（上海盈港东路168号）
	 *  门票有效期：2015年4月22日-4月29日
	 *  购票数量：2
	 *  请点击查看购买的门票，感谢您的使用！
	 *
	 *
	 *
	 *
	 * 调用发方式：R('TempletMessage/sendTempMessage2');
	 * ==========================
	 */
	
	 /*
	  * 第一:
	  * @ 设置所属行业
	  * post方式
	  */
	public function setIndustry()
	{
		$access_token=$this->getAccessToken();
		$vars='{
          "industry_id1":"1",
          "industry_id2":"4"
         }';
		$url="https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=".$access_token;
		$result=postCURL($url, $vars);
	}
	
	/*
	 * 获得模板id
	 * 
	 */
	public function getTempId()
	{
		$template_id_short="OPENTM203763477";
		$access_token=$this->getAccessToken();
		$vars=' {
           "template_id_short":"'.$template_id_short.'"
         }';
		$url="https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=".$access_token;
		$result=postCURL($url, $vars);
		$info=json_decode($result,TRUE);
		if($info['errcode']==0){
			Log::write("根据模板编号".$template_id_short."获取模板id成功返回消息：".$result);
			return $info['template_id'];
		}else{
			Log::write("根据模板编号".$template_id_short."获取模板id失败返回消息：".$result);
			exit;
		}
	}
	
	
	/*
	 * 发送模板消息
	 * 
	 */
	
	 public function sendTempMessage2()
	 {
	 	$access_token=$this->getAccessToken();
	 	$vars= $this->getTempMessage2();
	 	$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $result=postCURL($url, $vars);
		Log::write('发送模板消息参数url:'.$url);
		Log::write('发送模板消息参数vars:'.$vars);
		$info=(array) simplexml_load_string($result);
		Log::write("发送模板消息最后返回数据".json_encode($info));	
	 }
	 /*
	  * 
	  * 获得组装后的模板消息
	  */
	
	 public function getTempMessage2()
	 {

	 	$touser_openid = $this->getUserOpenid();
	 	$template_id   = $this->getTempId();   
	 
	 	$url="http://u.vxndy.com";
	 
	 	$data = array(
	 			'keyword1' => array(
	 					"value" => "2015 第十六届上海国际汽车工业展览会",
	 					"color" => "#173177"
	 			),
	 			'keyword2' => array(
	 					"value" => "国家会展中心（上海盈港东路168号）",
	 					"color" => "#173177"
	 			),
	 			'keyword3' => array(
	 					"value" => "2015年4月22日-4月29日",
	 					"color" => "#173177"
	 			),
	 			'keyword4' => array(
	 					"value" => "2",
	 					"color" => "#173177"
	 			),
	 	);
	 	$arrayData = array(
	 			"touser" => $touser_openid,
	 			"template_id" => $template_id,
	 			"url" => $url,
	 			"topcolor" => "#FF0000",
	 			"data" => $data
	 	);
	 	$sendJsonData = json_encode($arrayData);
	 	return $sendJsonData;
	 }
	
	 /*
	  * 
	  * 获取需要发送模板消息用户的openid
	  */
	public function getUserOpenid()
	{
		return "oJUknswxI-hnF6aBQsZhRhYiUYmk";
	}
	
	
	
	
	
	
}