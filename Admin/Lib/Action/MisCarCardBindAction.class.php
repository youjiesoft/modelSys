<?php
/**
 * @Title: 车辆油卡管理 
 * @Package package_name 
 * @Description: todo( info ) 
 * @author eagle 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-4-18 下午5:47:22 
 * @version V1.0
 */
class MisCarCardBindAction extends CommonAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
		
		//得到指定车辆的id
		$carid  = $_REQUEST['carid'];
		if(!empty($carid)){
			$map['carid'] = $carid;
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
		//得到要找的车输信息， 通过ID
		$id= $_REQUEST['carid'];
		if($id){
			$this->assign('carid',$id);
		}
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
		 //得到当前车辆carid
		 $carid = $_REQUEST['carid'];
		 $this->assign('carid',$carid);
		 
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
	 	//获取车辆carid附值到，新增模板中
		 $carid = $_REQUEST['carid'];
		 $this->assign('carid',$carid);
		 
		 //局部刷新处理，传参过来
		 $this->common();
	}
	/**
	 * @Title: _before_edit
	 * @Description: todo( info )   
	 * @author	eagle 
	 * @date 
	 * @throws 
	*/ 
	public function _before_edit(){
	 	//获取车辆carid附值到，新增模板中
		 $carid = $_REQUEST['carid'];
		 $this->assign('carid',$carid);
		 
		 //局部刷新处理，传参过来
		 $this->common();
	}
	
	/**
	 * @Title: updateOilID
	 * @Description: todo( 添加记录， 修改记录后， 更新mis_system_car表中的油卡ID )   
	 * @author	eagle 
	 * @date 
	 * @throws 
	*/ 
	public function updateOilID(){		
	 	//获取车辆carid附值到，新增模板中
		 $carid = $_REQUEST['carid'];
		 $oil_id = $_REQUEST['oil_id'];
		 
		 //更新 mis_system_car表
		 $name = "MisSystemCar";
		 $modeMSC = M($name);
		 $map['id'] = $carid;
		 
		 //列新动作
		 $modeMSC-> where($map)->setField('oilID',$oil_id);
	}
	
	/**
	 * @Title: updateOilID
	 * @Description: todo( 添加记录， 更新mis_system_car表中的油卡ID )   
	 * @author	eagle 
	 * @date 
	 * @throws 
	*/ 
	public function _after_insert(){
	 	//更新 mis_system_car中的油卡ID
	 	$this->updateOilID();

	}
	
	/**
	 * @Title: updateOilID
	 * @Description: todo( 修改记录后， 更新mis_system_car表中的油卡ID )   
	 * @author	eagle 
	 * @date 
	 * @throws 
	*/ 
	public function _after_update(){
	 	//更新 mis_system_car中的油卡ID
	 	$this->updateOilID();
	}
	
	/**
	 * @Title: lookupmanage
	 * @Description: todo(用ztree形式查询出所有部门员工信息)
	 * @author liminggang
	 * @throws
	 */
	public function lookupmanage(){
		//组装tree
// 		$model= D('MisSystemCarOilView');
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