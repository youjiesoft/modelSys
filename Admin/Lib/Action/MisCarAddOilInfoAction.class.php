<?php
/**
 * @Title: MisCarAddOilInfoAction
 * @Package package_name
 * @Description: todo(加油记录)
 * @author 杨东
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-6-1 下午4:28:57
 * @version V1.0
 */
class MisCarAddOilInfoAction extends CommonAction {
	/**
	 * @Title: _filter
	 * @Description: todo(构造检索条件)
	 * @param HASHMAP $map
	 * @author 杨东
	 * @date 2013-5-31 下午4:01:22
	 * @throws
	 */
	public function _filter(&$map){
		//管理员权限判断
		if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);

		/* $oilID  = $_REQUEST['oilID'];if(isset($oilID)){$map['oil_id'] = $oilID;} */
		//得到指定车辆的id
		$carid  = $_REQUEST['carid'];
		//加油记录
		$map['business_type'] = 1;
		if(!empty($carid)){
			$map['car_id'] = $carid;
		}
	}
	/**
	 * @Title: common
	 * @Description: todo(公共函数)
	 * @author 杨东
	 * @date 2013-6-1 下午4:33:56
	 * @throws
	 */
	private function common(){

		//得到当前车辆没了卡ID
		$oilID = $_REQUEST['oilID'];
		$this->assign('oilID',$oilID);
			
		//得到要找的车输信息， 通过ID
		$carid= $_REQUEST['carid'];
		$this->assign('carid',$carid);
	}

	/**
	 * @Title: _after_index
	 * @Package package_name
	 * @Description: todo( 后置 ： 把车辆id传到_before_add中去，以例自动完成一些初始化工作 )
	 * @author eagle
	 * @company 重庆特米洛科技有限公司
	 * @copyright 本文件归属于重庆特米洛科技有限公司
	 * @date 2013-4-18 下午5:47:22
	 * @version V1.0
	 */
	public function _before_index(){
		//局部刷新处理，传参过来
		$this->common();
	}

	/**
	 * @Title: _before_add
	 * @Description: todo( info )
	 * @author	eagle
	 * @date
	 * @throws
	 */
	public function _before_add(){
		//局部刷新处理，传参过来
		$this->common();
	}
	/**
	 * @Title: _before_insert
	 * @Description: todo(添加加油记录信息，提前判断是否正确)
	 * @author liminggang
	 * @date 2013-10-18 下午2:55:40
	 * @throws
	 */
	public function _before_insert(){
		//判断是加油，还是圈钱
		$business_type = $_POST['business_type'];
		//获得付款类型
		$pay_type = $_POST['pay_type'];
		//获得油卡
		$oil_id = $_POST['oil_id'];
		//加油 ,判断余额是否足够
		if($pay_type>0){
			$oil_balance=str_replace(",", "", $_POST['oil_balance']);
			$amount=str_replace(",", "", $_POST['amount']);
			//如何油卡余额小于加油总额。则提示
			if($amount>$oil_balance){
				$this->error("油卡余额不足");
			}
		}
	}
	/**
	 * @Title: _after_insert
	 * @Description: todo(插入成功后，修改油卡信息)
	 * @param unknown_type $id
	 * @author liminggang
	 * @date 2013-10-18 下午3:15:20
	 * @throws
	 */
	public function _after_insert($id){
		//获得付款类型
		$pay_type = $_POST['pay_type'];
		//获取车辆ID
		$carID        = $_REQUEST['car_id'];
		//获得油卡ID
		$oil_id = $_POST['oil_id'];
		//获得加油金额
		$amount=str_replace(",", "", $_POST['amount']);
		//总里程
		$totalKM     = str_replace(",", "", $_REQUEST['totalKM']);
		//油卡模型
		$MisCarCardBind = D("MisCarCardBind");
		$data = array();
		//加油,消耗油卡余额
		if($pay_type>0){
			$data['oil_balance'] = array('exp',"oil_balance-".$amount);
			$result=$MisCarCardBind->where('id = '.$oil_id)->save($data);
			if(!$result){
				$this->error("油卡消耗失败");
			}
		}
	}
	/**
	 * @Title: _before_edit
	 * @Description: todo( info )
	 * @author	eagle
	 * @date
	 * @throws
	 */
	public function _before_edit(){
		//局部刷新处理，传参过来
		$this->common();
	}
	public function _before_update(){
		//获得付款类型
		$pay_type = $_POST['pay_type'];
		//获得油卡
		$oil_id = $_POST['oil_id'];
		//获得旧有卡号
		$oldoil_id = $_POST['oldoil_id'];
		$business_type=$_POST['business_type'];
		if($business_type ==1){
			//修改时 判断油卡是否是原先油卡
			if($oldoil_id==$oil_id){
				//加油 ,判断余额是否足够
				if($pay_type>0){
					$oil_balance=str_replace(",", "", $_POST['oil_balance']);
					$amount=str_replace(",", "", $_POST['amount']);
					//如何油卡余额小于加油总额。则提示
					if($amount>$oil_balance){
						$this->error("油卡余额不足");
					}
				}
			}else{
				//把旧的加油金额还原到旧油卡上
				$MisCarCardBindModel=D('MisCarCardBind');
				$oldamount=$_POST['oldamount'];
				$date['oil_balance'] = array('exp',"oil_balance+".$oldamount);
				$date['id']=$oldoil_id;
				$sumbalance=$MisCarCardBindModel->save($date);
				if(!$sumbalance){
					$this->error("操作失败！");
				}
				if($pay_type>0){
					//判断新加油卡余额是否小于加油总额
					$oil_balance=str_replace(",", "", $_POST['oil_balance']);
					$amount=str_replace(",", "", $_POST['amount']);
					//如果油卡余额小于加油总额。则提示
					if($amount>$oil_balance){
						$this->error("油卡余额不足");
					}
				}
			}
		}
	}
	public function lookupyscaroilinfo(){
		$carid=$_POST['carid'];
		//查询此车辆上次加油记录
		$MisCarAddOilInfoModel=D('MisCarAddOilInfo');
		$map['status']=1;
		$map['car_id']=$carid;
		$MisCarAddOilInfoList=$MisCarAddOilInfoModel->where($map)->order("add_time desc")->find();
		if($MisCarAddOilInfoList){
			echo json_encode($MisCarAddOilInfoList);
		}
	}
	public function _after_update(){
		//获得付款类型
		$pay_type = $_POST['pay_type'];
		//获得油卡ID
		$oil_id = $_POST['oil_id'];
		//获取旧油卡ID
		$oldoil_id=$_POST['oldoil_id'];
		//获得加油金额
		$amount=str_replace(",", "", $_POST['amount']);
		//获取旧的金额
		$oldamount=$_POST['oldamount'];
		//油卡模型
		$MisCarCardBind = D("MisCarCardBind");
		//金额差
		$newamount=$amount - $oldamount;
		$data = array();
		//加油,消耗油卡余额
		if($pay_type >0){
			//油卡ID没变
			if($oldoil_id==$oil_id){
				$data['oil_balance'] = array('exp',"oil_balance-".$newamount);
			}else{
				$data['oil_balance'] = array('exp',"oil_balance-".$amount);
			}
			$result=$MisCarCardBind->where('oil_id = '.$oil_id)->save($data);
			if(!$result){
				$this->error("油卡消耗失败");
			}
		}
		unset($date);
		//获取lastCarId为当前加油记录id
		$addoilId=$_POST['id'];
		//查询加油记录找到lastCarId为当前加油记录id
		$MisCarAddOilInfoModel=D('MisCarAddOilInfo');
		$MisCarAddOilInfoList=$MisCarAddOilInfoModel->where("lastCarId=".$addoilId." and status=1")->find();
		if($MisCarAddOilInfoList){
			//上次里程止数
			$date['lastTotalKM']=str_replace(",","",$_POST['totalKM']);
			//修改公里数  当前里程指数-上去里程止数
			$date['kilometre']=$MisCarAddOilInfoList['totalKM']-$date['lastTotalKM'];
			//上次加油金额
			$date['lastOilamount']= str_replace(",","",$_POST['amount']);
			//上次油价
			$date['lastOilprice']=$_POST['price'];
			$date['id']=$MisCarAddOilInfoList['id'];
			$lastResult=$MisCarAddOilInfoModel->save($date);
			if(!$lastResult){
				$this->error("操作失败！");
			}
		}
	}
	/**
	 * @Title: lookupmanage
	 * @Description: todo(用ztree形式查询出所有部门员工信息)
	 * @author liminggang
	 * @throws
	 */
	public function lookupmanage(){
		//组装tree
		$model= M('mis_system_car');
		$deptlistData = $model->where("status=1")->getField('departmentID',true);
		//读取部门，正式组装tree
		$modelMSD = M('mis_system_department');
		$mapDepartmentID['status']=1;
		$mapDepartmentID['id'] = array('in',$deptlistData);
		$deptlist = $modelMSD->where($mapDepartmentID)->field('id,name')->order("id asc")->select();
		//模板显示，与刷新相关
		$param['rel']="positiveBoxMisCarAddOilInfoBox";  //重要的地方，查找带回模板上的ID
		$param['url']="__URL__/lookupmanage/jump/1/department/#id#/";
		$treemiso[]=array(
				'id'=>0,
				'pId'=>-1,
				'name'=>'所有部门',
				'rel'=>'positiveBoxMisCarAddOilInfoBox',
				'target'=>'ajax',
				'url'=>'__URL__/lookupmanage/jump/1/department/#id#/',
				'title'=>'所有部门',
				'open'=>true
		);
		//分配树型结构数据到模板
		$typeTree = $this->getTree($deptlist,$param,$treemiso);
		$this->assign('tree',$typeTree);
		//查询条件，控制表单
		$this->assign("ifhidden_text", 1);  //0  隐掉，日期框  1 显示， 日期框
		//查询条件
		$map = array(); //清空条件
		$searchby = str_replace("-", ".", $_POST["searchby"]);
		$keyword=$this->escapeChar($_POST["keyword"]);
		$searchtype = $_POST['searchtype'];
		//关键字是否为空
		if($_POST["keyword"]){
			$map[$searchby] = ($searchtype==2)  ? array('like','%'.$keyword.'%'):$keyword;
			$this->assign('keyword',$keyword);
			$searchby = str_replace(".", "-", $_POST["searchby"]);
			$this->assign('searchby',$searchby);
			$this->assign('searchtype',$searchtype);
		}
		//搜索按哪个类型
		$searchby=array(
				array("id" =>"carno","val"=>"车牌号"),
				array("id" =>"name","val"=>"辆名称"),
		);
		$this->assign("searchbylist",$searchby);
		//模糊查询还是精确查询
		$searchtype=array(array("id" =>"2","val"=>"模糊查找"),array("id" =>"1","val"=>"精确查找"));
		$this->assign("searchtypelist",$searchtype);
		$department	= $_REQUEST['department'];
		if ($department) {
			$map['departmentID']=$department;
		}
		$map['status'] = array('eq',1);
		$this->_list('MisSystemCar',$map);
		$this->assign('department',$department);	 //部门id分配给，查找带回窗中的form中保留
		if ($_REQUEST['jump']) {
			$this->display('lookupmanagelist'); //如果jump=1 ; 那么是刷新右侧数据区
		} else {
			$this->display("lookupmanage"); //如果jump= 空 ; 第一弹出窗口
		}
	}
}
?>