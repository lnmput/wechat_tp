<?php
return array(
	//'配置项'=>'配置值'
    'appID'=>'wx1f81e830a9e3cd50',
	'appsecret'=>'eb5e62f8c65c29c4344e5e95c73a3603',
	'LOG_RECORD' => true,  //开启日志
	'LOG_LEVEL'  =>'ERR', // 只记录EMERG ALERT CRIT ERR 错误
	'LOG_TYPE'              =>  'File', // 日志记录类型 默认为文件方式
	//加载扩展配置文件
	'LOAD_EXT_CONFIG' => 'menuConfig',

);