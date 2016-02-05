<?php
/*
 * 素材管理类
 */
namespace Home\Controller;

use Think\Log;
class SourceManageController extends  WechatController
{
	public function  index()
	{
		//echo  "/var/www/v.vxndy.com/Public/images/shasha.jpg";
		$this->setForeverImageSource();
	}
	
	
	/*
	 * 上传临时资源
	 * 必须使用绝对路径
	 */
	public function setTemporarySource()
	{
		$access_token=$this->getAccessToken();
		$type="image";
		$path="/var/www/v.vxndy.com/Public/images/shasha.jpg";
		$vars=array('media'=>'@'.$path);
		$url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$type;
		$result=postCURL($url, $vars);
        Log::write('上传临时素材图片返回信息'.$result);
	}
	
	/*
	 * 
	 * 获取临时资源
	 * 
	 */
	public function getTemporarySource()
	{
		$access_token=$this->getAccessToken();
		$mediaid="";
		$url="https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$mediaid;
		$result=getCURL($url);
		Log::write("获取临时资源返回信息".$result);
	}
	
	/*
	 * 
	 * 上传永久资源
	 * 	媒体文件类型  image
	 * 
	 */
	public function setForeverImageSource()
	{
		$access_token=$this->getAccessToken();
		$path="/var/www/v.vxndy.com/Public/images/shasha.jpg";
		$vars=array('media'=>'@'.$path);
		$url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=".$access_token;
		$result=postCURL($url, $vars);
		Log::write('新增永久素材返回信息:'.$result);
		
	}
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
