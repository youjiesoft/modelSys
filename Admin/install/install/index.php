<?php
set_time_limit(0);   //设置运行时间
error_reporting(E_ALL & ~E_NOTICE);  //显示全部错误
define('ROOT_PATH', dirname(dirname(__FILE__)));  //定义根目录
define('DBCHARSET','UTF8');   //设置数据库默认编码
if(function_exists('date_default_timezone_set')){
	date_default_timezone_set('Asia/Shanghai');
}
input($_GET);
input($_POST);
function input(&$data){
	foreach ((array)$data as $key => $value) {
		if(is_string($value)){
			if(!get_magic_quotes_gpc()){
				$value = htmlentities($value, ENT_NOQUOTES);
                $value = addslashes(trim($value));
			}
		}else{
			$data[$key] = input($value);
		}
	}
}
//判断是否安装过程序
if(is_file('lock') && $_GET['step'] != 5){
	@header("Content-type: text/html; charset=UTF-8");
    echo "系统已经安装过了，如果要重新安装，那么请删除install目录下的lock文件";
    exit;
}

$html_title = '程序安装向导';
$html_header = <<<EOF
<div class="header">
  <div class="layout">
    <div class="title">
      <h5>友捷科技平台系统</h5>
      <h2>系统安装向导</h2>
    </div>
    <div class="version">版本: 2018.07.19.0001</div>
  </div>
</div>
EOF;

$html_footer = <<<EOF
<div class="footer">
  <h5>Powered by <font class="blue">YOUJIE</font><font class="orange"></font></h5>
  <h6>版权所有 2018-2028 &copy; <a href="http://www.XXXX.com" target="_blank">友捷科技</a></h6>
</div>
EOF;
require('./include/function.php');
if(!in_array($_GET['step'], array(1,2,3,4,5))){
	$_GET['step'] = 0;
}
switch ($_GET['step']) {
	case 1:
		require('./include/var.php');
		env_check($env_items);
        dirfile_check($dirfile_items);
        function_check($func_items);
		break;
	case 3:
		$install_error = '';
        $install_recover = '';
        $demo_data =  file_exists('./data/utf8_add.sql') ? true : false;
        step3($install_error,$install_recover);
        break;
	case 4:
		
		break;
	case 5:
		$sitepath = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
        $sitepath = str_replace('/install',"",$sitepath);
        $auto_site_url = 'http://'.$_SERVER['HTTP_HOST'].$sitepath;
		break;
	default:
		# code...
		break;
}

include ("step_{$_GET['step']}.php");

function step3(&$install_error,&$install_recover){
    global $html_title,$html_header,$html_footer;
    if ($_POST['submitform'] != 'submit') return;
    $db_host = $_POST['db_host'];
    $db_port = $_POST['db_port'];
    $db_user = $_POST['db_user'];
    $db_pwd = $_POST['db_pwd'];
    $db_name = $_POST['db_name'];
    $db_prefix = "";//$_POST['db_prefix'];
    $admin = $_POST['admin'];
    $password = $_POST['password'];
    if (!$db_host || !$db_port || !$db_user || !$db_pwd || !$db_name || !$admin || !$password){
        $install_error = '输入不完整，请检查';
    }
//    if(strpos($db_prefix, '.') !== false) {
//        $install_error .= '数据表前缀为空，或者格式错误，请检查';
//    }

    if(strlen($admin) > 15 || preg_match("/^$|^c:\\con\\con$|　|[,\"\s\t\<\>&]|^游客|^Guest/is", $admin)) {
        $install_error .= '非法用户名，用户名长度不应当超过 15 个英文字符，且不能包含特殊字符，一般是中文，字母或者数字';
    }
    if ($install_error != '') reutrn;
        $mysqli = @ new mysqli($db_host, $db_user, $db_pwd, '', $db_port);
        if($mysqli->connect_error) {
            $install_error = '数据库连接失败';return;
        }


    if($mysqli->error) {
        $install_error = $mysqli->error;return ;
    }
    if($_POST['install_recover'] != 'yes' && ($query = $mysqli->query("SHOW TABLES FROM $db_name"))) {
        while($row = mysqli_fetch_array($query)) {
            if(preg_match("/^$db_prefix/", $row[0])) {
                $install_error = '数据库已存在，请修改';
                return;
            }
        }
    }else{
        $_POST['install_recover'] ='yes';
        if($mysqli->get_server_info()> '5.0') {
            $mysqli->query("CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET ".DBCHARSET);
        } else {
            $install_error = '数据库必须为MySQL5.0版本以上';return;
        }
    }





    require ('step_4.php');
    $sitepath =substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
    $sitepath = str_replace('install',"",$sitepath);
    $auto_site_url = 'http://'.$_SERVER['HTTP_HOST'].$sitepath;
    write_config($auto_site_url);
    
    $_charset = DBCHARSET;
    $mysqli->select_db($db_name);
    $mysqli->set_charset($_charset);

    $path = 'data/sql';
    $result = scanFile($path);
      $sql=null;
    foreach ($result as $re){
        //$sql .= file_get_contents($re);
    }


    //判断是否安装测试数据
    if ($_POST['demo_data'] == '1'){
        $sql .= file_get_contents("data/sql_add/utf8_add.sql");
    }

    $path1 = 'data/sql_add';
    $result1 = scanFile($path1);
    foreach ($result1 as $re1){
        $sql .= file_get_contents($re1);
    }
    $sql = str_replace("\r\n", "\n", $sql);
    $boo = runquery($sql,$db_prefix,$mysqli);
    if($boo=='0'){
        showjsmessage('<span style="color: red;font-weight: bolder;">操作失败</span>');
    }else{
        showjsmessage('<span style="color: green;font-weight: bolder;">操作成功</span>');
    }
    /**
     * 转码
     */
    $sitename = $_POST['site_name'];
    $username = $_POST['admin'];
    $password = $_POST['password'];
    /**
     * 产生随机的md5_key，来替换系统默认的md5_key值
     */
    $md5_key = md5(random(4).substr(md5($_SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT'].$db_host.$db_user.$db_pwd.$db_name.substr(time(), 0, 6)), 8, 6).random(10));
    //$mysqli->query("UPDATE {$db_prefix}setting SET value='".$sitename."' WHERE name='site_name'");
   
    //管理员账号密码
    $mysqli->query("INSERT INTO user (`id`, `account`, `name`, `zhname`, `sex`, `duty_id`, `dept_id`, `role_id`, `auditduty`, `attachdept`, `attachrole`, `orderdisplay`, `knowledgedisplay`, `projectdisplay`, `password`, `bind_account`, `work_date`, `last_login_time`, `last_login_ip`, `login_count`, `login_error_count`, `verify`, `tel`, `mobile`, `mobilestatus`, `qq`, `email`, `remindid`, `reportmethod`, `remark`, `createtime`, `createid`, `operateid`, `updatetime`, `updateid`, `status`, `typeid`, `info`, `score`, `expertmanage`, `employeid`, `ispur`, `imgname`, `channel`, `isonline`, `sessionid`, `logintime`, `leavetime`, `companyid`, `departmentid`, `newmsg`, `newmsgtype`, `isnewmsg`, `sort`, `pinyin`, `projectdefset`, `loginnumstatus`, `questionpwd`, `solidpath`, `appdateils`, `sysdutyid`, `relationmodelname`, `anquandengji`, `shangji`, `usertype`, `txsj`, `yongyouorderno`, `zhpassword`) VALUES ('1', '$username', '管理员', '管理员', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', NULL, '0', '".md5($password)."', NULL, NULL, '".time()."', '127.0.0.1', '4208', '0', NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, '1', '1', NULL, '0', '0', NULL, '0', NULL, NULL, '1', 'e10adc3949ba59abbe56e057f20f883e', '1531964859', NULL, NULL, '0', '1', '1', '1', NULL, 'GLY', '0', '0', NULL, NULL, NULL, '0', '0', NULL, NULL, '1', NULL, NULL, 'hndgs20180804');");


    //测试数据
    if ($_POST['demo_datademo_data'] == '1'){
        //$sql .= file_get_contents("data/{$_charset}_add.sql");
    }
    //新增一个标识文件，用来屏蔽重新安装
    $fp = @fopen('lock','wb+');
    @fclose($fp);
    exit("<script type=\"text/javascript\">document.getElementById('install_process').innerHTML = '安装完成，下一步...';document.getElementById('install_process').href='index.php?step=5&sitename={$sitename}&username={$username}&password={$password}';</script>");
    exit();
}
//execute sql

function scanFile($path) {
    global $result;
    $files = scandir($path);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            if (is_dir($path . '/' . $file)) {
                scanFile($path . '/' . $file);
            } else {
                $result[] = $path.'/'.basename($file);

            }
        }

    }
    return $result;
}
function  runquery($sql, $db_prefix, $mysqli) {
//  global $lang, $tablepre, $db;
    if(!isset($sql) || empty($sql)) return;
    $sql = str_replace("\r", "\n", str_replace('#__', $db_prefix, $sql));
    $ret = array();
    $num = 0;
    foreach(explode(";\n", trim($sql)) as $query) {
        $ret[$num] = '';
        $queries = explode("\n", trim($query));
        foreach($queries as $query) {
            $ret[$num] .= (isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0].$query[1] == '--') ? '' : $query;
        }
        $num++;
    }
    unset($sql);

    foreach($ret as $query) {

        //$query = trim($query);
        if($query) {
            if(substr($query, 0, 12) == 'CREATE TABLE') {
                $line = explode('`',$query);
                $data_name = $line[1];
                //$f=$mysqli->query(droptable($data_name));
                $flag = $mysqli->query($query);
                if($flag){
                    showjsmessage('数据表  '.$data_name.' ... 创建<span style="color: green;">成功</span>');
                }else{
                    showjsmessage('<span style="color: red; font-weight: bold;">数据表  '.$data_name.' ... 创建失败<br>创建终止</span>');
                    return "0";
                    break ;
                }

                unset($line,$data_name);
            }

        }
    }
    addtable($ret,$mysqli);

}
function addtable($ret,$mysqli){
    //showjsmessage('<font style="color:grey;">正在添加数据——————————————</font>');
    foreach($ret as $query) {
        if($query) {
            if(substr($query, 0, 11) == 'INSERT INTO') { //判断添加数据的表是否存在
                $line = explode('`',$query);
                $data_name = $line[1];
                //$f=$mysqli->query(droptable($data_name));
                $flag = $mysqli->query($query);
                if(!$flag){
                    showjsmessage('<span style="color: red; font-weight: bold;">数据表  '.$data_name.' ... 不存在，添加失败<br>添加数据终止</span>');
                    return "0";
                    break;
                }
                unset($line,$data_name);
            }
        }
    }

}
//抛出JS信息
function showjsmessage($message) {
    echo '<script type="text/javascript">showmessage(\''.addslashes($message).' \');</script>'."\r\n";
    flush();
    ob_flush();
}

//写入config文件
function write_config($url) {
    extract($GLOBALS, EXTR_SKIP);
    $file = '../../../Admin/Conf/db.inc.php';
    $conf = '../../../Admin/Conf/configbase.php';
    $configfile = file_get_contents($conf);
    $configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
    $charset = 'UTF-8';
    $db_host = $_POST['db_host'];
    $db_port = $_POST['db_port'];
    $db_user = $_POST['db_user'];
    $db_pwd = $_POST['db_pwd'];
    $db_name = $_POST['db_name'];
    $db_prefix = $_POST['db_prefix'];
    $admin = $_POST['admin'];
    $password = $_POST['password'];
    $db_type = 'mysql';
    $cookie_pre = strtoupper(substr(md5(random(6).substr($_SERVER['HTTP_USER_AGENT'].md5($_SERVER['SERVER_ADDR'].$db_host.$db_user.$db_pwd.$db_name.substr(time(), 0, 6)), 8, 6).random(5)),0,4)).'_';
    $configfile = str_replace("===url===",          $url, $configfile);
    $configfile = str_replace("===db_prefix===",    $db_prefix, $configfile);
    $configfile = str_replace("===db_charset===",   $charset, $configfile);
    $configfile = str_replace("===db_host===",      $db_host, $configfile);
    $configfile = str_replace("===db_user===",      $db_user, $configfile);
    $configfile = str_replace("===db_pwd===",       $db_pwd, $configfile);
    $configfile = str_replace("===db_name===",      $db_name, $configfile);
    $configfile = str_replace("===db_port===",      $db_port, $configfile);
    file_put_contents($file, $configfile);

}
