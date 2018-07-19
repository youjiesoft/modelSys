<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(会议室使用申请管理模块) 
 * @author yuansl 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-6-12 下午3:23:55 
 * @version V1.0
 */
class MisMeetingRoomUseMangeAction extends CommonAuditAction{
	public function _filter(&$map){
		//管理员权限判断
		if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
	}
	/**
	 * @Title: _before_add 
	 * @Description: todo(会议室申请前置操作)   
	 * @author yuansl 
	 * @date 2014-6-13 上午11:46:32 
	 * @throws
	 */
	public function _before_add(){
		$this->assign("time",time());
		//查询会议室物品
		$MisMeetingRoomUrgedModel=D('MisMeetingRoomUrged');
		$MisMeetingRoomUrgedList=$MisMeetingRoomUrgedModel->where("status=1")->getField("id,name");
		$this->assign("MisMeetingRoomUrgedList",$MisMeetingRoomUrgedList);
		//订单是否可写
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable('mis_meeting_user_mange');
		$this->assign("writable",$writable);
		//自动生成编号
		$code = $scnmodel->GetRulesNO('mis_meeting_user_mange');
		$this->assign("orderno", $code);
		$this->notiec();
	}
	/**
	 * @Title: notiec 
	 * @Description: todo(给用户提示会议时是否被占用的情况)   
	 * @author yuansl 
	 * @date 2014-7-8 下午2:18:43 
	 * @throws
	 */
	private function notiec(){
		//取出当前会议室的在此日期空闲时间段
		if($_REQUEST['date'] && $_REQUEST['roomid']){
			//$date = substr($_REQUEST['date'],0,10);
			$roomid = $_REQUEST['roomid'];
			$modelname = $this->getActionName();
			$model = D($modelname);
			$strtime = $_REQUEST['date'];
			$date = transTime($strtime);
			$map['status'] = array('eq',1);
			$map['objid'] = array('eq',$roomid );
			$map['estimatedStrtime'] = array(array('egt',$strtime),array('elt',$strtime+3600*24), 'and');
			$uesinfoList = $model->where($map)->field("estimatedStrtime,estimatedEndtime")->select();
			$newuesinfoList = array();
			$strx = '';
			if(count($uesinfoList) < 1){
				$str = "该会议室,在&nbsp;&nbsp;".$date."&nbsp;&nbsp;没有会议被召开,您可以自己合理安排会议时间!";
			}else{
				foreach($uesinfoList as $sortval){
					$sortval['estimatedStrtime'] =  date("Y-m-d h:i:s", $sortval['estimatedStrtime']);
					$sortval['estimatedEndtime'] =  date("Y-m-d h:i:s", $sortval['estimatedEndtime']);
					array_push($newuesinfoList,$sortval);
				}
			}
			if(count($newuesinfoList) < 1){
				$this->assign("notice",$str);
			}else{
				$strx = "该会议室,在&nbsp;".$date."&nbsp;有".count($newuesinfoList)."场会议,时间段为   ";
				foreach($newuesinfoList as $t){
					$strx = $strx.$t["estimatedStrtime"]."~".$t["estimatedEndtime"]." . ";
				}
				$strx = $strx."请注意时间不要冲突!";
				$this->assign("notice",$strx);
			}
		}
	}
	public function _before_edit(){
	 	$meetingrelated=unserialize(getFieldBy($_REQUEST['id'], "id", "meetingrequest", "mis_meeting_user_mange")); 
		$this->assign("meetingrelated",$meetingrelated);
	}
	public function _before_auditView(){
		$this->_before_edit();
	}
	/**
	 * @Title: getgoodsdefa 
	 * @Description: todo(获取默认的会议室物品信息) 
	 * @return unknown  
	 * @author yuansl 
	 * @date 2014-6-17 下午5:37:38 
	 * @throws
	 */ 
	private function getgoodsdefa(){
		$id = $_REQUEST['id']; 
		$modelname = $this->getActionName();
		$model = D($modelname);
		$meet_requestlist = $model->where("id = ".$id)->field("meetingrequest")->find();
		
		$requestlist = unserialize($meet_requestlist['meetingrequest']);
		return $requestlist;
	}
	public function _before_auditEdit(){
			$this->_before_edit();	
	}
	/**
	 * @Title: _before_insert 
	 * @Description: todo(新增之前组织数据)   
	 * @author yuansl 
	 * @date 2014-6-13 下午4:52:39 
	 * @throws
	 */
	public  function _before_insert(){
		 //数据过滤处理
		 $_POST = $this->datafilter($_POST);
		 $meetingrequest = array();
		 $useid=$_POST['useid'];	
		 foreach($useid as $key=>$val){
		 	$meetingrequest[]=array(
		 			'useid'=>$val,
		 			'count'=>$_POST['useqty'][$key],
		 			'useremark'=>$_POST['useremark'][$key],
		 			);
		 	}
		 //序列化数组
		 $_POST['meetingrequest'] = serialize($meetingrequest);
	}
	public function _after_insert(){
		$this->turnarounddata();
	}
	public function _after_update(){
		$this->turnarounddata();
	}
	/**
	 * @Title: turnarounddata 
	 * @Description: todo(反写数据表:被占用的会议室)   
	 * @author yuansl 
	 * @date 2014-6-16 下午4:58:37 
	 * @throws
	 */
	private function turnarounddata(){
		$MisMeetingRoomModel = D("MisMeetingRoom");
		$modelname = $this->getActionName();
		$model = D($modelname);
		$arr = $model->where("status > 0")->getField('objid',true);
		$map['id'] = array(in,$arr);
		$MisMeetingRoomModel->where($map)->setField("leisure",0);
	}
	public function _before_update(){
		$_POST = $this->datafilter($_POST);
		$meetingrequest = array();
		$useid=$_POST['useid'];
		foreach($useid as $key=>$val){
			$meetingrequest[]=array(
					'useid'=>$val,
					'count'=>$_POST['useqty'][$key],
					'useremark'=>$_POST['useremark'][$key],
			);
		}
		//序列化数组
		$_POST['meetingrequest'] = serialize($meetingrequest);
	}
	/**
	 * @Title: datafilter 
	 * @Description: todo(插入或者保存数据时候的过滤处理) 
	 * @param unknown_type $data  
	 * @author yuansl 
	 * @date 2014-6-17 下午1:37:32 
	 * @throws
	 */
	private function datafilter($data){
		if($data['scope'] == 1){
			$data['customertype'] = '';
			$data['amount'] ='';
			$data['prepaid'] = '';
			$data['unpaid']='';
			$data['isfree'] = 1;
		} 
		if($data['scope'] == 2){
			$data['prepaid'] = '';
			$data['unpaid']='';
			$data['isfree'] = 1;
		}
		return $data;
	}
	/**
	 * @Title: overProcess 
	 * @Description: todo(申请通过生成会议使用记录)   
	 * @author yuansl 
	 * @date 2014-6-17 下午3:29:56 
	 * @throws
	 */
	public function overProcess(){
		$model = D("MisMeetingUseRecord");
		//数据字段转换处理
		$_POST['meetingtime'] = strtotime($_POST['meetingtime']);
		$_POST['estimatedStrtime'] = strtotime($_POST['estimatedStrtime']);
		$_POST['estimatedEndtime'] = strtotime($_POST['estimatedEndtime']);//
		$_POST['objmodelname'] = 'MisMeetingRoom';
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		$list=$model->add ();//保存当前数据对象
		if( !$list ){
			$this->error ( L('_ERROR_') );
		}
	}
	
	public function lookupGeneral(){
		//获取查找带回的字段
		$this->assign("field",$_REQUEST['field']);
		$_POST['dealLookupList'] = 1;//强制查找带回重构数据列表
		$name = $_POST['model'];
		//获取部门类型 ————快捷新增客户
		$deptid=$_REQUEST['deptid'];
		$this->assign("deptid",$deptid);
		if(strpos($name, '_')){//将表转换为model
			$nameArr = explode('_', $name);
			$names = "";
			foreach ($nameArr as $k => $v) {
				$names .= ucfirst($v);
			}
			if($names){
				$name = $names;
			}
		}
		if(substr($name, -4)=="View"){
			$qx_name = $name;
			$name = substr($name,0, -4);
		}
		$this->assign("model",$name);
		// 单据号是否可写
		$table = D($name)->getTableName();
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable($table);
		$this->assign("writable",$writable);
	
		$ConfigListModel = D('SystemConfigList');
		$lookupGeneralList = $ConfigListModel->GetValue('lookupGeneralInclude');// 快速新增配置列表
		$include = $lookupGeneralList[$name];//获取配置信息
		$layoutH = 96;//默认高度
		if($include){
			$layoutH = $include['layoutH'];//获取高度
			$this->assign("tplName",'LookupGeneral:'.$include['tpl']);//设置默认模版
			$this->assign("isauto",$include['isauto']);//设置编号自动生成
		}
		$this->assign("layoutH",$layoutH);//设置高度
		$scdmodel = D('SystemConfigDetail');
		$detailList = $scdmodel->getDetail($name);
		//最后异性的“操作”
		if($_SESSION['a'] == 1){
			array_pop($detailList);
		}
// 		dump($detailList);
		if ($detailList) {
			$inArray = array('action','remark','status');
			if ($_REQUEST['filterfield']) {
				$filterfield = explode(',', $_REQUEST['filterfield']);
				$inArray = array_merge($inArray,$filterfield);
			}
			foreach ($detailList as $k => $v) {
				if(in_array($v['name'], $inArray)){
					unset($detailList[$k]);
				}
			}
			$this->assign ( 'detailList', $detailList );
		}
// 		$action=A("Common");
// 		$action = $this;
		$action = A($name);
		$map = $this->_search($name);
		$conditions = $_POST['conditions'];// 检索条件
		if($conditions){
			$this->assign("conditions",$conditions);
			$cArr = explode(';', $conditions);//分号分隔多个参数
			foreach ($cArr as $k => $v) {
				$wArr = explode(',', $v);//逗号分隔字段、参数、修饰符
				if ($wArr[0] == "_string") { // 判断是否传的为字符串条件
					$map['_string'] = $wArr[1];
				} else {
					if ($wArr[2]) {//存在修饰符的以修饰符形式进行检索
						$map[$wArr[0]] = array($wArr[2],$wArr[1]);
					} else {//普通检索
						$map[$wArr[0]] = $wArr[1];
					}
				}
			}
		}
		$map['status'] = 1;
		$filterfield = "_lookupGeneralfilter";
		if($_REQUEST['filtermethod']) $filterfield = $_REQUEST['filtermethod'];
		if (method_exists($this,$filterfield)) {
			call_user_func(array(&$this,$filterfield),&$map);
		}
// 		dump($this);
// 		dump($name);
		$action->_list ( $name, $map );
		$this->display();
	}

}