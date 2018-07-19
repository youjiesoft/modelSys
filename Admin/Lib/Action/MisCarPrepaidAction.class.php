<?php
/**
 * @Title: 车辆违章管理 
 * @Package MisCarPrepaidAction 
 * @Description: todo( 车辆管理 ) 
 * @author eagle 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-4-18 下午5:47:22 
 * @version V1.0
 */
class MisCarPrepaidAction extends CommonAction {
	public function _filter(&$map){
		//管理员权限判断
		if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
		//充值记录
		$map['business_type'] = 0;
	}
	public function index() {
		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name = $this->getActionName();
		if (! empty ( $name )) {
			$qx_name=$name;
			if(substr($name, -4)=="View"){
				$qx_name = substr($name,0, -4);
			}
			//验证浏览及权限
			if( !isset($_SESSION['a']) ){
				$map=D('User')->getAccessfilter($qx_name,$map);
			}
			$this->_list ( $name, $map );
		}
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
		$this->display ();
	}
	 /**
	 * @Title: _before_add
	 * @Description: todo( info )   
	 * @author	eagle 
	 * @date 
	 * @throws 
	*/ 
	public function _before_add(){
		 $this->assign("now",time());
		 $this->assign("uid",$_SESSION [C ( 'USER_AUTH_KEY' )]);
	}	
	/**
	 * @Title: _after_insert
	 * @Description: todo(插入成功后，修改油卡信息)
	 * @param unknown_type $id
	 * @author liminggang
	 * @date 2013-10-18 下午3:15:20
	 * @throws
	 */
	public function _before_insert(){
		//油卡模型
		$MisCarCardBind = D("MisCarCardBind");
		//获得油卡ID
		$oil_id = $_POST['oil_id'];
		$amount=str_replace(",", "", $_POST['amount']);
		//增加油卡余额
		$map['oil_balance'] = array('exp',"oil_balance+".$amount);
		$result=$MisCarCardBind->where('oil_id = '."'".$oil_id."'")->save($map);
		if(!$result){
			$this->error("油卡充值失败");
		}
	}
	public function _before_update(){
		//获得油卡ID
		$oil_id = $_POST['oil_id'];
		//油卡模型
		$MisCarCardBind = D("MisCarCardBind");
		//获得加油金额
		$amount=str_replace(",", "", $_POST['amount']);
		//获取旧的金额
		$oldamount=$_POST['oldamount'];
		//金额差
		$newamount=$amount - $oldamount;
		//增加油卡余额
		$data['oil_balance'] = array('exp',"oil_balance+".$newamount);
		$result=$MisCarCardBind->where('oil_id = '."'".$oil_id."'")->save($data);
		dump($oil_id);
		exit;
		if(!$result){
			$this->error("油卡充值失败");
		}
	}
	
}
?>