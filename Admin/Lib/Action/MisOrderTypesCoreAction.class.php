<?php
/**
 * @Title:单据类型表
 * @Package 基类
 * @Description: 对不同单据的单据类型进行维护及扩展
 * @author 杨希
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2012年1月16日
 * @version V1.0
 */
class MisOrderTypesCoreAction extends CommonAction {
	/**
	 * @Title: getSalesOrderTypes
	 * @Description: todo(销售部分所有订单类型管理方法)
	 * @author liminggang
	 * @date 2014-2-13 下午2:40:39
	 * @throws
	 */
	public function getSalesOrderTypes($rel,$groupid,$modelname){
		//读取订单类型配置文件
		$model=D('SystemTypeView');
		if(file_exists($model->GetFile())){
			require $model->GetFile();
		}
		if($aryType){
			foreach($aryType as $key=>$val){
				if($val['groupid'] != $groupid){
					//groupid == 2 表示销售部分的订单
					unset($aryType[$key]);
				}else{
					$aryType[$key]['name'] = $val['typename'];
				}
			}
			if($aryType){
				$param['url'] = "__APP__/".$modelname."/index/jump/1/typeid/#type#";
				$param['rel'] = $rel;
				$orderTypesZtree=$this->getTree($aryType,$param);
				$this->assign('orderTypesZtree',$orderTypesZtree);
			}
		}
		$this->getList($groupid);
	}
	/**
	 * @Title: getPurchaseOrderTypes
	 * @Description: todo(采购部分所有订单类型管理方法)
	 * @author liminggang
	 * @date 2014-2-13 下午2:40:51
	 * @throws
	 */
	private function getPurchaseOrderTypes($rel,$groupid){
		//读取订单类型配置文件
		$model=D('SystemTypeView');
		if(file_exists($model->GetFile())){
			require $model->GetFile();
		}
		if($aryType){
			foreach($aryType as $key=>$val){
				if($val['groupid'] != 4){
					//groupid == 4 表示采购部分的订单
					unset($aryType[$key]);
				}else{
					$aryType[$key]['name'] = $val['typename'];
				}
			}
			if($aryType){
				$param['url'] = "__APP__/MisPurchaseBasicType/index/jump/1/typeid/#type#";
				$param['rel'] = $rel;
				$orderTypesZtree=$this->getTree($aryType,$param);
				$this->assign('orderTypesZtree',$orderTypesZtree);
			}
		}
		$this->getList($groupid);
	}
	/**
	 * @Title: getInventoryOrderTypes
	 * @Description: todo(仓储部分所有订单类型管理方法)
	 * @author liminggang
	 * @date 2014-2-13 下午2:41:02
	 * @throws
	 */
	private function getInventoryOrderTypes($rel,$groupid){
		//读取订单类型配置文件
		$model=D('SystemTypeView');
		if(file_exists($model->GetFile())){
			require $model->GetFile();
		}
		if($aryType){
			foreach($aryType as $key=>$val){
				if($val['groupid'] != 5){
					//groupid == 5 表示仓储部分的订单
					unset($aryType[$key]);
				}else{
					$aryType[$key]['name'] = $val['typename'];
				}
			}
			if($aryType){
				$param['url'] = "__APP__/MisInventoryBasicType/index/jump/1/typeid/#type#";
				$param['rel'] = $rel;
				$orderTypesZtree=$this->getTree($aryType,$param);
				$this->assign('orderTypesZtree',$orderTypesZtree);
			}
		}
		$this->getList($groupid);
	}

	private function getList($groupid){
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		//查询组
		$map['groupid'] = $groupid;

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
		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		//首页收件箱调用方法，为ajax调用
		if ($_GET['type'] == "ajaxcall") {
			$this->display ("ajax_index");exit;
		}
		if($_REQUEST['jump']){
			$this->display('indexview');exit;
		}
		$this->display ();
		return;
	}

	public function getAdd($groupid){
		//订单号可写
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable('mis_order_types');
		$this->assign("writable",$writable);
		//自动生成订单编号
		$code = $scnmodel->GetRulesNO('mis_order_types');
		$this->assign("code", $code);
		//读取订单类型配置文件
		$model=D('SystemTypeView');
		if(file_exists($model->GetFile())){
			require $model->GetFile();
		}
		foreach($aryType as $key=>$val){
			if($val['groupid'] != $groupid){
				unset($aryType[$key]);
			}
		}
		$this->assign("list",$aryType);
	}
	/**
	 * @Title: _before_insert
	 * @Description: todo(插入方法insert前执行操作)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function _before_insert() {
		//if($_POST['utype']) $_SESSION['utype'] = $_POST['utype'];
		$this->checkifexistcodeororder('mis_order_types','code');
	}
	/**
	 * @Title: getEdit
	 * @Description: todo(edit页面前传入数据)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function getEdit($groupid){
		//获取到对应需要修改的单据ID
		$id=$_GET['id'];
		//实例化表对象
		$OrderTypes	=D("mis_order_types");
		//对数据采集
		$OrderTypesList=$OrderTypes->where("id='".$id."'")->find();
		//分派给模板
		$this->assign('OrderTypesList',$OrderTypesList);
		//读取订单类型配置文件
		$model=D('SystemTypeView');
		if(file_exists($model->GetFile())){
			require $model->GetFile();
		}
		foreach($aryType as $key=>$val){
			if($val['groupid'] != $groupid){
				unset($aryType[$key]);
			}
		}
		$this->assign("typelist",$aryType);
		//编号可写
		$model1	=D('SystemConfigNumber');
		$writable= $model1->GetWritable('mis_order_types');
		$this->assign("writable",$writable);
	}
	/**
	 * @Title: _before_update
	 * @Description: todo(更新方法update前执行操作)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function _before_update() {
		if($_POST['utype']) $_SESSION['utype'] = $_POST['utype'];
		$this->checkifexistcodeororder('mis_order_types','code',1);
	}
}
?>