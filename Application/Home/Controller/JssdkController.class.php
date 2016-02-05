<?php
/*
 * js-sdk
 * 配置JS接口安全域名
 * 
 */
namespace Home\Controller;

use Lib\Jssdk\Jssdk;
class JssdkController extends WechatController
{

	/*
	 * 实例方法
	 * 分享链接必须是当前网页的链接
	 */
	public function index()
	{

		//组装分享信息数组
		$shareinfo=array(
				'sharetitle'=>"哈这里是分享标题可以自定义",
				'sharedesc'=>"这里是分享描述可以自定义",
				'sharelink'=>getURL(),
				'shareimg'=>'http://res.eqxiu.com/group3/M00/39/B4/yq0KZFYA3dyADBSjAABdkK-lZ5w964.png'
		);
		//获得appid和appsecret
		$appId=C("appID");
		$appSecret=C("appsecret");
		//实例化对象Jssdk,
		$jssdk=new Jssdk($appId, $appSecret);
		//获得分享功能数组
		$data=$jssdk->getSignPackage();
		//组装视图所需要的必要信息
        $this->assign('signPackage',array_merge($shareinfo,$data));
        //展示视图,具有分享功能的视图需要用到公共视图,具体参见实例
        $this->display('share');
	}
}
