<?php

/**
 * @Title: MisSaleWaybillDetails
 * @Package package_name
 * @Description: 运单详情
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-09-23 16:28:46
 * @version V1.0
*/
class MisSaleWaybillDetailsAction extends CommonAction {
	
public function index() {
	
	$huoyuandanhao=$_REQUEST['id'];
// 	$huoyuandanhao=getFieldBy($huoyuanid, 'id', 'orderno', 'mis_auto_tibjx');
	
		//列表过滤器，生成查询Map对象
		$name = $this->getActionName();
		$MisAutoQec='MisAutoQec';
		$map = $this->_search ($name);
		if(!empty($huoyuandanhao) && $huoyuandanhao!=0){
			$map['huoyuandanhao']=$huoyuandanhao;
		}else{
			$huoyuandanhao=0;
		}
		$this->assign('huoyuandanhao',$huoyuandanhao);
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		if($_REQUEST['fieldtype']){
			$this->getBindSetTables($map);
		}
		if($_REQUEST['projectid']){
			$map['projectid'] = $_REQUEST['projectid'];
		}
		if($_REQUEST['projectworkid']){
			//$map['projectworkid'] = $_REQUEST['projectworkid'];
		}
		if($_REQUEST['ordertype']){
			$map['ordertype'] = $_REQUEST['ordertype'];
		}
		//查询用户组
		$userid = $_SESSION[C('USER_AUTH_KEY')];
		$rolegroup_userModel=M('rolegroup_user');
		$rolMap['user_id']=$userid;
		$rolelist=$rolegroup_userModel->where($rolMap)->field('rolegroup_id')->select();
		foreach ($rolelist as $rk=>$rv){
			$rolegroup[]=$rv['rolegroup_id'];
		}
		//判断是否是管理员组
		$isexicite=in_array('136',$rolegroup);
		if(!$isexicite  && !isset($_SESSION['a'])){
			$map['mis_auto_tibjx.createid'] =$userid;
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
			unset($map['createid']);
			unset($map['companyid']);
			$this->_list ( 'MisSaleWaybillDetailsView', $map );
		}
		
 		//begin
		$scdmodel = D('SystemConfigDetail');
		//读取列名称数据(按照规则，应该在index方法里面)
		$detailList = $scdmodel->getDetail($name,true,'','sortnum');
		if(file_exists(ROOT . '/Dynamicconf/Models/'.$name.'/form.inc.php')){
			$anameList = require ROOT . '/Dynamicconf/Models/'.$name.'/form.inc.php';
			if(!empty($detailList) && !empty($anameList)){
				foreach($detailList as $k => $v){
					$detailList[$k]["datatable"] = 'template_key=""';
					foreach($anameList as $kk => $vv){
						if($k==$kk){
							$detailList[$k]["datatable"] = $vv["datatable"];
						}
					}
				}
			}
		}
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
 		//扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar','sortnum','shows',true);
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		//end
		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		//首页收件箱调用方法，为ajax调用
		if ($_GET['type'] == "ajaxcall") {
			$this->display ("ajax_index");exit;
		}
		if($_REQUEST['jump'] == "jump"){
			$this->display('indexview');exit;
		}
		$this->display ();
		return;
	}
	
	function _after_list($voList){
		foreach ($voList as $key=>$val){
			//当前位置为空时去map表查询
			if(empty($val['dangqianweizhi'])){
				$mapModel=M('mis_system_map_trace');
				$mapMap['orderno']=$val['id'];
				$maplist=$mapModel->where($mapMap)->order('id desc')->find();
				$voList[$key]['dangqianweizhi']=$maplist['city'];
			}
		}
		
	}
	function edit($num=1) {
		// 实例化对应数据表模型
		$name = $this->getActionName();
		// 审批流 动态建模页面时的子表数据获取 add by nbmkxj@20150129 2214
		$viewCheckPath = LIB_PATH.'Model/'.$name.'ViewModel.class.php';
		if(is_file($viewCheckPath)){
			$model = D ( $name.'View' );
		}else{
			$model = D ( $name);
		}
	
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$map['id']=$id;
		$vo = $model->where($map)->find();
		//echo $model->getLastSql();
		/*
		 * 验证新增页面或者修改页面字段权限控制
		 * 查询固定流程是否存在
		*/
		$ProcessInfoModel = D ( "ProcessInfo" );
		//验证流程是否存在
		$pcarr = $ProcessInfoModel->getProcessInfo($name);
		if($pcarr){
			//存在流程配置
			$map = array();
			$map['pinfoid'] = $pcarr ['id'];
			$map['tablename'] = "process_info";
			$map['status'] = 1;
			$map['flowtype'] = 0; //开始节点
			$ProcessRelationModel = D ( "ProcessRelation" );
			// 获取流程节点数据
			$relationList = $ProcessRelationModel->where ( $map )->find();
			if($relationList){
				$userid = $_SESSION[C('USER_AUTH_KEY')];
				$_SESSION["nodeActionName".$userid] = $name;
				$_SESSION['nodeAuditId'.$userid] = $relationList['id'];
				$_REQUEST['node'] = $relationList['id'];
			}
		}
		//end
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
	
		// 上一条数据ID
		$map['id'] = array("lt",$id);
		$updataid = $model->where($map)->order('id desc')->getField('id');
		$this->assign("updataid",$updataid);
		// 下一条数据ID
		$map['id'] = array("gt",$id);
		$downdataid = $model->where($map)->getField('id');
		$this->assign("downdataid",$downdataid);
	
		//获取附件信息
		$this->getAttachedRecordList($id,true,true,$name);
		// 获取现 可能有的地区信息
		$areaModel = M('MisAddressRecord');
		$areainfomap['tablename'] = $this->getActionName();
		$areainfomap['tableid'] = $id ;
		$areaArr = $areaModel->where($areainfomap)->select();
		foreach ($areaArr as $key=>$val){
			$areainfoarry[$val['fieldname']][]=$val;
		}
		$this->assign('areainfoarry' , $areainfoarry);
		//lookup带参数查询
		$module=A($name);
		//		$module->_after_edit();
		if (method_exists($module,"_after_edit")) {
			call_user_func(array(&$module,"_after_edit"),&$vo);
		}
		//读取动态配制
		$this->getSystemConfigDetail($name,$vo);
		//dump($vo);
		$this->assign( 'vo', $vo );
		if($num){
			$this->display ();
		}
	
	}
	
	function view($num=1){
		if($_REQUEST['preview']==1){
			$name = $this->getActionName();
			$this->previewPost();
			//读取动态配制
			$this->getSystemConfigDetail($name);
			$this->display();
			exit;
		}
		$name=$this->getActionName();
		$module=A($name);
		if (method_exists($module,"_before_edit")) {
			call_user_func(array(&$module,"_before_edit"));
		}
		$this->edit ($num);
	}
	
}
?>
