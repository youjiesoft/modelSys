<?php
/**
 * @Title: MisFinanceExpensesTypeAction
 * @Package 文化信息部-计算机管理 ：功能类
 * @Description: TODO(计算机管理)
 * @author eagle
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
*/
class MisComputerAction extends CommonAction {
	/**
	 * @Title: _filter
	 * @Description: todo(构造检索条件)
	 * @param HASHMAP $map
	 * @author 杨东
	 * @date 2013-5-31 下午4:01:22
	 * @throws
	 */
	public function _filter(&$map){
		if ($_SESSION["a"] != 1) {
			$map['status']=array("gt",-1);
		}

	}
	
	/* (non-PHPdoc) 显示列表
	 * @see CommonAction::index()
	 */
	function index(){
			$searchtype=array(
				array("id" =>"2","val"=>"模糊查找"),
				array("id" =>"1","val"=>"精确查找")
			);
			$this->assign('searchtypelist',$searchtype);
			
			$dptmodel = D("MisSystemDepartment");//部门表
			$deptlist = $dptmodel->where("status=1")->order("id asc")->select();
			$typeTree = $this->getZtreelist($deptlist);
			$this->assign('typetree',$typeTree);
			
			$map=$this->_search();
			if (method_exists ( $this, '_filter' )) {
				$this->_filter ( $map );
			}
			
			//得到部门编号
			$deptid=$_REQUEST['deptid'];
			$this->assign("deptid",$deptid);
			if($deptid){
				$deptlist =array_unique(array_filter (explode(",",$this->downAllChildren($deptlist,$deptid))));
				$map['department_id'] = array(' in ',$deptlist);
			}
			//动态配置显示字段
			$name=$this->getActionName();
			$scdmodel = D('SystemConfigDetail');
			$detailList = $scdmodel->getDetail($name);
			if ($detailList) {
				$this->assign ( 'detailList', $detailList );
			}
			//searchby搜索扩展
			$searchby = $scdmodel->getDetail($name,true,'searchby');
			if ($searchby && $detailList) {
				$searchbylist=array();
				foreach( $detailList as $k=>$v ){
					if(isset($searchby[$v['name']])){
						$arr['id']= $searchby[$v['name']]['field'];
						$arr['val']= $v['showname'];
						array_push($searchbylist,$arr);
					}
				}
				$this->assign("searchbylist",$searchbylist);
			}
			//部门下拉列表
			$this->common();	
			//扩展工具栏操作
			$toolbarextension = $scdmodel->getDetail("MisComputer",true,'toolbar');
			if ($toolbarextension) {
				$this->assign ( 'toolbarextension', $toolbarextension );
			}

			if (! empty ( $name )) {
				$this->_list ($name, $map );
			}
			if( intval($_POST['dwzloadhtml']) ){
				$this->display("dwzloadindex");exit;
			}
			if ($_REQUEST['jump']) {
				$this->display('deptindex');
			} else {
				$this->display();
			}
	}
	
	/**
	 * 构造部门树形
	 * @param array  $alldata  所有部门信息
	 * @param int $pid  部门节点ID
	 * @param int $i  节点等级
	 * @return string
	 */
	private function getZtreelist($alldata){
		$returnarr=array();
		foreach($alldata as $k=>$v){
			$newv=array();
			$newv['id']=$v['id'];
			$newv['pId']=$v['parentid'];
			$newv['name']=$v['name'];
			$newv['type']='post';
			if($v['parentid']==0){
				$newv['url']='__URL__/index/jump/1/parentid/'.$v['parentid'];
			}else{
				$newv['url']='__URL__/index/jump/1/deptid/'.$v['id'].'/parentid/'.$v['parentid'];
			}
			$newv['target']='ajax';
			$newv['rel']='computermodel';
			$newv['open']='true';
			array_push($returnarr,$newv);
		}
		return json_encode($returnarr);
	}

	//定义上传文件路径
    private $UPLOADPATH="/MisComputer/";
    /**
     * @Title: _before_edit
     * @Description: todo(打开修改页面前置函数)
     * @author 杨东
     * @date 2013-5-31 下午4:11:26
     * @throws
     */
	public function _before_edit(){
		$this->common();
		//定义上传附件的导入路径
		$upload_path=$this->UPLOADPATH.date("Y/m/d",time())."/".$_SESSION[C('USER_AUTH_KEY')];
		$this->assign("upload_path",$upload_path);

	}
	/**
	 * @Title: _before_add
	 * @Description: todo(打开新增前置函数)
	 * @author 杨东
	 * @date 2013-6-1 下午3:37:38
	 * @throws
	 */
	public function _before_add(){
		$deptid=$_GET['deptid'];
		$this->assign('deptid',$deptid);
		$this->common();
		//订单号可写
	    $scnmodel = D('SystemConfigNumber');
        $writable= $scnmodel->GetWritable('mis_computer');
   		$this->assign("writable",$writable);
	   	//自动生成订单编号
	   	$code = $scnmodel->GetRulesNO('mis_computer');
		$this->assign("code", $code);
		//上传给组件，给定上传路径
        $upload_path=$this->UPLOADPATH.$code."/".$_SESSION[C('USER_AUTH_KEY')];
	    $this->assign("upload_path",$upload_path);
	}
	/**
	 * @Title: showInformation
	 * @Description: todo(显示计算机详细信息)   
	 * @author 杨东 
	 * @date 2013-6-1 下午4:38:23 
	 * @throws 
	*/  
	public function showInformation(){
		$this->edit();
		$this->display();
	}
	/**
	 * @Title: _filterLookupSelectPerson 
	 * @Description: todo(过滤掉离职状态的) 
	 * @param unknown_type $map  
	 * @author yuansl 
	 * @date 2014-5-24 上午10:28:23 
	 * @throws
	 */
	public function _filterLookupSelectPerson(&$map){
		$mapx['status'] = 1;
		$mapx['working'] = 0;
		$MisHrPersonnelPersonInfoModel = D("MisHrPersonnelPersonInfo");
		$EmployeIdList = $MisHrPersonnelPersonInfoModel->where($mapx)->getField('id',true);
		$map['id'] = array('not in',$EmployeIdList);
	}
	/**
	 * @Title: lookup
	 * @Description: todo(查询员工信息)   
	 * @author 杨东 
	 * @date 2013-6-1 下午4:34:41 
	 * @throws 
	*/  
	public function lookup() {
		//查找字段
		$searchby=array(
				array("id" =>"mis_hr_personnel_person_info-name","val"=>"按员工姓名"),
				array("id" =>"mis_hr_personnel_person_info-code","val"=>"按员工编号"),
		);
		$this->assign("searchbylist",$searchby);
		
		//查找类型 
		$searchtype=array(
				array("id" =>"2","val"=>"模糊查找"),
				array("id" =>"1","val"=>"精确查找")
		);
		$this->assign("searchtypelist",$searchtype);
		//检索部分
		if(!empty($_POST['keyword'])){
			$searchtypes=	$_POST['searchtype'];
			$searchbys	= 	str_replace("-",".",$_POST['searchby']);
			$keywords	=	$_POST['keyword'];
			$map1[$searchbys]=($searchtypes==2) ? array('like',"%".$keywords."%"):$keywords;
			//保留状态
			$this->assign('keyword',$keywords);
			$searchbys	= 	str_replace(".","-",$_POST['searchby']);
			$this->assign('searchby',$searchbys);
			$this->assign('searchtype',$searchtypes);
		}
		$map1['mis_hr_personnel_person_info.status']=1;
		$this->_list('MisHrPersonnelAppraisalInfoView',$map1);
		$this->display("lookup");
	}
	
	/**
	 * @Title: common
	 * @Description: todo(公共函数)   
	 * @author 杨东 
	 * @date 2013-6-1 下午4:33:56 
	 * @throws 
	*/  
	private function common(){
		$mismodel=D("MisSystemDepartment");
		$mislist =$mismodel->where('status = 1')->field("id,name")->select();
		$this->assign("department_idlist",$mislist);
	}
}
?>