<?php
header("Content-type:text/html;charset=utf-8");
define("ROOT_PATH",str_replace("\\","/",dirname(__FILE__)));
//判断是否已安装
if(!is_file("./install/lock") && is_file("./install/index.php")){
	@header("location:install/index.php");
}

echo "我的系统";