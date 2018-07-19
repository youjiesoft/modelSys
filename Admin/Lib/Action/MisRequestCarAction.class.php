<?php
/** 
 * @Title: MisRequestCarAction 
 * @Package package_name
 * @Description: todo(派车申请) 
 * @author 杨东 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-6-1 下午4:13:51 
 * @version V1.0 
*/ 
class MisRequestCarAction extends CommonAuditAction {
	/**
	 * @Title: _filter
	 * @Description: todo(构造检索条件)
	 * @param HASHMAP $map
	 * @author 杨东
	 * @date 2013-5-31 下午4:01:22
	 * @throws
	 */
	public function _filter(&$map){
		if ($_SESSION["a"] != 1){
			$map['status']=array("gt",-1);	
			$map['_string']="1=1";
		}
	}
	/**
	 * @Title: _before_add
	 * @Description: todo(打开新增前置函数)
	 * @author 杨东
	 * @date 2013-6-1 下午3:37:38
	 * @throws
	 */
	public function _before_add(){
		$model=M("mis_system_department");
		$list =$model->where('status = 1')->field("id,name")->select();
		$this->assign("departmentIDlist",$list);
		
		//读取其本信息从车辆基本信息库，只选部门ＩＤ是2的，即是公共用车
		$model=M("mis_system_car");
		$list =$model->where('carbelong=2 and status = 1')->field("id,name,carno")->select();
		$this->assign("carIDlist",$list);
		//申请人
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		$deptid = $_SESSION['user_dep_id'];
		
		$this->assign('username',getFieldBy($userid,'id','name','User'));
		$this->assign('userid',$userid);
		$this->assign('deptid',$deptid);
		$this->getcartype();
		//自动编码
		$scnmodel = D('SystemConfigNumber');
		$orderno = $scnmodel->GetRulesNO('mis_request_car');
		$this->assign("orderno", $orderno);
	}
	private  function getcartype(){
		$model = D("MisVehicleType");
		$CarTypeList = $model->where("status = 1")->select();
		$this->assign("CarTypeList",$CarTypeList);
	}
	public function _after_update(){
		$this->set_expand_property($_POST);
	}
	/**
	 * @Title: _before_edit 
	 * @Description: todo(进入修改)   
	 * @author laicaixia 
	 * @date 2013-6-4 下午5:25:04 
	 * @throws 
	*/  
	public function _before_edit(){
		$model=M("mis_system_department");
		$list =$model->field("id,name")->select();
		$this->assign("departmentIDlist",$list);
		$model=M("mis_system_car");
		$list =$model->where('carbelong=2')->field("id,name")->select();
		$this->assign("carIDlist",$list);
		$this->getcartype();
	}
	
	/**
	 * @Title: _after_edit
	 * @Description: todo(打开修改页面后置函数)
	 * @author
	 * @date 2013-5-31 下午4:11:26
	 * @throws
	 */
	public function _after_edit( &$vo ){
		if($vo['positiondetails']) $vo["positiondetails"]=unserialize($vo["positiondetails"]);
		$arr['tableid']=$vo['id'];
		$arr['modelname']=$this->getActionName();
		$model = M("mis_typeform_data");
		$data=array();
		$expand_property_info = $model->where($arr)->find();
		if($expand_property_info){
			$data = unserialize($expand_property_info['content']);
			$this->assign("expand_property_data_id",$expand_property_info['id']);
		}
		$expand_property= $this->get_expand_property($arr,$data);
		$this->assign("expand_property",$expand_property);
	}
	/**
	 * @Title: _before_auditEdit
	 * @Description: todo(审核页面，下拉列表分配变时方法)
	 * @author 杨东
	 * @date 2013-6-1 下午3:01:09
	 * @throws
	 */
	public function _before_auditEdit(){
		$dutyModel=D('Duty');
		$dutylevelid=$dutyModel->where("name='司机'")->find();
		//排除已外派的司机
		$MisRequestCarModel=D('MisRequestCar');
		$MisRequestCarList=$MisRequestCarModel->where("status=1 and driverId <> ''")->getField("id,driverId");
		$map['status']=1;
		$map['dutylevelid']=$dutylevelid['id'];
		if(array_values($MisRequestCarList)){
		$map['id']=array("not in",array_values($MisRequestCarList));
		}
		//查看司机
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');
		$MisHrBasicEmployeeList=$MisHrBasicEmployeeModel->where($map)->getField("id,name");
		$this->assign("MisHrBasicEmployeeList",$MisHrBasicEmployeeList);
		$this->_before_edit();
		$this->getcartype();
	}
	/**
	 * @Title: _before_auditProcess 
	 * @Description: todo(保存司机ID)   
	 * @author renling 
	 * @date 2013-7-8 下午3:38:53 
	 * @throws
	 */
	public function _before_auditProcess(){
		$MisRequestCarModel=D('MisRequestCar');
		$MisRequestCarModel->where(" id=".$_POST['id'])->setField('driverId',$_POST['driverId']);
	}
	/**
	 * @Title: _before_auditView
	 * @Description: todo(审核页面，下拉列表分配变时方法, 已审核成功的显示)   
	 * @author 杨东 
	 * @date 2013-6-1 下午4:17:21 
	 * @throws 
	*/  
	public function _before_auditView(){
		$dutyModel=D('Duty');
		$dutylevelid=$dutyModel->where("name='司机'")->find();
		//查看司机
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');
		$MisHrBasicEmployeeList=$MisHrBasicEmployeeModel->where("status=1 and dutylevelid=".$dutylevelid['id'])->getField("id,name");
		$this->assign("MisHrBasicEmployeeList",$MisHrBasicEmployeeList);
		$this->_before_edit();
	}
	/**
	 * @Title: _before_insert
	 * @Description: todo(插入前置函数)
	 * @author 杨东
	 * @date 2013-5-31 下午4:08:58
	 * @throws
	 */
	public function _before_insert(){
		//验证编码重复
		$this->checkifexistcodeororder('mis_request_car','orderno');
	}
	public function _after_insert($list){
		$set_expand_property_data['id']=$list;
		$this->set_expand_property($set_expand_property_data);
	}
	public function overProcess( $vo ){
		$carID = $_REQUEST['carID'];
		$roid_map['id'] = $carID;
		$modelMSC = M('mis_system_car');
		$data = array('status'=>'0','occupyID'=>$vo);
		$modelMSC-> where($roid_map)->setField($data);
		//dirct  yuansl 2014 7 17 审核之后反写数据到 车辆信息表里面 使用开始时间 使用结束时间   申请之后可能 没有派车
		//判断该申请是否有派车
		$id  = $vo['id'];
		$modelname = $this->getActionName();
		$model = D($molelname);
		$re = $model->where("id = ".$id)->field("carID")->find();
		if($re['carID']){//有派车则执行反写
			$data_x = array('use_statime'=>$vo['departureTime'],'use_endtime'=>$vo['expectRestitutionTime']);
			$modelMSC-> where($roid_map)->setField($data_x);
		}
	}
	/**
	 *
	 * @Title: lookupmanage
	 * @Description: todo(用ztree形式查询出所有部门员工信息。)
	 * @author liminggang
	 * @throws
	 */
	public function lookupmanage(){
		$model= M('mis_system_department');
		$deptlist = $model->where("status=1")->order("id asc")->select();
		$param['rel']="misrequestcarlistBox";
		$param['url']="__URL__/lookupmanage/jump/1/deptid/#id#/parentid/#parentid#";
		$typeTree = $this->getTree($deptlist,$param);
		$this->assign('tree',$typeTree);
		$map = array();
		$keyword=$this->escapeChar($_POST["keyword"]);
		$searchby =$_POST["searchby"];
		$searchtype = $_POST['searchtype'];
		if($_POST["keyword"]){
			$map[$searchby] = ($searchtype==2)  ? array('like','%'.$keyword.'%'):$keyword;
			$this->assign('keyword',$keyword);
			$this->assign('searchby',$searchby);
			$this->assign('searchtype',$searchtype);
		}
		$searchby=array(
				array("id" =>"name","val"=>"按员工姓名"),
				array("id" =>"orderno","val"=>"按员工编号"),
		);
		$searchtype=array(
				array("id" =>"2","val"=>"模糊查找"),
				array("id" =>"1","val"=>"精确查找"));
		
		$this->assign("searchbylist",$searchby);
		$this->assign("searchtypelist",$searchtype);
		
		$map['mis_hr_personnel_person_info.status']=1;
		$map['mis_hr_personnel_person_info.cancel']=0;
		
		$deptid		= $_REQUEST['deptid'];
		$parentid	= $_REQUEST['parentid'];
		if ($deptid && $parentid) {
			$deptlist =array_unique(array_filter (explode(",",$this->findAlldept($deptlist,$deptid))));
			$map['mis_hr_personnel_person_info.deptid'] = array(' in ',$deptlist);
			$this->assign('deptid',$deptid);
			$this->assign('parentid',$parentid);
		}
		$Common=A("Common");
		$Common->_list('MisHrBasicEmployeeView',$map);
		if ($_REQUEST['jump']) {
			$this->display('lookupmanagelist');
		} else {
			$this->display("lookupmanage");
		}
	}
}
?>