<?php
/**
 * @Title: MisSalesCustomerAction
 * @Package package_name
 * @Description: todo(客户信息)
 * @author laicaixia
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-5-31 下午3:47:42
 * @version V1.0
 */
class MisSalesCustomerAction extends CommonAction{
	/**
	 * @Title: _empty
	 * @Description: todo(判断页面是否存在)
	 * @author laicaixia
	 * @date 2013-5-31 下午3:50:52
	 * @throws
	 */
	public function _empty(){
		$this->error("您访问的页面不存在！");
	}
	/**
	 * @Title: _filter
	 * @Description: todo(检索)
	 * @param 检索列表 $map
	 * @author laicaixia
	 * @date 2013-5-31 下午3:53:24
	 * @throws
	 */
	public function _filter(&$map){
		if ($_SESSION["a"] != 1) $map['status']=array("gt",-1);
		//第一步构造左侧树结构
		if ($_REQUEST['typeid']) {
			$map['typeid']=$_REQUEST['typeid'];
			$this->assign("typeid",$_REQUEST['typeid']);
		}
	}
	private function getSelectList(){
		$selectlist = require DConfig_PATH."/System/selectlist.inc.php";
		$this->assign("county",$selectlist['county']['county']);
		$this->assign("clientsource",$selectlist['clientsource']['clientsource']);
	}
	public function index(){
		$this->getSelectList();
		//第一步，获取读取的配置文件列表
		$name=$_REQUEST['md']?$_REQUEST['md']:'MisSalesCustomer';
		$this->assign('md',$name);
		//第二步构造检索配置
		$map = $this->_search ($name);
		//获取客户类型
		$treeNode=$this->getlefttree();
		$this->assign('typeTree',json_encode($treeNode));
		
		//订单号可写
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable('mis_sales_customer');
		$this->assign("writable",$writable);
		$code = $scnmodel->GetRulesNO('mis_sales_customer');
		$this->assign("code", $code);
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		//构造明细
		$this->getSystemConfigDetail($name);
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
		
		$model = D($name);
		if($_POST['search_flag'] == 1){
			$this->setAdvancedMap($map);
		}
		if($_SESSION['MisSalesCustomer_updateid']) {
			$id = $_SESSION['MisSalesCustomer_updateid'];
			unset($_SESSION['MisSalesCustomer_updateid']);
			$vo = $model->where("id=".$id)->find();
		} else {
			$vo = $model->where($map)->order('id desc')->find();
		}
		if($vo){
			//获取附件信息
			$this->getAttachedRecordList($vo['id']);
		}
		$this->assign( 'vosoft', $vo );
		
		$scdmodel = D('SystemConfigDetail');
		$detailList = $scdmodel->getDetail($name);
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		//首页跳转验证
		if ($_REQUEST['jump']) {
			$this->display ("indexview");exit;
		}
		$this->display ();
		return;
	}
	/**
	 * @Title: diffTreeNode 
	 * @Description: todo(根据权限控制 显示部门类型)   
	 * @author renling 
	 * @date 2013-10-29 下午3:54:17 
	 * @throws
	 */
	private function diffTreeNode(){
		//第一步构造左侧树结构
		$treeNode=$this->getlefttree();
		$QZArr = array();
		foreach($treeNode as $key=>$val){
			if($val['type']){
				$QZArr[$val['id']] =$val['QZcode'];
			}
		}
		return $QZArr;
	}
	/**
	 * @Title: _before_add
	 * @Description: todo(进入新增)
	 * @author laicaixia
	 * @date 2013-5-31 下午3:54:25
	 * @throws
	 */
	public function _before_add(){
		if($_REQUEST['manage']){//经营状态
			$this->assign("customerid",$_REQUEST['customerid']);
			$this->display("addBusiness");
			exit;
		}
		$typeid = $_REQUEST['typeid'];
		if($typeid){
			$arr = explode(",", $typeid);
		}
		$QZArr=$this->diffTreeNode();
		$qzcode="";
		$qzid = 0;
		foreach($QZArr as $key=>$val){
			if($key == $arr[0]){
				//获取第一个默认的部门code前缀
				$qzcode=$val;
				$qzid=$key;
			}
		}
		if($qzid){
			$type = 'typeid = '.$qzid;
			$this->assign('selecttypeid',$qzid);
		}
		//查询客服类型
		$typeModel=M("mis_sales_customertype");
		$typeList=$typeModel->where("status=1")->select();
		$this->assign("typeList",$typeList);
		//订单号可写
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable('mis_sales_customer');
		$this->assign("writable",$writable);
		$code = $scnmodel->GetRulesNO('mis_sales_customer');
		$this->assign("code", $code);
		$this->lookcommon();
	}
	
	public function lookupChageCode(){
		//获取部门类型
		$vals=$_REQUEST['val'];
		//获取类型
		$QZArr=$this->diffTreeNode();
		$qzcode="";
		foreach($QZArr as $key=>$val){
			if($key == $vals){
				$qzcode = $val;
			}
		}
		if($vals){
			$type = 'typeid = '.$vals;
		}
		//订单号可写
		$scnmodel = D('SystemConfigNumber');
		$code = $scnmodel->GetRulesNumber('mis_sales_customer','code',$type,'',$qzcode);
		echo $code;
	}
	
	
	/**
	 * @Title: _before_insert
	 * @Description: todo(执行新增前置函数)
	 * @author laicaixia
	 * @date 2013-5-31 下午3:53:48
	 * @throws
	 */
	public function _before_insert(){
		//新增 经营状况
		if($_REQUEST['managestatus']){
			$managestatusModel=D("MisManageStatus");
			if (false === $managestatusModel->create ()) {
				$this->error ( $managestatusModel->getError () );
			}
			//保存当前数据对象
			$re=$managestatusModel->add ();
			if($re===false){
				$this->error("添加经营状况失败");
			}else{
				$this->success("操作成功");
			}
			exit;
		}
		$_POST['enterpriseserve']=implode(",", $_POST['enterpriseserve']);
		//查询编号
		$this->checkifexistcodeororder("mis_sales_customer", "code");
	}
	public function _after_insert($id) {
		if ($id) {
			$this->swf_upload($id);
		}
	}
	public function _before_edit(){
		if($_REQUEST['manage']){//经营状态
			$mangeModel=D("MisManageStatus");
			$list=$mangeModel->where("id=".$_REQUEST['id'])->find();
			$this->assign("vo",$list);
			$this->display("editBusiness");
			exit;
		}
		$this->diffTreeNode();
		$this->lookcommon();
	}
	public function _after_edit(&$vo){
		//获取附件信息
		$this->getAttachedRecordList($vo['id']);
		
		$this->assign( 'vosoft', $vo );
		if($_REQUEST['salecustomer']){
			$this->display("lookupedit");
			exit;
		}
	}
	function lookcommon(){
		//当前时间
		$this->assign('now', time());
		$this->getSelectList();
	}
	
	
	/**
	 * @Title: lookupLinkTel
	 * @Description: todo(客户联系人信息)
	 * @author renling
	 * @date 2013-7-8 下午1:38:53
	 * @throws
	 */
	public function lookupLinkTel(){
		$CrmCustEmployeeModel=D('CrmCustEmployee');
		$map = $this->_search('CrmCustEmployee');
		$id=$this->escapeStr($_GET['id']); //客户ID
		$this->assign('id',$id);
		$map['customerid']=$id;
		$map['status']=1;
		if($_POST['subsearch_flag'] == 1){
			$this->setAdvancedMap($map,1);
		}
		$this->_list('CrmCustEmployee', $map);
		$this->display();
	}
	
	/**
	 * @Title: _before_update
	 * @Description: todo(执行修改)
	 * @author laicaixia
	 * @date 2013-5-31 下午4:04:43
	 * @throws
	 */
	function _before_update() {
		//修改 经营状况
		if($_REQUEST['managestatus']){
			$managestatusModel=D("MisManageStatus");
			if (false === $managestatusModel->create ()) {
				$this->error ( $managestatusModel->getError () );
			}
			//保存当前数据对象
			$re=$managestatusModel->save ();
			if($re===false){
				$this->error("修改经营状况失败");
			}else{
				$this->success("操作成功");
			}
			exit;
		}
		//上传附件
		$this->swf_upload($_POST['id']);
		
		$_POST['enterpriseserve']=implode(",", $_POST['enterpriseserve']);
		$_SESSION['MisSalesCustomer_updateid'] = $_POST['id'];
	}
	/**
	 * @Title: lookupBank
	 * @Description: todo(查找带回银行账户)
	 * @author laicaixia
	 * @date 2013-6-2 上午9:13:22
	 * @throws
	 */
	public function lookupBank() {
		$cookie_bankid=Cookie::get('MisSalesCustomerFinanceedit');
		$searchby=array(
				array("id" =>"name","val"=>"按银行名称"),
				array("id" =>"sname","val"=>"按开户姓名")
		);
		$searchtype=array(
				array("id" =>"2","val"=>"模糊查找"),
				array("id" =>"1","val"=>"精确查找")
		);
		$this->assign("searchtypelist",$searchtype);
		$this->assign("searchbylist",$searchby);
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
		/*必须先带客户的条件才能查询其他条件*/
		if( $cookie_bankid ){
			$map["bankid"]=array(" in ",$cookie_bankid);
			$this->assign("bankid",$map["bankid"]);
		}
		$name = "MisFinanceBankAccount";
		$map['status'] = 1;
		$action=A("Common");
		$action->_list ( $name, $map );
		$this->display();
	}
	/**
	 * @Title: lookupCrm
	 * @Description: todo(查找带回客户)
	 * @author laicaixia
	 * @date 2013-5-31 下午4:09:07
	 * @throws
	 */
	function lookupCrm(){
		import ( '@.ORG.Tree');
		$tree = new Tree();
		$model=D("CrmCustEmployee");
		$cid=$_REQUEST['cid'];
		$list=$model->where("customerid='".$cid."'")->select();
		$datearr=array();
		foreach($list as $k=>$val){
			$datearr[$val['id']]['id']=$val['id'];
			$datearr[$val['id']]['name']=$val['name'];
			$datearr[$val['id']]['dup']=$val['dup'];
			$datearr[$val['id']]['data']="{}";
		}
		$tree->tree($datearr);
		$list=$tree->get_treearr();
		$this->assign("jsontree1", json_encode($list[0]));
		$this->assign("custmentid", $cid);
		$this->display();
	}
	/**
	 +----------------------------------------------------------
	 * 默认删除操作
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	public function delete() {
		//删除指定记录
		$name=$this->getActionName();
		if($_REQUEST['manage']){
			$name="MisManageStatus";
		}
		$model = D ($name);
		if (! empty ( $model )) {
			$pk = $model->getPk ();
			$id = $_REQUEST [$pk];
			if (isset ( $id )) {
				$condition = array ($pk => array ('in', explode ( ',', $id ) ) );
				if($_SESSION['a']){
					$condition["status"] = array ("eq",-1);
					$list=$model->where ( $condition )->delete();
					$condition["status"] = array ("neq",-1);
				}
				$list=$model->where ( $condition )->setField ( 'status', - 1 );
				if ($list!==false) {
					$this->success ( L('_SUCCESS_') );
				} else {
					$this->error ( L('_ERROR_') );
				}
			} else {
				$this->error ( C('_ERROR_ACTION_') );
			}
		}
	}
	public function loss(){
		if($_REQUEST['jump']){
			$name=$this->getActionName();
			$model = D ($name);
			if (! empty ( $model )) {
				$condition['id'] = $_REQUEST['id'];
				$list=$model->where ( $condition )->setField ( 'lossstatus', 1 );
				if ($list!==false) {
					$this->success ( L('_SUCCESS_') );
				} else {
					$this->error ( L('_ERROR_') );
				}
			} else {
				$this->error ( C('_ERROR_ACTION_') );
			}
		} else {
			$this->display();
		}
	}
	/**
	 * @Title: getlefttree 
	 * @Description: todo(获取客户类型) 
	 * @return multitype:number string boolean multitype:number string boolean    
	 * @author liminggang 
	 * @date 2014-7-23 下午1:54:47 
	 * @throws
	 */
	public function getlefttree(){
		$MisSalesCustomertypeModel=D("MisSalesCustomertype");
		$typeList=$MisSalesCustomertypeModel->where("status=1")->select();
		$tree[]=array(
				'id'=>99999,
				'pId'=>-1,
				'name'=>'企业客户',
				'rel'=>'misSalesCustomerTreeBox',
				'target'=>'ajax',
				'title'=>'企业客户',
				'url'=>'__URL__/index/md/MisSalesCustomer/jump/1',
				'open'=>true,
				'md'=>'MisSalesCustomer',
		);
		$tree[]=array(
				'id'=>99998,
				'pId'=>-1,
				'name'=>'个人客户',
				'rel'=>'misSalesCustomerTreeBox',
				'target'=>'ajax',
				'title'=>'个人客户',
				'url'=>'__URL__/index/md/MisSalesCustomerPerson/jump/1',
				'open'=>true,
				'md'=>'MisSalesCustomerPerson',
		); 
		$treenode = array();
		foreach($tree as $k=>$v){
			foreach($typeList as $key=>$val){
				$treenode[] = array(
					'id' => $val['id'],
					'pId' => $v['id'],
					'type'=>1,
					'QZcode'=>$val['code'],
					'name' =>$val['name'],
					'title' =>$val['name'],
					'rel' => "misSalesCustomerTreeBox",
					'target' => 'ajax',
					'url' => "__URL__/index/md/".$v['md']."/typeid/".$val['id']."/jump/1",
					'open' => true
				);
			}
		}
		if($treenode){
			$tree=array_merge($tree,$treenode);
		}
		return $tree;
		
	}
	public function lookupBusiness(){
		$MisManageStatusModel=D('MisManageStatus');
		$map = $this->_search('MisManageStatus');
		$id=$this->escapeStr($_GET['id']); //客户ID
		$this->assign('id',$id);
		$map['customerid']=$id;
		if(!$_SESSION['a']){
			$map['status']=1;
		}
		if($_POST['subsearch_flag'] == 1){
			$this->setAdvancedMap($map,1);
		}
		$this->_list('MisManageStatus', $map);
		$this->display();
	}
	public function lookupTrack(){
		$map = $this->_search('MisSalesCustomerTrack');
		$id=$this->escapeStr($_GET['id']); //客户ID
		$category=$this->escapeStr($_GET['category']); //客户ID
		$this->assign('category',$category);
		$this->assign('id',$id);
		$map['customerid']=$id;
		if(!$_SESSION['a']){
			$map['status']=1;
		}
		if($_POST['subsearch_flag'] == 1){
			$this->setAdvancedMap($map,1);
		}
		$scdmodel = D('SystemConfigDetail');
		$detailList = $scdmodel->getDetail("MisSalesCustomerTrack");
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
		$map['category'] = $category;
		$this->_list('MisSalesCustomerTrack', $map);
		$this->display();
	}
}
?>
