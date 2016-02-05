<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<h1>share</h1>
<?php echo ($obj->test()); ?>


<?php echo ($signPackage["appId"]); ?>
<br>
<?php echo ($signPackage["timestamp"]); ?>

</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
	  "onMenuShareTimeline",
	  "onMenuShareAppMessage",
	  "onMenuShareQQ"  
    ]
  });
  wx.ready(function () {
    // 在这里调用 API
	wx.onMenuShareTimeline({
    title: '分享到朋友圈', // 分享标题
    link: 'http://www.feof.com', // 分享链接
    imgUrl: 'http://7nj3d5.com1.z0.glb.clouddn.com/share.png', // 分享图标
    success: function () { 
        // 用户确认分享后执行的回调函数
		alert("success");
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
		alert("fail");
    }
 }),
	wx.onMenuShareAppMessage({
    title: '分享给我的朋友', // 分享标题
    desc: '这里是分享描述', // 分享描述
    link: 'http://www.baidi.com', // 分享链接
    imgUrl: 'http://7nj3d5.com1.z0.glb.clouddn.com/share.png', // 分享图标
    type: '', // 分享类型,music、video或link，不填默认为link
    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    success: function () { 
        // 用户确认分享后执行的回调函数
		alert("success");
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
		alert("fail");
    }
}),
wx.onMenuShareQQ({
    title: '分享到QQ', // 分享标题
    desc: '分享描述', // 分享描述
    link: 'http://www.baidu.com', // 分享链接
    imgUrl: 'http://7nj3d5.com1.z0.glb.clouddn.com/share.png', // 分享图标
    success: function () { 
       // 用户确认分享后执行的回调函数
	   alert("success");
    },
    cancel: function () { 
       // 用户取消分享后执行的回调函数
	   alert("fail");
    }
})
});
</script>
</html>