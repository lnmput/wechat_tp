<?php
/*
 * 微信网页开发相关类
 * 
 * 使用方法:
 * 1.调用 getCodeByUserinfo  或者 getCodeByBase 方法,跳转到需要授权的网页
 * 2.在需要授权的网页调用 getUserinfoByAccessToken() 方法即可
 * 
 */
namespace Home\Controller;
use Think\Log;
class WebDevelopController extends WechatController
{
	
	
	/*
	 * 
	 * 实例方法:
	 * 
	 */
	public function index()
	{
		
		
	}
	
	/*
	 * 使用方法
	 * 1.调用first方法,首次访问地址,获取code
	 * 
	 * 2.调用second方法
	 * 获取用户信息,并携带信息加载视图
	 * 
	 * 
	 */
	public function first()
	{
		$appID=C("appID");
		$redirect_uri=urlencode("http://".$_SERVER['HTTP_HOST']."/index.php/home/WebDevelop/second");
		$state='yangzie';
		if(TRUE){
			$this->getCodeByUserinfo($appID, $redirect_uri, $state);
		}else{
			$this->getCodeByBase($appID, $redirect_uri, $state);
		}
		
	}
	
	public function second()
	{
		$data=$this->getUserinfoByAccessToken();
		//向视图传递数据
		$this->assign('obj',$data);
		//展示web页面
		$this->display('Index/index');
	}
	/*
	 * =========================================================
	 *   具体实现
	 * =========================================================
	 */
	
	
	/*
	 * 第一步：用户同意授权，获取code
	 * 如果用户同意授权，页面将跳转至 redirect_uri/?code=CODE&state=STATE。若用户禁止授权，则重定向后不会带上code参数，仅会带上state参数redirect_uri?state=STATE
	 * 注意:测试需要填写JS安全域名和 网页授权获取用户基本信息  域名 ,两项
	 * Scope为snsapi_userinfo,需要用户授权,不需要关注公众号
	 * Scope为snsapi_base 静默方式,需要关注公众号
	 */
	public function getCodeByUserinfo($appID,$redirect_uri,$state)
	{
		$scope="snsapi_userinfo";
		$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appID."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
		header("Location: $url");
	}
	/*
	 * 静默授权,需要
	 */
	public function getCodeByBase($appID,$redirect_uri,$state)
	{
		$scope="snsapi_base";
		$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appID."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
		header("Location: $url");
	}
	
	/*
	 * 第二步:通过code换取网页授权access_token
	 * 
	 * 返回如下参数:
	 * access_token	网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
	 * openid	用户唯一标识，请注意，在未关注公众号时，用户访问公众号的网页，也会产生一个用户和公众号唯一的OpenID
	 * scope	用户授权的作用域，使用逗号（,）分隔
	 */
	public function getAccessByCode()
	{
		$appID=C("appID");
		$appsecret=C("appsecret");
		$code=$_GET['code'];
		$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appID."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
		$result=getCURL($url);
		Log::write("通过code:".$code."换取网页授权access_token最后返回:".$result);
		return json_decode($result,TRUE);	
	}
    /*
     * 第三步：刷新access_token（如果需要）
     * 
     */
	public function refreshAccessToken()
	{
		$appID=C("appID");
		$info=$this->getAccessByCode();
		$refreshToken=$info['refresh_token'];
		$url="https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".$appID."&grant_type=refresh_token&refresh_token=".$refreshToken;
		$result=getCURL($url);
		Log::write('使用refresh_token:'.$refreshToken.'刷新access_token获取的结果为:'.$result);
		return json_decode($result,TRUE);
	}
	
	/*
	 * 第四步：拉取用户信息(需scope为 snsapi_userinfo)
	 * 如果网页授权作用域为snsapi_userinfo，则此时开发者可以通过access_token和openid拉取用户信息了。
	 * 
	 */
	public function getUserinfoByAccessToken()
	{
		$info=$this->getAccessByCode();
		$accessToken=$info['access_token'];
		$openId=$info['openid'];
		$url="https://api.weixin.qq.com/sns/userinfo?access_token=".$accessToken."&openid=".$openId."&lang=zh_CN";
		$result=getCURL($url);
		Log::write("通过access_token:".$accessToken."和openid:".$openId."最终获取授权用户信息:".$result);
		return json_decode($result,TRUE);
	}
	
	
	
	
	
	
	
	
}