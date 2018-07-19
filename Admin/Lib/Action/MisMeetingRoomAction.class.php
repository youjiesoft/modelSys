<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(会议室管理) 
 * @author yuansl 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-6-12 上午9:59:11 
 * @version V1.0
 */
class MisMeetingRoomAction extends CommonAction{
	public function _filter(&$map){
		if ($_SESSION["a"] != 1){
			$map['status']=array("gt",0);
		}
	}
	/**
	 * (non-PHPdoc)
	 * @see CommonAction::index()
	 */
	public function index(){
			$name = $this->getActionName();
			//列表过滤器，生成查询Map对象
			$map = $this->_search ($name);
			if (method_exists ( $this, '_filter' )) {
				$this->_filter ( $map );
			}
			//验证浏览及权限
			if( !isset($_SESSION['a']) ){
				$map=D('User')->getAccessfilter($qx_name,$map);
			}
			$this->_list ( $name, $map );
			$scdmodel = D('SystemConfigDetail');
			$detailList = $scdmodel->getDetail($name);
			if ($detailList) {
				$this->assign ( 'detailList', $detailList );
			}
			//扩展工具栏操作
			$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
			if ($toolbarextension) {
				$this->assign ( 'toolbarextension', $toolbarextension );
			}
			/* if($_REQUEST['jump']){
				$this->display('indexview');
				exit;
			} */
			$this->display('index');
		}
		public function _before_add(){
			//订单是否可写
			$scnmodel = D('SystemConfigNumber');
			$writable= $scnmodel->GetWritable('mis_meeting_room');
			$this->assign("writable",$writable);
			//自动生成编号
			$code = $scnmodel->GetRulesNO('mis_meeting_room');
			$this->assign("code", $code);
		}
		/**
		 * @Title: _after_list
		 * @Description: todo(本方法在此模块意义不大，主要用于在会议申请时候在(使用中的)会议室列表标红处理)
		 * @param unknown_type $volist
		 * @author yuansl
		 * @date 2014-7-19 上午11:06:55
		 * @throws
		 */
		public function _after_list(&$volist){
			//获取到车辆id 查询  如果这辆车在当前时间已经再使用则新组合一个字段进入$volist isBusy
			$newvolist = array();
			foreach($volist as $val){
				$temp = $this->is_busy($val['id']);
				$val['isBusy'] = $temp['isBusy'];
				$val['orderid'] = $temp['orderid'];
				array_push($newvolist,$val);
				//dump($val['isBusy']);
			}
			$this->assign('list1',$newvolist);
// 			dump($newvolist);
		}
		private function is_busy($RoomID){
			if(!$RoomID){
				return false;
			}
			$time = time();
			$MisMeetingRoomModel = D("MisMeetingRoom");
			$MisMeetingRoomUseMangeModel = D("MisMeetingRoomUseMange");
			$mapx['estimatedStrtime'] = array('elt',$time);//开始时间小于当前时间
			$mapx['estimatedEndtime'] = array('egt',$time);//结束时间大于当前时间
			$mapx['status'] = array('gt',0);//
			$mapx['auditState'] = array('eq',3);//审核通过的
			$mapx['objid'] = array('eq',$RoomID);
			$rex = $MisMeetingRoomUseMangeModel->where($mapx)->field("id,objid")->find();
			// 		dump($rex);
			if($rex){
				return array('isBusy'=>1,"orderid"=>$rex['id']);
			}else{
				return array('isBusy'=>0);
			}
		}
}