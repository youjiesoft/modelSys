<?php
/**
 * @Title: file_name
 * @Package package_name
 * @Description: todo(客户服务跟踪信息)
 * @author liminggang
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-7-24 下午5:10:50
 * @version V1.0
 */
class MisSalesCustomerTrackAction extends CommonAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
	}
	public function _before_add(){
		$this->assign('category',$_GET['category']);
		$customerid = $_REQUEST['customerid'];
		if($customerid){
			$MisSalesCustomerTrackDao = M("mis_sales_customer_track");
			$map['category'] = $_GET['category'];
			$map['customerid'] = $customerid;
			$map['status'] = 1;
			$list=$MisSalesCustomerTrackDao->where($map)->order("id desc")->find();
			$this->assign('vo',$list);
		}
	}
	
	public function _after_insert($id){
		if($id && $_POST['customerid']){
			//修改客户信息
			if($_POST['category'] == 1){
				$MisSalesCustomerDao = M("MisSalesCustomer");
			}else{
				$MisSalesCustomerDao = M("MisSalesCustomerPerson");
			}
			$data['lendamount'] = str_replace(",","",$_POST['lendamount']);
			$data['needmoney'] = str_replace(",","",$_POST['needmoney']);
			$data['deptname'] = $_POST['deptname'];
			$data['username'] = $_POST['username'];
			$data['servercompany'] = $_POST['servercompany'];
			$data['serverinfo'] = strtotime($_POST['serverinfo']);
			$data['id'] = $_POST['customerid'];
			$result=$MisSalesCustomerDao->save($data);
			if(!$result){
				$this->error("修改客户信息失败，请联系管理员");
			}
		}
	}
	public function _before_update(){
		if($_POST['customerid']){
			//修改客户信息
			if($_POST['category'] == 1){
				$MisSalesCustomerDao = M("MisSalesCustomer");
			}else{
				$MisSalesCustomerDao = M("MisSalesCustomerPerson");
			}
			$data['lendamount'] = str_replace(",","",$_POST['lendamount']);
			$data['needmoney'] = str_replace(",","",$_POST['needmoney']);
			$data['deptname'] = $_POST['deptname'];
			$data['username'] = $_POST['username'];
			$data['servercompany'] = $_POST['servercompany'];
			$data['serverinfo'] = strtotime($_POST['serverinfo']);
			$data['id'] = $_POST['customerid'];
			$result=$MisSalesCustomerDao->save($data);
			if(!$result){
				$this->error("修改客户信息失败，请联系管理员");
			}
		}
	}
}
?>