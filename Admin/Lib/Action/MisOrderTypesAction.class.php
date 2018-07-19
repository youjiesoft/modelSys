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
class MisOrderTypesAction extends CommonAction {
/**
	 * @Title: _filter 
	 * @Description: todo(重写CommonAction的index方法，展示列表) 
	 * @return string  
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44 
	 * @throws
	 */
	public function _filter(&$map){
		if(empty($_REQUEST['status'])) {
			if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
		}
	}
	/**
	 * @Title: _before_add
	 * @Description: todo(add页面打开前传递展示信息)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */	
	public function _before_add()
	{
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
		$this->assign("list",$aryType);
		$utype = $_GET['utype'];
	    $this->assign('utype',$utype);
	}
	/**
	 * @Title: index
	 * @Description: todo(重写CommonAction的index方法，展示列表)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */	
	public function index(){
		$this->assign('mistree',$this->getTree());
		$name=$this->getActionName();
		$model=D($name);
		/* $list=$model->where($map)->select(); */
		if( $list ) $map['id']=$list[0]['id'];
		/* $param['rel']="misordertypesBox";
		$param['url']="__URL__/index/jump/1/id/#id#/type/#type#";		
		$returnarr[]=array('id'=>0,'parentid'=>0,'name'=>'单据类型','open'=>'true');
		$treearr=$this->getTree($list,$param,$returnarr);
		$this->assign('mistree',$treearr); */
		//$this->assign('mistree',$this->getTree());
		$map = $this->_search();
		$type = $_SESSION['utype'];
		if($type){
			$map['type'] = $type;
			unset($_SESSION['utype']);
		}else{
			$type = $_REQUEST['type'];
			if ($type) {
				$map['type'] = $_REQUEST['type'];
			}
		}
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$this->assign('type',$type);
		$name = 'MisOrderTypes';
		//动态配置部分。
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
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		if( intval($_POST['dwzloadhtml']) ){$this->display("dwzloadindex");exit;}
		//查询数据部分
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
		if ($_REQUEST['jump']) {
			$this->display('unitlist');
		} else {
			$this->display();
		}
	}

	/**
	 * @Title: getTree
	 * @Description: todo(生成左边树结构)
	 * @return json
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
 	 */	
	public function getTree() {
		 //读取订单类型配置文件
		$model=D('SystemTypeView');
		if(file_exists($model->GetFile())){
			require $model->GetFile();
		}
		$treemiso[]=array(
			'id'=>0,
			'pId'=>-1,
			'name'=>'类型分类',
			'rel'=>'misordertypesBox',
			'target'=>'ajax',
			'url'=>'__URL__/index/jump/1/type/0',
			'open'=>true
		);
		foreach ($aryType as $k => $v) {
		       $treemiso[]= array(
				       'id'=>$v['type'],
				       'pId'=>0,
				       'name'=>$v['typename'],
				       'rel'=>'misordertypesBox',
				       'target'=>'ajax',
				       'url'=>'__URL__/index/jump/1/type/'.$v[type]
		       );
		}
		return json_encode($treemiso);
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
		if($_POST['utype']) $_SESSION['utype'] = $_POST['utype'];
		$this->checkifexistcodeororder('mis_order_types','code');
	}


	/**
	 * @Title: _before_edit
	 * @Description: todo(edit页面前传入数据)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function _before_edit()
	{
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
		$this->assign("typelist",$aryType);
		//编号可写
		$model1	=D('SystemConfigNumber');
		$writable= $model1->GetWritable('mis_order_types');
		$this->assign("writable",$writable);
		$utype = $_GET['utype'];
		$this->assign('utype',$utype);
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