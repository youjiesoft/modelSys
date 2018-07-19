<?php
/**
 * @Title: MisCarReturnAction
 * @Package package_name
 * @Description: todo(还车记录)
 * @author 杨东
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-6-1 下午4:19:00
 * @version V1.0
 */
class MisCarReturnAction extends CommonAction {
	/**
	 * @Title: _filter
	 * @Description: todo(构造检索条件)
	 * @param HASHMAP $map
	 * @author 杨东
	 * @date 2013-5-31 下午4:01:22
	 * @throws
	 */
	public function _filter(&$map){
		$map['status']=1;
	}
	/* (non-PHPdoc) 显示列表
	 * @see CommonAction::index()
	*/
	function index(){
		//手动组装个数组，生成左侧树型结构
		$deptlist = Array(
					'0'=> Array('id'=>'1','name'=>'车辆管理列表','parentid'=>'0'),
					'1'=> Array('id'=>'2','name'=>'待还车辆','parentid'=>'1'),
					'2'=> Array('id'=>'3','name'=>'已还车辆','parentid'=>'1')
				);
		$typeTree = $this->getZtreelist($deptlist);
		$this->assign('typetree',$typeTree);
		$map=$this->_search();
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
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
		//扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail("MisCarReturn",true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		//未还车的条件
		$findKeyValue = $_REQUEST['findKeyValue'];//findKeyValue
		if( $findKeyValue ){
			$map['issendcar']=2;  //已派车
			$map['status']=1;  //有效字段
			$map['auditState'] = 3;//审核通过才能算借车
			$map['returnTag']=0; //没有还车标记
			$name='MisRequestCar';
		}
		//去_list方法中把数据取出来
		if (! empty ( $name )) {
			$qx_name=$name;
			if(substr($name, -4)=="View"){
				$qx_name = substr($name,0, -4);
			}
			//验证浏览及权限
			if( !isset($_SESSION['a']) ){
				$map=D('User')->getAccessfilter($qx_name,$map);	
			}
			$this->_list ($name, $map );
		}

		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		//jump=1 局部加载 rightindex.html / rightindex_other.html 到右侧DIV中	
		if ($_REQUEST['jump'] || $findKeyValue) {
			//未还车是别外一张表， a连接中加了一个get参数 ；
			if($findKeyValue){
				$this->display('rightindex_other');
			}else{
				$this->display('rightindex');
			}
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
			$newv['title']=$v['name'];
			$newv['type']='post';
			if($v['id']==2){
				$newv['url']='__URL__/index/jump/1/findKeyValue/1';
			}else{
				$newv['url']='__URL__/index/jump/1/findKeyValue/0';
			}
			$newv['target']='ajax';
			$newv['rel']='miscarreturn';
			$newv['open']='true';
			array_push($returnarr,$newv);
		}
		return json_encode($returnarr);
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

	/**
	 * @Title: _before_edit
	 * @Description: todo(打开修改页面前置函数)
	 * @author 杨东
	 * @date 2013-5-31 下午4:11:26
	 * @throws
	 */
	public function _before_edit(){
		$model=M("mis_request_car");
		$list =$model->field("id,orderno")->select();
		$this->assign("roidlist",$list);
		
		$model=M("mis_order_types");
		$list =$model->field("id,name")->select();
		$this->assign("rtypelist",$list);

	}


	function edit() {
		$findKeyValue = $_REQUEST['findKeyValue'];
		if($findKeyValue){
			$name="MisRequestCar";
		}else{
			$name=$this->getActionName();
		}
		$model = D ( $name );
		$id = $_REQUEST [$model->getPk ()];
		$map['id']=$id;
		if ($_SESSION["a"] != 1) $map['status'] = 1;
		$vo = $model->where($map)->find();
		if(empty($vo)){
			$this->display ("Public:404");
			exit;
		}
		//判断系统授权
		//lookup带参数查询
		$module=A($name);
		if (method_exists($module,"_after_edit")) {
			call_user_func(array(&$module,"_after_edit"),&$vo);
		}
		$this->assign( 'vo', $vo );
		//取车辆申请的话，显示不同的编辑模板
		if($findKeyValue){
			$this->display('add');
		}else{
			$this->display();
		}
	}
	
	/**
	 * @Title: _before_add
	 * @Description: todo(打开新增前置函数)
	 * @author 杨东
	 * @date 2013-6-1 下午3:37:38
	 * @throws
	 */
	public function _before_add(){

		$model=M("mis_request_car");
		$list =$model->field("id,orderno")->select();
		$this->assign("roidlist",$list);

		$model=M("mis_order_types");
		$list =$model->field("id,name")->select();
		$this->assign("rtypelist",$list);
	}
	
	/**
	 * @Title: lookup
	 * @Description: todo(查询员工信息)
	 * @author 杨东
	 * @date 2013-6-1 下午4:23:54
	 * @throws
	 */
	public function lookup() {
		$searchby=array(
				array("id" =>"arrivePlace","val"=>"按目的地"),
				array("id" =>"applyUser","val"=>"申请人名字"),
		);
		$searchtype=array(
				array("id" =>"2","val"=>"模糊查找"),
				array("id" =>"1","val"=>"精确查找")
		);
		$this->assign("searchtypelist",$searchtype);
		$this->assign("searchbylist",$searchby);
		//检索部分
		if(!empty($_POST['keyword'])){
			$searchtypes=	$_POST['searchtype'];
			$searchbys	= 	$_POST['searchby'];
			$keywords	=	$_POST['keyword'];
			$map[$searchbys]=$searchtypes==2 ? array('like',"%".$keywords."%"):$keywords;
			//保留状态
			$this->assign('keyword',$keywords);
			$this->assign('searchby',$searchbys);
			$this->assign('searchtype',$searchtypes);
		}
		$map['status']=1;
		$map['auditState'] = 3;//审核通过才能算借车
		$map['returnTag']=0;  //是否添加了还车记录
		$this->_list('MisRequestCar',$map);
		$this->display("lookup");
	}

	/**
	 * @Title: lookupgethours
	 * @Description: todo(计算时间，所回到添加页面当中去)
	 * @author 杨东
	 * @date 2013-6-1 下午4:24:05
	 * @throws
	 */
	function lookupgethours(){
		$s = $_REQUEST["sdate"];
		$e = strtotime(str_replace ( '&nbsp;',' ', $_REQUEST["edate"] ));
		if($e<=$s || !$s || !$e){
			echo "";
			exit;
		}
		import ( "@.ORG.Date" );
		$date=new Date(intval( $s ));
		echo  $date->timeDiff($e,2,false);
		exit;
	}

	/**
	 * @Title: _after_insert
	 * @Description: todo(更改车输基本信息，中的的总里程数)
	 * @param 插入ID $id
	 * @author 杨东
	 * @date 2013-6-1 下午4:24:17
	 * @throws
	 */
	function _after_insert($id){
		//获取表单中，查找带回放到，后台表单中的车辆基本信息ＩＤ
		$carID        = $_REQUEST['carID'];
		$totalKM     = str_replace(",", "", $_REQUEST['totalKM']); //总里程
		//更新车辆基本数据信息中的，status状态为0； 这样说明车辆大使用中
		$modelMSC     = M('mis_system_car');
		//还车成功  清空 车辆开始使用时间,车辆预计返还时间
		$fixdata['use_statime'] = 0;
		$fixdata['use_endtime'] = 0 ;
		$fixdata['use_status'] = 0 ;
		$re = $modelMSC->where("id = ".$carID)->save($fixdata);
		
		$data = array(
				'id'=>$carID,
				'status'=>'1',
				'occupyID'=>'',
				'totalKM'=>$totalKM,
				);
		$result=$modelMSC->save($data);
		if(!$result){
			$this->error("修改车辆状态失败");	
		}
		//建立模型
		$modelMRC = M('mis_request_car');
		$data = array();
		$data = array(
				'id'=>$_REQUEST['roid'],//派车申请单号
				'returnTag'=>1,  //标记为已还车辆
				'planReturnTime'=>strtotime($_REQUEST['returnTime']), //还车时间
				);
		$mrcresult=$modelMRC->save($data);
		if(!$mrcresult){
			$this->error("修改派车申请已还状态失败");
		}
		
	}
	
	/**
	 * @Title: _after_edit
	 * @Description: todo(修改最后一次用车记录信息，只能修改最后一次记录，因为这里有信息回退操作。实际用车中。 已给修改了多次。 当你修改的不是最后一次用车记录。)
	 * @param unknown_type $vo
	 * @author 杨东
	 * @date 2013-6-1 下午4:24:48
	 * @throws
	 */
	function _after_edit($vo){
		$modelMRC             = M('mis_car_return');
		$l_map['carID']       = array('eq',$vo['carID']);
		$l_map['id']          = array('gt',$vo['id']);
		$exitNumber           = $modelMRC->where($l_map)->count ("*");
		if($exitNumber){
			$this->error ("已操借出车辆超过一次，所以不能更改，希望下次要细心工作！");
			exit;
		}
		$vo['tempTotalKM']    = $vo['totalKM']-$vo['runKM'];
		$modelMRC             = M('mis_request_car');
		$map['id']            = $vo['roid'];
		//取出请车单中，
		$vo['tempReturnTime'] = $modelMRC->where($map)->getField('departureTime');
	}
	
	/**
	 * @Title: _after_update
	 * @Description: todo(修改后重更新，车辆基本信息状态)
	 * @param 更新对象 $list
	 * @author 杨东
	 * @date 2013-6-1 下午4:25:17
	 * @throws
	 */
	function _after_update($list){
		if($list) {
			$this->_after_insert();
		}
	}

}
?>