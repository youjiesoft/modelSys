<?php
/**
 * @Title: file_name
 * @Package package_name
 * @Description: todo(个人客户信息控制器)
 * @author liminggang
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-7-23 下午3:29:21
 * @version V1.0
 */
class MisSalesCustomerPersonAction extends CommonAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
	}
	private function getSelectList(){
		$selectlist = require DConfig_PATH."/System/selectlist.inc.php";
		$this->assign("county",$selectlist['county']['county']);
	}
	public function _before_add(){
		$this->getSelectList();
		//查询客服类型
		$typeModel=M("mis_sales_customertype");
		$typeList=$typeModel->where("status=1")->select();
		$this->assign("typeList",$typeList);
	}
	public function _before_edit(){
		$this->getSelectList();
		//查询客服类型
		$typeModel=M("mis_sales_customertype");
		$typeList=$typeModel->where("status=1")->select();
		$this->assign("typeList",$typeList);
	}
	public function _after_edit(&$vo){
		$this->assign( 'vosoft', $vo );
		if($_REQUEST['salecustomer']){
			$this->display("MisSalesCustomer:lookupbedit");
			exit;
		}
	}
}
?>