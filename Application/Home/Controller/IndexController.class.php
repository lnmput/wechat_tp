<?php
/*
 * 默认处理类
 * 
 * 
 */

namespace Home\Controller;


class IndexController extends WechatController {
    public function test()
    {
        
    	//创建二维码
    //	R('CreateParmaQrcode/createTempQrcode');
    //	R('CreateParmaQrcode/createForeverQrcode');
    	
    	//生成菜单
        // R('CreateMenu/createMenu');
        
    	//web开发相关
    	//R('WebDevelop/first');
    	
    	
    	//jssdk相关分享
    	//R('Jssdk/index');
    	// 模版消息发送
    	//R('TempletMessage/sendTempMessage2');
    	
    	//素材管理
    	R('SourceManage/index');
    }
	
    public function testweb()
    {
    	$data=R('WebDevelop/getUserinfoByAccessToken');
    	//$data='yangguoqi';
    	$this->assign('obj',$data);
    	//展示web页面
    	$this->display('index');
    }
	
	/*
	 * 默认触发接口
	 * 起初通过这里进行服务器的验证,验证通过后即可删除对应的调用代码
	 * 1.获得用户消息
	 * 2.响应用户消息
	 * 
	 */
	public function index()
	{


	   $basicRequestMessage=$this->getBasicRequestMessage();
	  
	   $this->fromusername=$basicRequestMessage['fromusername'];
	   $this->tousername=$basicRequestMessage['tousername'];
	   $this->msgtype=$basicRequestMessage['msgtype'];
	   
	   //根据不同的消息类型触发不同的动作
	   switch ($this->msgtype){
	   	  case 'event':
    	        $ResponseEventMessage=A('ResponseEventMessage');
    	        $ResponseEventMessage->index($basicRequestMessage);
    	        break;
	   	  case 'text':
	   	        $keyRequestTextMessage=$this->getKeyRequestTextMessage();
	   	        $ResponseTextMessage=A('ResponseTextMessage');
	   	        $ResponseTextMessage->index(array_merge($basicRequestMessage,$keyRequestTextMessage));
	   	        break;
	   	  case 'image':
	   	  	    $keyRequestImageMessage=$this->getKeyRequestImageMessage();
	   	  	    $ResponseImageMessage=A('ResponseImageMessage');
	   	  	    $ResponseImageMessage->index(array_merge($basicRequestMessage,$keyRequestImageMessage));
	   	  default:
	   	  	    $ResponseUnknowMessage=A('ResponseUnknowMessage');
	   	  	    $ResponseUnknowMessage->index($basicRequestMessage);
	   	  	    break;

	   }
	}
	
	public function createParmaQrcode()
	{
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
}