<?php
/*
 * 事件处理类
 */
namespace  Home\Controller;

use Think\Log;
class ResponseEventMessageController extends WechatController
{
	
	public function index($arr=array())
	{
		Log::write("响应事件获得参数:".json_encode($arr));
			switch ($arr['event']) {
		 	        //关注事件
		 			case 'subscribe':
		 			    $this->responseSubscribeEvent($arr);
		 				break;
		 	        //取消关注事件
		 			case 'unsubscribe':
		 				$this->responseUnsubscribeEvent($arr);
		 				break;
		 	        //二维码扫描
		 			case 'SCAN':
		 				$this->responseScanQrcodeEvent($arr);
		 				break;
		 	        //地理位置上报
		 			case 'LOCATION':
		 				$this->
		 				break;
		 	        //菜单点击
		 			case 'CLICK':
		 				$this->responseClickMenuEvent($arr);
		 				break;
		 		}
	}
	/*
	 * 关注事件
	 * 有一种情况,就是扫描了带有参数的二维码,这时候,他多了两个参数
	 * 
	 */
	public function responseSubscribeEvent($arr=array())
	{
		Log::write('开始处理关注事件');
		if(isset($arr['ticket'])){
			Log::write('通过扫描带有参数的二维码关注');
			$info=$this->getKeyRequestScanQrcodeMessage();
			$scanQrcodeInfo=array_merge($arr,$info);
			Log::write("未关注用户扫描了带参二维码后最后获得全部信息:".json_encode($scanQrcodeInfo));
		}else{
			Log::write('通过其他方式关注');
		}
		
		
		
	}
	public function responseUnsubscribeEvent($arr=array())
	{
		Log::write('开始处理取消关注事件');
	}
	public function responseLocationEvent($arr=array())
	{
		Log::write("开始处理地理位置上报事件");
	}
	
	public function responseScanQrcodeEvent($arr=array())
	{
		Log::write("开始处理扫已关注用户描带参二维码事件");
		$info=$this->getKeyRequestScanQrcodeMessage();
		$scanQrcodeInfo=array_merge($arr,$info);
        Log::write("已关注用户扫描了带参二维码后最后获得全部信息:".json_encode($scanQrcodeInfo));
		
		//根据场景id对用户做出相应的动作
        $fromusername=$scanQrcodeInfo['fromusername'];
        $tousername=$scanQrcodeInfo['tousername'];
        $content='你扫描的二维码的场景id:'.$scanQrcodeInfo['eventkey'];
        $this->sendTextMessage($fromusername, $tousername, $content);
        
        
        
        
	}
	
	public function responseClickMenuEvent($arr=array())
	{
		Log::write("开始处理点击菜单事件");
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}