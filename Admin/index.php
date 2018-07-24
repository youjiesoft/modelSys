<?php
//定义项目名称和路径
define('APP_NAME', 'Admin');
define('APP_PATH', './');
if(file_exists("install") && !file_exists("install/install/lock")){
    header("Location: install/index.php");
    //确保重定向后，后续代码不会被执行
    exit;
}
// 开启调试模式
if(true){
	define('APP_DEBUG',true);
}else{
	define('APP_DEBUG',false);
}
//第三方模块目录
define('M_D', dirname(__FILE__)."/Module/");
define('ROOT', dirname(__FILE__));
//上传路径配置
define("UPLOAD_PATH", dirname(dirname(__FILE__))."/Public/Uploads/");
define("PUBLIC_PATH", dirname(dirname(__FILE__))."/Public/");
define("UPLOAD_Sample", dirname(dirname(__FILE__))."/Public/SampleExecl/");
define("UPLOAD_SampleWord", dirname(dirname(__FILE__))."/Public/SampleWord/");
define("UPLOAD_PATH_TEMP", dirname(dirname(__FILE__))."/Public/Uploadstemp/");
define("UPLOAD_SampleArchives", "SampleArchives");//档案管理处，目录模版下载
//配置文件柜地址
define("File_PATH_TEMP", dirname(dirname(__FILE__))."/Public/FileManager");
//签名路径配置
define("SIGNATURE_PATH", dirname(dirname(__FILE__))."/Public/Images/signature");
//自定义动态配置文件目录
define("DConfig_PATH", str_replace('\\', '/',dirname(dirname(__FILE__)).'/').APP_NAME."/Dynamicconf");

// 加载框架入口文件
require( "../ThinkPHP/ThinkPHP.php");
