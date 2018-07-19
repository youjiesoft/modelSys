<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(电脑维修记录) 
 * @author chenxj 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-4-20 下午4:14:00 
 * @version V1.0
 */
class MisComputerFixLogAction extends CommonAuditAction{
	/**
	 * @Title: _filter
	 * @Description: todo(构造检索条件)
	 * @param HASHMAP $map
	 * @author 杨东
	 * @date 2013-5-31 下午4:01:22
	 * @throws
	 */
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
	}
	/**
	 * @Title: _before_edit
	 * @Description: todo(打开修改页面前置函数)
	 * @author 杨东
	 * @date 2013-5-31 下午4:11:26
	 * @throws
	 */
	public function _before_edit(){
		$model=M("mis_system_department");
		$list =$model->field("id,name")->select();
		$this->assign("department_idlist",$list);
		$model=M("mis_computer");
		$list =$model->field("id,name")->select();
		$this->assign("computer_idlist",$list);
		//查询处理进度
		$this->getdotype();
	}
	/**
	 * @Title: _after_edit
	 * @Description: todo(打开修改页面后置函数)
	 * @param 单头数据 $returnData
	 * @author 杨东
	 * @date 2013-6-1 下午3:02:21
	 * @throws
	 */
	public function _after_edit(&$returnData){
		/* 修改表单，故障类型，显示 */
		$falut_type=$returnData['falut_type'];
		switch($falut_type){
			case 1: 
				$moreInfoArray = array('更换系统','重装系统','驱动蓝屏','系统升级');
				break;
			case 2:
				$moreInfoArray = array('主板','CPU','内存','硬盘','显卡','电源','光驱','网卡','鼠标','键盘','UPS','音箱','读卡器','显示器','摄像头','打印机','复印机','投影机','相机','摄像机','电话机','交换机','无线路由器','电话交换机','移动硬盘','其它');
				break;
			case 3:
				$moreInfoArray = array('网络软件','系统工具','杀素软件','应用软件','联络聊天','图形图像','多媒体类','行业软件','游戏娱乐','编程开发','杀毒安全','教育教学');
				break;
			case 4:
				$moreInfoArray = array('路由器','打印共享','网线','电源','网卡','接口','其它');
				break;
			case 5:
				$moreInfoArray = array('宏病毒','CAD病毒','木马病毒','蠕虫病毒','未知病毒','其它');
				break;
			case 6:
				$moreInfoArray = array("电路原因","被盗","其它");
			default:
				$moreInfoArray = array('请重新选择');
				break;
		}
		$this->assign('falut_sub_type_idlist', $moreInfoArray);
	}
	/**
	 * @Title: _before_add
	 * @Description: todo(打开新增前置函数)
	 * @author 杨东
	 * @date 2013-6-1 下午3:37:38
	 * @throws
	 */
	public function _before_add(){
		/* 部门信息 */
		$model=M("mis_system_department");
		$list =$model->field("id,name")->select();
		$this->assign("department_idlist",$list);
		$model=M("mis_computer");
		$list =$model->field("id,name")->select();
		$this->assign("computer_idlist",$list);
		$this->assign("time",time());
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		$this->assign("userid",$userid);
	}
	/**
	 * @Title: _before_auditEdit 
	 * @Description: todo(审核前置)   
	 * @author libo 
	 * @date 2014-4-22 上午11:40:01 
	 * @throws
	 */
	public function _before_auditEdit(){
		$model=M("mis_system_department");
		$list =$model->field("id,name")->select();
		$this->assign("department_idlist",$list);
		$model=M("mis_computer");
		$list =$model->field("id,name")->select();
		$this->assign("computer_idlist",$list);
	}
	public function _before_auditView(){
		//查询处理状态
		$this->getdotype();
		//
		$model=M("mis_system_department");
		$list =$model->field("id,name")->select();
		$this->assign("department_idlist",$list);
		$model=M("mis_computer");
		$list =$model->field("id,name")->select();
		$this->assign("computer_idlist",$list);
	}
	/**
	 * @Title: lookup
	 * @Description: todo(查询员工信息)   
	 * @author 杨东 
	 * @date 2013-6-1 下午4:46:39 
	 * @throws 
	*/  
	public function lookup() {
		$searchby=array(
				array("id" =>"mis_computer_fix_log-name","val"=>"按计算机名称"),
				array("id" =>"mis_computer_fix_log-code","val"=>"按计算机编号"),

		);
		$searchtype=array(
				array("id" =>"2","val"=>"模糊查找"),
				array("id" =>"1","val"=>"精确查找")
		);
		$this->assign("searchtypelist",$searchtype);
		$this->assign("searchbylist",$searchby);
		//检索部分
		if(!empty($_POST['keyword'])){
			$searchtypes=	$_POST['searchtype'];
			$searchbys	= 	str_replace("-",".",$_POST['searchby']);
			$keywords	=	$_POST['keyword'];
			$map[$searchbys]=$searchtypes==2 ? array('like',"%".$keywords."%"):$keywords;
			//保留状态
			$this->assign('keyword',$keywords);
			$searchbys	= 	str_replace(".","-",$_POST['searchby']);
			$this->assign('searchby',$searchbys);
			$this->assign('searchtype',$searchtypes);
		}
		$map['mis_computer.status']=1;
		$this->_list('MisComputer',$map);
		$this->display("lookup");
	}
	
	/**
	 *
	 * @Title: lookupmanage
	 * @Description: todo(用ztree形式查询出所有部门员工信息)
	 * @author liminggang
	 * @throws
	 */
	public function lookupmanage(){
		//组装tree
		$model= M('mis_system_department');
		$deptlist = $model->where("status=1")->order("id asc")->select();
		$param['rel']="miscomputerfixlogBox";  //重要的地方，查找带回模板上的ID
		$param['url']="__URL__/lookupmanage/jump/1/deptid/#id#/parentid/#parentid#";
		$typeTree = $this->getTree($deptlist,$param);
		$this->assign('tree',$typeTree);
		//查询条件
		$map = array();
		$searchby = str_replace("-", ".", $_POST["searchby"]);
		$keyword=$this->escapeChar($_POST["keyword"]);
		$searchtype = $_POST['searchtype'];
		//关键字是否为空
		if($_POST["keyword"]){
			if($searchby=='user_id'){
				$modelHPPI=M('mis_hr_personnel_person_info');
				$map2['name'] = ($searchtype==2)  ? array('like','%'.$keyword.'%'):$keyword;
				$userIDList=$modelHPPI->where($map2)->getField('id,name');
				$map['user_id'] = array('in',array_keys($userIDList));
			}else{
				$map[$searchby] = ($searchtype==2)  ? array('like','%'.$keyword.'%'):$keyword;
			}
						
			$this->assign('keyword',$keyword);
			$searchby = str_replace(".", "-", $_POST["searchby"]);
			$this->assign('searchby',$searchby);
			$this->assign('searchtype',$searchtype);
		}
		//搜索按哪个类型
		$searchby=array(
				array("id" =>"user_id","val"=>"姓名"),
				array("id" =>"name","val"=>"计算机编号"),
		);
		$this->assign("searchbylist",$searchby);
		//模糊查询还是精确查询
		$searchtype=array(array("id" =>"2","val"=>"模糊查找"),array("id" =>"1","val"=>"精确查找"));
		$this->assign("searchtypelist",$searchtype);
		$deptid		= $_REQUEST['deptid'];
		if ($deptid) {
			$map['department_id']=$deptid;
		}
		if($_REQUEST['report_name']){
			$map['user_id']=$_REQUEST['report_name'];
		}
		$commmodel=A("Common");
		$commmodel->_list('MisComputer',$map);
		$this->assign('deptid',$deptid);		
		if ($_REQUEST['jump']) {
			$this->display('lookupmanagelist'); //如果jump=1 ; 那么是刷新右侧数据区
		} else {
			$this->display("lookupmanage"); //如果jump= 空 ; 第一弹出窗口
		}
	}
	/**
	 * @Title: combox_getFalutTypeValue
	 * @Description: todo(级联，计算机故障分类)   
	 * @author 杨东 
	 * @date 2013-6-1 下午4:46:57 
	 * @throws 
	*/  
	public function combox_getFalutTypeValue(){
		$showWhichJson = $_REQUEST['kvalue'];
		$this->assign('showWhichJson',$showWhichJson);
		$this->display('getFalutTypeValue'); //模板名与方法名不一样
	}
}
?>