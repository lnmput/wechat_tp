<?php
namespace Think\Log\Driver;

class Seaslog
{
	public function __construct()
	{
		\Seaslog::setBasePath(C("LOG_PATH"));
		\Seaslog::setLogger("Home");
	}
	
	public function write($log,$level="debug")
	{
		\Seaslog::debug($log);
	}
}