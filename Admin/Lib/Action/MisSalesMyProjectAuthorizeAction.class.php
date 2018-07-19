<?php
/**
 * @Title: MisSalesMyProjectAuthorizeAction
 * @Package 项目授权管理
 * @Description: TODO(项目授权管理)
 * @author 
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 
 * @version V1.0
 */
class MisSalesMyProjectAuthorizeAction extends CommonAction {
	
	private $arr=array(
			array(
					'id' =>1,
					'name'=>'权限菜单',
					'pId'=>0,
					'title'=>'权限菜单',
					'open'=>true,
					),
			array(
					'id' =>2,
					'name'=>'用户授权',
					'pId'=>1,
					'title'=>'用户授权',
					'rel' =>'abc',
					'target'=>'ajax',
					'type' =>'post',
					'url'=>'__APP__/MisSalesMyProjectAuthorize/index/type/1/jump/1/md/User',
					),
			array(
					'id' =>2,
					'name'=>'组授权',
					'pId'=>1,
					'title'=>'组授权',
					'rel' =>'abc',
					'target'=>'ajax',
					'type' =>'post',
					'url'=>'__APP__/MisSalesMyProjectAuthorize/index/type/2/catgory/1/jump/1/md/MisSalesMyProjectRolegroup',
			),
		);
	/** @Title: _filter
	 * @Description: (列表进入的过滤器)
	 * @author
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function _filter(&$map){
		if ($_SESSION["a"] != 1){
			$map['status']=array("gt",-1);
		}
	}
	/**
	 * (non-PHPdoc)
	 * @Description: TODO(重写父类的index方法，实现此处的查询功能)
	 * @see CommonAction::index()
	 */
	
 	public function index(){
		$name=$_REQUEST['md']?$_REQUEST['md']:'User';
		$this->assign('ztree', json_encode($this->arr));
		
		$map = $this->_search ($name);
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		if ($_REQUEST['type'] == 2){
			$map['status'] = array('gt',0);
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
			$catgory=$_REQUEST['catgory'];
			if($catgory){
				$map['catgory'] = $catgory;
				$this->assign('catgory',$catgory);
			}
			if($name=='user'){
				$this->_list ( "MisHrPersonnelUserDeptView", $map );
			}else{
				$this->_list ( $name, $map );
			}
		}
		$this->assign('module',$name);
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
		
		$type=$_REQUEST['type'];
		//扩展工具栏操作
		if($type==2 && $catgory==5){
			$toolbarextension = $scdmodel->getDetail('MisOrganizationalSet',true,'toolbar');
		}elseif($type==2 && $catgory==3){
			$toolbarextension = $scdmodel->getDetail('MisRoleGroup',true,'toolbar');
		}else{
			$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		}
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		if ($_REQUEST['jump']) {
			if($type==2){
				$this->display('AuthorizeRolegroup');
			}else{
				$this->display('AuthorizeUser');
			}
		} else {
			$this->display();
		}
	}
	//进入授权页面
	function userAuthorizeB(){
		$map['userid'] = $_REQUEST['userid'];
		$name['title']='项目权限管理';
		$model = M('mis_sales_project_rolegroup');
		$list = $model->where($map)->find();
		//如果有数据则添加一个删除权限的按钮
		if($list){
			$this->assign('youwuquanxian','1');
		}
		$modelProject = M('mis_auto_kimpu');
		if($list['dandushouquanID']){//如果有单独授权ID则查询出显示到页面
			$map = array();
			$map['id'] = array('in',$list['dandushouquanID']);
			$listProject = $modelProject->where($map)->order('id desc')->getField('orderno',true);
			$listProjectstring=implode(' ',$listProject);
			$this->assign('listProjectstring',$listProjectstring);
			
		}
		$this->assign('userid',$_REQUEST['userid']);
		$this->assign('nodelist',$name);
		$this->assign('vo',$list);
		$this->display('userAuthorizeRight');
	}
	//新建一个用户权限或修改的方法
	function writeRoleUser(){
		//根据UserID查询数据 如果数据为null则新增一条数据 不然就更新数据
		$map['userid'] = $_POST['userid'];
		$model = D('MisSalesMyProjectRolegroup');
		//根据用户的ID查询到数据	
		$list = $model->where($map)->select();
		//需要更新的过滤条件
		if($_POST['rules']){
			$data['rules'] = $_POST['rules'];
			$data['showrules'] = $_POST['showrules'];
			$data['rulesinfo'] = $_POST['rulesinfo'];
		}else{
			$data['rules'] = "";
			$data['showrules'] = "";
			$data['rulesinfo'] = "";
		}
		//判断是否有单独授权的项目ID
		if ($_POST['dandushouquanID']){
			$data['dandushouquanID'] = $_POST['dandushouquanID'];
		}else{
			$data['dandushouquanID'] = "";
		}
		//获取需要更新权限值
		$data['plevels'] = $_REQUEST['plevels'];
		if($list){
			//修改人的数据信息
			$data['updatetime']=time();
			$data['updateid']=$_SESSION[C('USER_AUTH_KEY')];
			$ret=$model->where($map)->save($data);
		}else{
			//新用户的所有数据
			$data['companyid']='0';
			$data['createtime']=time();
			$data['remark']='用户权限';
			$data['createid']=$_SESSION[C('USER_AUTH_KEY')];
			$data['name'] = '1';//这个name不具有任何意义 也可以通过查询USER或者传值获取当前用户的名字
			$data['userid'] = $map['userid'];//
			$data['catgory'] = '2';//2类型为用户
			$data['operateid'] = '0';
			$ret = $model->add($data);
		}
		//判断NewAdd方法的返回值
		if($ret===false){
			$this->error($model->getDBError());
		}else{
			$this->success('保存成功');
		}	
	}
	//根据userid删除用户的权限
	function deleteid(){
		$model = M("mis_sales_project_rolegroup");
		$getlist = $model->where('userid='.$_GET['userid'])->select();
		if($getlist){
			$list = $model->where('userid='.$_GET['userid'])->delete();
			if($list>0){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}else{
			$this->error('此用户还没有权限');
		}
		
	}
}
?>