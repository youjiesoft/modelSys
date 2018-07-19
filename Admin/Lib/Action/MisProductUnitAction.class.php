<?php
/**
 * @Title: MisProductUnitAction 
 * @Package package_name
 * @Description: todo(产品单位) 
 * @author liminggang 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2012-11-2 下午4:41:53 
 * @version V1.0
 */
class MisProductUnitAction extends CommonAction{
	/**
	 * @Title: _filter 
	 * @Description: todo(配置检索条件) 
	 * @param unknown_type $map  
	 * @author renling 
	 * @date 2013-5-31 下午5:05:44 
	 * @throws
	 */
	public function _filter(&$map){
		//判断是检索或者分页
		 if ($_SESSION["a"] != 1) $map['status']=array("gt",-1);
		
		/* if($_POST['keyword']){
			$searchby = $_POST['searchby'];
			$keyword=$this->escapeChar($_POST['keyword']);
			$searchtype = $_POST['searchtype'];
			if($searchby=="typeid"){
				$model=D("MisProductUnittype");
				$map2['name']= ($searchtype==2) ? array('like',"%".$keyword."%"):$keyword;
				$list = $model->where($map2)->field("id")->select();
				$arr=array();
				foreach($list as $key=>$value){
					$arr[]+=$value["id"];
				}
				$map[$searchby]=array('in',$arr);
			}else{
				$map[$searchby] = ($searchtype==2)  ? array('like',"%".$keyword."%"):$keyword;
			}
			$this->assign('keyword',$keyword);
			$this->assign('searchby',$searchby);
			$this->assign('searchtype',$searchtype);
		} */
	}
	/**
	 * (non-PHPdoc)
	 * @see CommonAction::index()
	 */
	function index(){
		$misProductUnittypeModel = D('MisProductUnittype');
		$map['status'] = 1;
		$map['unittypeid']=1;
		$list = $misProductUnittypeModel->where($map)->select();
		$param['rel']="misproductunit_rightcontent";
		$param['url']="__URL__/index/jump/1/type/#id#";
		$returnarr[]=array('id'=>0,'parentid'=>0,'name'=>'单位类型','open'=>true,'rel'=>'misproductunit_rightcontent','url'=>'__URL__/index/jump/1','target'=>'ajax');
		$treearr=$this->getTree($list,$param,$returnarr);
		$this->assign("treearr",$treearr);
		unset($map);
		$map = $this->_search();
		$typeid = $_SESSION['utype'];
		if ($typeid) {
			$map['typeid'] = $typeid;
			unset($_SESSION['utype']);
		} else {
			$typeid = $_REQUEST['type'];
			if ($typeid) {
				$map['typeid'] = $_REQUEST['type'];
			}
		}
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$this->assign('type',$typeid);
		$name = 'MisProductUnit';
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
	 * @Title: _before_edit 
	 * @Description: todo(打开修改页面前置函数)   
	 * @author renling 
	 * @date 2013-5-31 下午5:06:00 
	 * @throws
	 */
	function _before_edit(){
		$model = D("MisProductUnit");
		$map2['status']= 1;
		$typeList = $model->where($map2)->select();
		$utype = $_GET['utype'];
		$this->assign('utype',$utype);
		$this->assign('typelist',$typeList);
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		$select_config = $select_config['unittype']['unittype'];
		$this->assign('unittypelist',$select_config);
	}
	/**
	 * @Title: _before_add 
	 * @Description: todo(打开添加页面前置函数)   
	 * @author renling 
	 * @date 2013-5-31 下午5:06:20 
	 * @throws
	 */
	function _before_add(){
		$model = D("MisProductUnittype");
		$map2['status']= 1;
		$map2['unittypeid']=1;
		$typeList = $model->where($map2)->select();
		$utype = $_GET['utype'];
		$this->assign('utype',$utype);
		$this->assign('typelist',$typeList);
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		$select_config = $select_config['unittype']['unittype'];
		$this->assign('unittypelist',$select_config);
	}
	/**@Title: _before_insert
	* @Description: todo(插入前置函数)
	* @author renling
	* @date 2013-5-31 下午5:06:45
	* @throws
	*/
	public function _before_insert() {
		if($_POST['utype']) $_SESSION['utype'] = $_POST['utype'];
	}
	/**@Title: _before_update 
	 * @Description: todo(修改前置函数)   
	 * @author renling 
	 * @date 2013-5-31 下午5:07:23 
	 * @throws 
	*/  
	public function _before_update() {
		if($_POST['utype']) $_SESSION['utype'] = $_POST['utype'];
	}
}