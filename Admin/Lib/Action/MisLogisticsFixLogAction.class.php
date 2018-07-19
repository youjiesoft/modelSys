<?php
/**
 * @Title: 行政管理
 * @Package package_name 
 * @Description: todo( 后勤维护记录 ) 
 * @author eagle 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-4-18 下午5:47:22 
 * @version V1.0
 */
class MisLogisticsFixLogAction extends CommonAuditAction {
	/* (non-PHPdoc) 过滤条件
	 * @see CommonAction::index()								
	*/
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
	}
	public function _before_add(){
		//获取人员
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		$this->assign("userid",$userid);
		$usermodel=D("User");
		$dept_id=$usermodel->where("id=".$userid)->getField("dept_id");
		$this->assign("dept_id",$dept_id);
		//单号
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable('mis_logistics_fix_log');
		$this->assign("writable",$writable);
		$orderno = $scnmodel->GetRulesNumber('mis_logistics_fix_log');
		$this->assign("orderno", $orderno);
		$this->assign("time",time());
	} 
	/**
	 * @Title: attlist 
	 * @Description: todo(上传附件列表)   
	 * @author eagle 
	 * @date 2013-5-31 下午5:33:06 
	 * @throws
	 */
	public function attlist(){
		//获取附件信息
		$modelMAR = D('MisAttachedRecord');
		$map = array();
		$map["status"]  =1;
		$map["orderid"] =$_REQUEST["id"];
		$map["type"] =73;
		$attarry=$modelMAR->where($map)->select();
		$filesArr = array('pdf','doc','docx','xls','xlsx','ppt','pptx','txt','jpg','jpeg','gif','png');
		foreach ($attarry as $key => $val) {
			$pathinfo = pathinfo($val['attached']);
			if (in_array(strtolower($pathinfo['extension']), $filesArr)) {
				$attarry[$key]['isplay'] = true;
				$attarry[$key]['name'] = base64_encode($val['attached']);
				$attarry[$key]['filename'] = $val['upname'];
			}
		}
		$this->assign('attarry',$attarry);
	}
	
	/**
	 * @Title: _before_edit 
	 * @Description: todo(打开修改页面前置函数)   
	 * @author eagle 
	 * @date 2013-5-31 下午5:33:33 
	 * @throws
	 */
	public function _before_edit(){
		//当前申请单的明细
		$model = D("MisLogisticsFixLogSub");
		$map['masid'] = $_REQUEST['id'];
		$map['status'] = 1;
		$sublist = $model->where($map)->select();
		foreach ($sublist as $key=>$val){  //计算可用数量
			$sublist[$key]['sumreturnqty']=getFieldBy($val['objid'], 'id', 'returnqty', 'mis_work_facility_distribute')+$val['qty'];
		}
		$this->assign("sublist",$sublist);
		//获取人员
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		$this->assign("userid",$userid);
		$usermodel=D("User");
		$dept_id=$usermodel->where("id=".$userid)->getField("dept_id");
		$this->assign("dept_id",$dept_id);
		//上传附件的展示清单
		$this->attlist();
		//获取执行进度
		$this->getdotype();
	}
	
	/**
	 * @Title: _after_insert 
	 * @Description: todo(插入后置函数) 
	 * @param unknown_type $id  
	 * @author eagle 
	 * @date 2013-5-31 下午5:40:13 
	 * @throws
	 */
	public function _after_insert($id){
		//插入附件
		if ($id) {
		//添加sub表
			$MisLogisticsFixLogSubModel=D('MisLogisticsFixLogSub');
			//保存附件
			$this->swf_upload($id,73);
			//修改设备可异动数量
			$subid=$_POST['appsubid'];
			$MisWorkFacilityDistributeModel=D("MisWorkFacilityDistribute");
			foreach ($subid as $key=>$val){
				$date=array();
				$date['masid']=$id;
				$date['appsubid']=$val;
				$date['manageid']=$_POST['manageid'][$key];
				$date['managename']=getFieldBy($_POST['manageid'][$key], "id", "equipmentname", "mis_work_facility_manage");
				$date['equipmenttype']=getFieldBy($_POST['manageid'][$key], "id", "equipmenttype", "mis_work_facility_manage");
				$date['qty']=str_replace(",","",$_POST['appqty'][$key]);
				$date['createid']=$_SESSION[C('USER_AUTH_KEY')];
				$date['createtime']=time();
				$result=$MisLogisticsFixLogSubModel->add($date);
				$MisLogisticsFixLogSubModel->commit();
				if($result){
					$managedate=array();
					$managedate['id']=$val;
					//修可用数量
					$managedate['returnqty']=array("exp","returnqty-".str_replace(",","",$_POST['appqty'][$key]));
					$MisWorkFacilityDistributeModel->save($managedate);
					$MisWorkFacilityDistributeModel->commit();
				}
			}
		}
	}
	/**
	 * @Title: _after_update 
	 * @Description: todo(修改后置函数)   
	 * @author eagle 
	 * @date 2013-5-31 下午5:41:20 
	 * @throws
	 */
	/**
	 * @Title: _after_update
	 * @Description: todo(修改的后置函数)
	 * @param unknown_type $list
	 * @author xiafengqin
	 * @date 2013-9-22 下午4:41:45
	 * @throws
	 */
	public function _after_update($id) {
		if($id && !$_POST['beforeInsert']){
			$id=$_POST['id'];
			//保存附件
			$this->swf_upload($_POST['id'],73);
			//修改设备可异动数量
			$appsubid=$_POST['appsubid'];
			$MisLogisticsFixLogSubModel=D('MisLogisticsFixLogSub');
			$MisWorkFacilityDistributeModel=D('MisWorkFacilityDistribute');
			foreach ($appsubid as $key=>$val){
				//修改sub表数据
				$date=array();
				$date['masid']=$id;
				$date['objid']=$val;
				$date['appsubid']=$_POST['appsubid'][$key];
				$date['objmodel']="MisWorkFacilityDistribute";
				$date['manageid']=getFieldBy($val, "id", "manageid", "mis_work_facility_distribute");
				$date['managename']=getFieldBy($val, "id", "managename", "mis_work_facility_distribute");
				$date['equipmenttype']=getFieldBy($val, "id", "equipmenttype", "mis_work_facility_distribute");
				$date['qty']=str_replace(",","",$_POST['appqty'][$key]);
				if($_POST['subid'][$key]){
					$date['updateid']=$_SESSION[C('USER_AUTH_KEY')];
					$date['updatetime']=time();
					$date['id']=$_POST['subid'][$key];
					$result=$MisLogisticsFixLogSubModel->save($date);
				}else{
					$date['createid']=$_SESSION[C('USER_AUTH_KEY')];
					$date['createtime']=time();
					$result=$MisLogisticsFixLogSubModel->add($date);
				}
				$MisLogisticsFixLogSubModel->commit();
				if($result){
					//修可用数量
					if($_POST['oldqty'][$key]){
						$managedate['returnqty']=array("exp","returnqty+".$_POST['oldqty'][$key]."-".str_replace(",","",$_POST['appqty'][$key]));
					}else{
						$managedate['returnqty']=array("exp","returnqty-".str_replace(",","",$_POST['appqty'][$key]));
					}
					$managedate['id']=$val;
					$MisWorkFacilityDistributeModel->save($managedate);
					$MisWorkFacilityDistributeModel->commit();
				}
			}
		}
	}
	public function _before_auditEdit(){
		$this->_before_edit();
		$this->attlist();
	}
	public function _before_auditView(){
		$this->_before_edit();
		//查询处理状态
		$this->getdotype();
		$this->attlist();
	}
	//查找人员
	public function lookupmanage(){
		$model= M('mis_system_department');
		$deptlist = $model->where("status=1")->order("id asc")->select();
		$param['rel']="positiveBox";
		$param['url']="__URL__/lookupmanage/jump/1/deptid/#id#/parentid/#parentid#";
		$typeTree = $this->getTree($deptlist,$param);
		$this->assign('tree',$typeTree);
		$map = array();
		$searchby = str_replace("-", ".", $_POST["searchby"]);
		$keyword=$this->escapeChar($_POST["keyword"]);
		$searchtype = $_POST['searchtype'];
		if($_POST["keyword"]){
			$map[$searchby] = ($searchtype==2)  ? array('like','%'.$keyword.'%'):$keyword;
			$this->assign('keyword',$keyword);
			$searchby = str_replace(".", "-", $_POST["searchby"]);
			$this->assign('searchby',$searchby);
			$this->assign('searchtype',$searchtype);
		}
		$searchby=array(
				array("id" =>"mis_hr_personnel_person_info-name","val"=>"按员工姓名"),
				array("id" =>"orderno","val"=>"按员工编号"),

		);
		$searchtype=array(array("id" =>"2","val"=>"模糊查找"),
				array("id" =>"1","val"=>"精确查找"));
		$this->assign("searchbylist",$searchby);
		$this->assign("searchtypelist",$searchtype);
		$map['working'] = 1; //在职
		// 		$map['positivestatus']=1; //转正
		$deptid		= $_REQUEST['deptid'];
		$parentid	= $_REQUEST['parentid'];
		if ($deptid && $parentid) {
			$deptlist =array_unique(array_filter (explode(",",$this->downAllChildren($deptlist,$deptid))));
			$map['mis_hr_personnel_person_info.deptid'] = array(' in ',$deptlist);
		}
		$commodel=A("Common");
		$commodel->_list('MisHrPersonnelAppraisalInfoView',$map);
		$this->assign('deptid',$deptid);
		$this->assign('parentid',$parentid);
		
		$multi = intval($_REQUEST['multi']) ? 1:0;
		$this->assign('multi',$multi);
		
		if ($_REQUEST['jump']) {
			$this->display('lookupmanagelist');
		} else {
			$this->display("lookupmanage");
		}
	}
	public function lookupmislogisticsfixlog(){
		//实例化办公设备类型表
		$dptmodel = D("MisWorkFacilityType");
		//查name和id
		$deptlist = $dptmodel->where("status=1")->order("id asc")->field('id,name,pid as parentid')->select();
		$treemiso[]=array(
				'id'=>0,
				'pId'=>-1,
				'name'=>'设备类型',
				'rel'=>'lookupmislogisticsfixlogli',
				'target'=>'ajax',
				'url'=>'__URL__/lookupmislogisticsfixlog/jump/1',
				'open'=>true
		);
		$param['rel']="lookupmislogisticsfixlogli";
		$param['url']="__URL__/lookupmislogisticsfixlog/jump/1/equipmenttype/#id#";
		$typeTree = $this->getTree($deptlist,$param,$treemiso);
		$this->assign('tree',$typeTree);
		$map=$this->_search("MisWorkFacilityDistribute");
		$deptid=$this->escapeChar($_REQUEST['equipmenttype']);
		$map['returnqty']=array("neq",0);
		if($deptid){
			//加入递归
			$deptlist =array_unique(array_filter (explode(",",$this->findAlldept($deptlist,$deptid))));
			//查询此类型的设备di
			$map['equipmenttype']=array("in",$deptlist);
			$this->assign("equipmenttype",$deptid);
		}
		//查询部门为当前部门
		$map['applydepartmentid']=getFieldBy(($_SESSION[C('USER_AUTH_KEY')]), "id", "dept_id", "user");
		$Common=A('Common');//
		$Common->_list('MisWorkFacilityDistribute', $map);
		if($_REQUEST['jump']){
			$this->display('lookupmislogisticsfixloglist');
		}else{
			$this->display();
		}
	}
	public function lookupsubdelete(){
		$id = $_POST['id'];// 明细ID
		$MisLogisticsFixLogSubModel=D('MisLogisticsFixLogSub');
		$map['id'] = $id;
		$res = $MisLogisticsFixLogSubModel->where($map)->setField ( 'status', - 1 );
		$MisLogisticsFixLogSubModel->commit();
		//还原可异动数量
		if($res){
			$MisWorkFacilityDistributeModel=D('MisWorkFacilityDistribute');
			$ManageDate=array();
			$ManageDate['id']=getFieldBy($id, 'id', 'appsubid', 'mis_logistics_fix_log_sub');
			$ManageDate['returnqty']=array("exp","returnqty+".getFieldBy($id, 'id', 'qty', 'mis_logistics_fix_log_sub'));
			$MisWorkFacilityDistributeModel->save($ManageDate);
		}
		echo $res;
	}
	public function delete(){
		$id=$_REQUEST['id'];
		$oldstatus=getFieldBy($id, "id", "status", "MisWorkFacilityAbnormalmove");
		$model = D("MisWorkFacilityAbnormalmove");
		$submodel = D("MisWorkFacilityAbnormalmovesub");
		$map['id'] = $id;
		$res = $model->where($map)->setField ( 'status', - 1 );
		if($res && $oldstatus!=-1){
			$MisWorkFacilityApplySubModel=D('MisWorkFacilityApplySub');
			//查找该mas下的sub
			$subMap['masid']=$id;
			$subMap['status']=1;
			$subList=$submodel->where($subMap)->select();
			foreach ($subList as $key=>$val){
				$submodel->where("id=".$val['id']." and status=1")->setField ( 'status', - 1 );
				$ManageDate=array();
				$ManageDate['id']=$val['appsubid'];
				$ManageDate['kymove']=array("exp","kymove+".$val['qty']);
				$MisWorkFacilityApplySubModel->save($ManageDate);
			}
		}
		if ($res!==false) {
			$this->success ( L('_SUCCESS_') );
		} else {
			$this->error ( L('_ERROR_') );
		}
	
	}
}
?>