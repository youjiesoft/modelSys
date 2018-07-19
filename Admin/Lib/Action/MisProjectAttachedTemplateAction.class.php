<?php 
/**
 * @Title: MisProjectAttachedTemplateAction 
 * @Package package_name 
 * @Description: todo(项目附件模板管理控制器) 
 * @author wangzhaoxia 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-11-05 下午5:00:36 
 * @version V1.0
 */
class MisProjectAttachedTemplateAction extends CommonAction{
	
	public function additemview(){
		$type_list = array ();
		//获取上传格式限制
		$allexts = C ( "allexts" );
		$type_list [] = array (
				"value" => - 1,
				"name" => "全部"
		);
		foreach ( $allexts as $k => $v ) {
			$type_list [] = array (
					"value" => $k,
					"name" => $v
			);
		}
		$this->assign ( 'allexts', $type_list );
		$name = $this->getActionName ();
		$model = D ( $name );
		$id = $_REQUEST ["id"];
		$map ["id"] = $id;
		$mas_vo = $model->where ( $map )->find ();
		if (empty ( $mas_vo )) {
			$this->display ( "Public:404" );
			exit ();
		}
		//第一步，sub数据查询
		$submodel = M ( "mis_project_attached_template_sub" );
		$where['masid'] = $mas_vo['id'];
		$sublist = $submodel->where($where)->select();
		$subidArr = array();
		//附件信息查询
		foreach($sublist as $key=>$val){
			//array_push($subidArr, $val['id']);
			//获取上传附件信息
			$recolist = $this->getAttachedRecordList($mas_vo['id'],true,true,"MisProjectAttachedTemplate",$val['id'],false);
			$sublist[$key]['record'] = $recolist;
			//获取参照附件信息
			$czrecolist = $this->getAttachedRecordList($mas_vo['systemmasid'],true,true,"MisAttachedTemplate",$val['systemsubid'],false);
			$sublist[$key]['czrecord'] = $czrecolist;
		}
		$this->assign("mas_vo",$mas_vo);
		$this->assign("sublist",$sublist);
		$projectCatgroy = $_REQUEST['projectCatgroy'];
		if($projectCatgroy == 2){
			//项目过来的查看
			$this->display("additemviewedit");
		}else{
			$this->display();
		}
		
	}
	
	function _after_edit($vo){
		$type_list = array ();
		$allexts = C ( "allexts" );
		$type_list [] = array (
				"value" => - 1,
				"name" => "全部"
		);
		foreach ( $allexts as $k => $v ) {
			$type_list [] = array (
					"value" => $k,
					"name" => $v
			);
		}
		$type_list1=json_encode($type_list);
		$this->assign ( 'allexts', $type_list);
		$this->assign ( 'allexts1', $type_list1);
		//第一步，sub数据查询
		$submodel = M ( "mis_project_attached_template_sub" );
		$map['masid'] = $vo['id'];
		$sublist = $submodel->where($map)->select();
		$subidArr = array();
		//附件信息查询
		foreach($sublist as $key=>$val){
			array_push($subidArr, $val['id']);
			//获取附件信息
			$recolist = $this->getAttachedRecordList($vo['id'],true,true,"MisProjectAttachedTemplate",$val['id'],false);
			$sublist[$key]['record'] = $recolist;
		}
		
		$this->assign("mas_vo",$vo);
		$this->assign("sublist",$sublist);
		$this->assign("suvidArr",implode(",", $subidArr));
	}
	
	function update(){
		// 实例化附件设计模板
		$submodel = M ( "mis_project_attached_template_sub" );
		$subname = $_POST ['subname']; // 资料名称
		$save_file = $_POST ['swf_upload_save_name'];
		$source_file = $_POST ['swf_upload_source_name'];
		$subidArr = explode ( ",", $_POST ['suvidArr'] );
		$inArr = array ();
		foreach ( $subname as $key => $val ) {
			if (in_array ( $_POST ['subid'] [$key], $subidArr ) && $_POST ['subid'] [$key] != null) {
				array_push ( $inArr, $_POST ['subid'] [$key] );
				// 原始数据修改
				$data = array ();
				$data ['id'] = $_POST ['subid'] [$key];
				$data ['name'] = $val;
				$data ['type'] = $_POST ['subtype'] [$key];
				$data ['remark'] = $_POST ['subremark'] [$key];
				$data ['datum'] = $_POST ['subdatum'] [$key];
				$data ['createid'] = $_POST ['subremark'] [$key];
				$data ['createid'] = $_SESSION [C ( 'USER_AUTH_KEY' )];
				$data ['createtime'] = time ();
				$result = $submodel->save ( $data );
				if ($result) {
					if ($save_file [$key]) {
						// 存在附件信息
						unset ( $_POST ['swf_upload_save_name'] );
						unset ( $_POST ['swf_upload_source_name'] );
						$_POST ['swf_upload_save_name'] = $save_file [$key];
						$_POST ['swf_upload_source_name'] = $source_file [$key];
						$this->swf_upload ( $_POST ['id'], false, $_POST ['subid'] [$key], 'MisProjectAttachedTemplate' );
					}
				} else {
					$this->error ( "附件模板设计失败，请联系管理员" );
				}
			} else {
				// 新数据新增
				$data = array ();
				$data ['masid'] = $_POST ['id'];
				$data ['name'] = $val;
				$data ['type'] = $_POST ['subtype'] [$key];
				$data ['remark'] = $_POST ['subremark'] [$key];
				$data ['datum'] = $_POST ['subdatum'] [$key];
				$data ['createid'] = $_POST ['subremark'] [$key];
				$data ['createid'] = $_SESSION [C ( 'USER_AUTH_KEY' )];
				$data ['createtime'] = time ();
				$subid = $submodel->add ( $data );
				if ($subid) {
					if ($save_file [$key]) {
						// 存在附件信息
						unset ( $_POST ['swf_upload_save_name'] );
						unset ( $_POST ['swf_upload_source_name'] );
						$_POST ['swf_upload_save_name'] = $save_file [$key];
						$_POST ['swf_upload_source_name'] = $source_file [$key];
						$this->swf_upload ( $_POST ['id'], false, $subid, 'MisProjectAttachedTemplate' );
					}
				} else {
					$this->error ( "附件模板设计失败，请联系管理员" );
				}
			}
		}
		// 排除相同的，获取新的数组
		$newArr = array_diff ( $subidArr, $inArr );
		if ($newArr) {
			$map = array ();
			$map ['id'] = array (' in ',$newArr );
			$result = $submodel->where ( $map )->delete ();
			if (! $result) {
				$this->error ( "附件模板设计失败，请联系管理员" );
			}
		}
		$this->success ( L ( '_SUCCESS_' ) );
	}
	/**
	 * @Title: lookupprojecttemplateadd
	 * @Description: 项目执行附件上传方法   
	 * @author 黎明刚
	 * @date 2014年11月24日 下午4:20:37 
	 * @throws
	 */
	public function lookupprojecttemplateadd(){
		$subisfile = $_POST["subisfile"];
		$name = $this->getActionName ();
		$model = D ( $name );
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		// 保存当前数据对象
		$list = $model->add ();
		if ($list !== false) {
			//实例化附件设计模板
			$projectsubmodel = M ( "mis_project_attached_template_sub" );
			$subid = $_POST['subid'];
			$subname = $_POST['subname'];//资料名称
			$save_file=$_POST['swf_upload_save_name'];
			$source_file=$_POST['swf_upload_source_name'];
			
			foreach($subname as $key=>$val){
				$data = array();
				$data['masid']= $list;
				$data['name']= $val;
				$data['datum']= $_POST['subdatum'][$key];
				$data['suoshujuese'] = $_POST['subjuese'][$key];
				$data['type']= $_POST['subtype'][$key];
				$data['systemsubid']=$subid[$key];
				$data['remark']= $_POST['subremark'][$key];
				$data['createid'] = $_SESSION [C ( 'USER_AUTH_KEY' )];
				$data['createtime'] = time ();
				$data['isfile']=$subisfile[$key]?1:0;
				$subid = $projectsubmodel->add($data);
				if($subid){
					if ($save_file[$key]) {
						//存在附件信息
						unset($_POST ['swf_upload_save_name']);
						unset($_POST ['swf_upload_source_name']);
						$_POST ['swf_upload_save_name'] = $save_file[$key];
						$_POST ['swf_upload_source_name'] = $source_file[$key];
						$this->swf_upload ( $list, $subid, 'MisProjectAttachedTemplate' ,$_POST['projectid'],$_POST ['projectworkid']);
					}
				}else{
					$this->error ( "附件模板设计失败，请联系管理员" );
				}
			}
			//如果存在项目编号跟项目任务，而且审核状态为审核完毕
			if ($_POST['projectid'] && $_POST['projectworkid'] && $_POST['operateid'] ) {
				$MSFFModel = D ( 'MisProjectFlowForm' );
				$MSFFModel->setWorkComplete ( $_POST['projectworkid'] ,$_POST['projectid']);
				// 这里不报错，如果报错的话会有很多影响，如果没更新状态成功，那需要他人为再去更新状态
			}
			$this->success ( L ( '_SUCCESS_' ), '', $list );
		}else{
			$this->error ( L ( '_ERROR_' ) );
		}
	}
	
	public function lookupprojecttemplateupdate(){
		$subisfile = $_POST["subisfile"];
		$subremark = $_POST["subremark"];
		//dump($_POST);
		$masid = $_POST['masid'];//masid
		if($_POST['operateid']){
			//确定提交按钮
			$mis_project_attached_template_masDao = M("mis_project_attached_template_mas");
			$mis_project_attached_template_masDao->where('id = ',$masid)->setField("operateid",1);
			if ($_POST['projectid'] && $_POST['projectworkid']) {
				//变更项目任务状态
				$MSFFModel = D ( 'MisProjectFlowForm' );
				$MSFFModel->setWorkComplete ( $_POST ['projectworkid'] );
			}
		}
		$projectsubmodel = M ( "mis_project_attached_template_sub" );
		$subid = $_POST['subid'];//资料名称
		
		//获取详情数据ID
		$save_file=$_POST['swf_upload_save_name'];
		$source_file=$_POST['swf_upload_source_name'];
		
		foreach($subid as $key=>$val){
			$subdata['remark']=$subremark[$key];
			
			if($subisfile[$key]){
				$subdata['isfile']=$subisfile[$key];
			}else{
				//dump($key);
				$subdata['isfile']=0;
			}
			$subInfo=$projectsubmodel->where(array('id'=>$val))->save($subdata);
			if ($save_file[$val]) {
				//存在附件信息
				unset($_POST ['swf_upload_save_name']);
				unset($_POST ['swf_upload_source_name']);
				$_POST ['swf_upload_save_name'] = $save_file[$val];
				$_POST ['swf_upload_source_name'] = $source_file[$val];
				$this->swf_upload ( $masid, $val, 'MisProjectAttachedTemplate',$_POST['projectid'],$_POST ['projectworkid']);
			}
		}
		$this->success ( L('_SUCCESS_'));
	}
	
	
	public function attached_template_save() {
		$save_file=$_POST['swf_upload_save_name'];
		$data = $_POST["data"];
		$temp = array();
		$masid = $_POST["masid"];
		$model = D('MisProjectAttachedTemplateSub');
		$submodel = M("mis_project_attached_template_sub");
		$submap["masid"] = $masid;
		$items = $submodel->where($submap)->select();
		$dataIdList = array();
		$itemsIdList = array();
		$delIdList = array();
		foreach($data["id"] as $k1 => $v)
		{
			if(!empty($v))
			{
				$dataIdList[]=$v;
			}
		}
		foreach($items as $k2=> $v)
		{
			$itemsIdList[]=$v["id"];
		}
		$delIdList = array_diff($itemsIdList,$dataIdList);
		foreach($delIdList as $k3 => $v)
		{
			$where["id"] = $v;
			$submodel->where($where)->delete();
		}
			foreach ($data['orderno'] as $k =>$v){
				$subdata['masid']=$masid;
				$subdata['orderno']=$data['orderno'][$k];
				$subdata['name']=$data['name'][$k];
				$subdata['remark']=$data['remark'][$k];
				$subdata['type']=$data['type'][$k];
				$subdata['projectid']=$_REQUEST['projectid'];
				$subdata['projectworkid']=$_REQUEST['projectworkid'];
				$subdata['createid']=$_SESSION[C('USER_AUTH_KEY')];
				$subdata['createtime']=time();
				$subInfo=$submodel->add($subdata);
				$attModel = D("MisAttachedRecord");
				$attmap['tablename'] ='MisProjectAttachedTemplate';
				$attmap['tableid']=$masid;
				$attmap['subid']=$itemsIdList[$k];
				$attdata=array();
				$attdata['tablename'] ='MisProjectAttachedTemplate';
				$attdata['tableid']=$masid;
				$attdata['subid']=$subInfo;
				$attdata['updatetime'] = time();
				$attdata['updateid'] = $_SESSION[C('USER_AUTH_KEY')]?$_SESSION[C('USER_AUTH_KEY')]:0;
				$rel=$attModel->where($attmap)->save($attdata);
			}
		$this->success ( L('_SUCCESS_'));
	}
	
	public function lookupprojecttemplateadd23() {
		$name=$this->getActionName();
		$masModel=D($name);
		$masdata['orderno']=$_REQUEST['masorderno'];
		$masdata['name']=$_REQUEST['masname'];
		$masdata['remark']=$_REQUEST['masremark'];
		$masdata['projectid']=$_REQUEST['projectid'];
		$masdata['projectworkid']=$_REQUEST['projectworkid'];
		$masdata['createid']=$_SESSION[C('USER_AUTH_KEY')];
		$masdata['createtime']=time();
		$masInfo=$masModel->add($masdata);
		$data = $_POST["data"];
		$data['save_file']=$_POST['swf_upload_save_name'];
		$data['source_file']=$_POST['swf_upload_source_name'];
		$masid = $masInfo;
		$submodel = M("MisProjectAttachedTemplateSub");
		$submap["masid"] = $masid;
		$items = $submodel->where($submap)->select();
		$dataIdList = array();
		$itemsIdList = array();
		$delIdList = array();
			foreach($data["id"] as $k => $v)
			{
				if(!empty($v))
				{
					$dataIdList[]=$v;
				}
			}
			foreach($items as $k => $v)
			{
				$itemsIdList[]=$v["id"];
			}
			$delIdList = array_diff($itemsIdList,$dataIdList);
			foreach($delIdList as $k => $v)
			{
				$where["id"] = $v;
				$submodel->where($where)->delete();
			}
		foreach ($data['orderno'] as $k =>$v){
			$subdata['masid']=$masid;
			$subdata['orderno']=$data['orderno'][$k];
			$subdata['name']=$data['name'][$k];
			$subdata['remark']=$data['remark'][$k];
			$subdata['type']=$data['type'][$k];
			$subdata['projectid']=$_REQUEST['projectid'];
			$subdata['projectworkid']=$_REQUEST['projectworkid'];
			$subdata['createid']=$_SESSION[C('USER_AUTH_KEY')];
			$subdata['createtime']=time();
			$subInfo=$submodel->add($subdata);
			if(!empty($data['save_file'][$k])){
				$_POST['swf_upload_save_name']=array($data['save_file'][$k]);
				$_POST['swf_upload_source_name']=array($data['source_file'][$k]);
				$this->swf_upload($masid,false,$subInfo,'MisProjectAttachedTemplate');
			}
		}
		$this->success ( L('_SUCCESS_'));
	}
	
	public function lookupattched(){
		$masid=$_REQUEST['masid'];
		$id=$_REQUEST['id'];
		$recolist = $this->getAttachedRecordList($masid,true,true,"MisProjectAttachedTemplate",$id,false);
		if( ! empty($recolist)){
			foreach($recolist as $k => $v){
				$recolist[$k]["createdate"] = date("Y-m-d H:i:s",$v["createtime"]);
				$deptid = getFieldBy($v["createid"], "id", "dept_id", "user");
				$zhname = getFieldBy($v["createid"], "id", "zhname", "user");
				$recolist[$k]["userzhname"] = $zhname;
				$deptname = getFieldBy($deptid, "id", "name", "mis_system_department");
				$recolist[$k]["deptname"] = $deptname;
				if($deptname){
					$recolist[$k]["upuserinfo"] = $zhname."[".$deptname."]";
				}else{
					$recolist[$k]["upuserinfo"] = $zhname;
				}
				
			}	
		}
		$this->assign("recolist",$recolist);
		$this->display();
	}
	
	public function uploadtest() {
		$masid=$_POST['rel_masid'];
		$id=$_POST['rel_id'];
		$recolist = $this->getAttachedRecordList($masid,true,true,"MisProjectAttachedTemplate",$id,false);
		if( ! empty($recolist)){
			foreach($recolist as $k => $v){
				$recolist[$k]["createdate"] = date("Y-m-d H:i:s",$v["createtime"]);
				$deptid = getFieldBy($v["createid"], "id", "dept_id", "user");
				$zhname = getFieldBy($v["createid"], "id", "zhname", "user");
				$recolist[$k]["userzhname"] = $zhname;
				$deptname = getFieldBy($deptid, "id", "name", "mis_system_department");
				$recolist[$k]["deptname"] = $deptname;
				if($deptname){
					$recolist[$k]["upuserinfo"] = $zhname."[".$deptname."]";
				}else{
					$recolist[$k]["upuserinfo"] = $zhname;
				}
	
			}
		}
		$list = $_POST["list"]?$_POST["list"]:array();
		$recolist = $recolist?$recolist:array();
		$list = array_merge($recolist,$list);
		$this->assign("recolist",$recolist);
		$this->assign("objId",$_POST["id"]);
		$this->assign("list",$list);
		$this->display('MisProjectAttachedTemplate:uploadtest');
	}
}
?>