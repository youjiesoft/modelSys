<?php
/**
 * @Title: MisRequestCarManage 
 * @Package package_name 
 * @Description: todo(派车查看) 
 * @author libo 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-12-5 下午5:53:48 
 * @version V1.0
 */
class MisRequestCarManageAction extends CommonAction {
	public function index() {
		//获取左侧树
		$this->getcarTree();
		//列表过滤器，生成查询Map对象
		$map = $this->_search ('MisRequestCarManage');
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name = "MisRequestCar";
		//查询审核已通过的
		$map['auditState']=3;
		//判断显示未派和已派
		$map['issendcar']=1;
		if($_REQUEST['issendcar']==1){
			$map["issendcar"]=1;
		}
		if($_REQUEST['issendcar']==2){
			$map['issendcar']=2;
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
		$scdmodel = D('SystemConfigDetail');
		$detailList = $scdmodel->getDetail('MisRequestCarManage');
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
		//扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		//首页收件箱调用方法，为ajax调用
		if ($_GET['type'] == "ajaxcall") {
			$this->display ("ajax_index");exit;
		}
		//首页跳转验证
		$this->assign('issendcar', $_REQUEST['issendcar']);
		if ($_REQUEST['jump']) {
			$this->display ("indexview");exit;
		}
		$this->assign('issendcar',$map['issendcar']);
		$this->display ();
	}
	public function edit() {
		$name="MisRequestCar";
		$model = D ( $name );
		$id = $_REQUEST ['id'];
		$map['id']=$id;
		if ($_SESSION["a"] != 1) $map['status'] = 1;
		$vo = $model->where($map)->find();
		if(empty($vo)){
			$this->display ("Public:404");
			exit;
		}
		//读取动态配制
		$this->getSystemConfigDetail($name);
		//扩展工具栏操作
		$scdmodel = D('SystemConfigDetail');
		$toolbarextension = $scdmodel->getSubDetail($modelname,true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		// 上一条数据ID
		$map['id'] = array("lt",$id);
		$updataid = $model->where($map)->order('id desc')->getField('id');
		$this->assign("updataid",$updataid);
		// 下一条数据ID
		$map['id'] = array("gt",$id);
		$downdataid = $model->where($map)->getField('id');
		$this->assign("downdataid",$downdataid);
		//判断系统授权
		//$vo=$this->process_filter($vo);
		//lookup带参数查询
		$module=A($name);
		if (method_exists($module,"_after_edit")) {
			call_user_func(array(&$module,"_after_edit"),&$vo);
		}
		$this->assign( 'vo', $vo );
		$this->display ();
	}
	public function update(){
		$name="MisRequestCar";
		$model = D ( $name );
		if (false === $model->create ($data)) {
			$this->error ( $model->getError () );
		}
		// 更新数据
// 		$data['use_status'] = 1;
		$list=$model->save ($data);
		//反写数据 drict yuansl
		$models = D("MisSystemCar");
		 $datas['use_statime'] = $_REQUEST['departureTime'];//发车时间
		$datas['use_endtime'] = $_REQUEST['expectRestitutionTime'];//预计还车时间
		$datas['id'] = $_REQUEST['carID'];//车辆ID;
		if (false !== $list) {
			$models->save($datas);
			$module2=A($name);
			if (method_exists($module2,"_after_update")) {
				call_user_func(array(&$module2,"_after_update"),$list);
			}
			//邮件发送(根据派车管理的逻辑,修改人就是派车人) yuansl 2014 07 29
				$name = "MisRequestCar";
				$createid = getFieldBy($_REQUEST['id'], 'id', 'createid', $name);
				$modelname = $name;
				$this->sendcarmessage($createid,$modelname,$_REQUEST['id'],2);
		
			$this->success ( L('_SUCCESS_'));
		} else {
			$this->error ( L('_ERROR_') );
		}
	}
	
	public function _before_edit(){
		$MisRequestCarModel=D('MisRequestCar');
		$MisRequestCarList=$MisRequestCarModel->where("status=1 and id=".$_REQUEST['id'])->find();
		$issendcar=$MisRequestCarList['issendcar'];
		$this->assign("issendcar",$issendcar);
	}
	public function getcarTree(){
		$tree = array(); // 树初始化
		$tree[] = array(
				'id' => 1,
				'pId' => 0,
				'name' => '派车情况',
				'title' => '派车情况',
				'open' => true
		);
		$tree[] = array(
				'id' => 2,
				'pId' => 1,
				'name' => '未派',
				'title' => '未派',
				'rel' => "misrequestcarviewtype",
				'target' => 'ajax',
				'icon' => "",
				'url' => "__URL__/index/issendcar/1/jump/1",
				'open' => true
		);
		$tree[] = array(
				'id' => 3,
				'pId' => 1,
				'name' => '已派',
				'title' => '已派',
				'rel' => "misrequestcarviewtype",
				'target' => 'ajax',
				'icon' => "",
				'url' => "__URL__/index/issendcar/2/jump/2",
				'open' => true
		);
		$this->assign("tree",json_encode($tree));
	}
	public function lookupGeneral(){
		//获取查找带回的字段
		$this->assign("field",$_REQUEST['field']);
		$_POST['dealLookupList'] = 1;//强制查找带回重构数据列表
		$name = $_POST['model'];
		//获取部门类型 ————快捷新增客户
		$deptid=$_REQUEST['deptid'];
		$this->assign("deptid",$deptid);
		if(strpos($name, '_')){//将表转换为model
			$nameArr = explode('_', $name);
			$names = "";
			foreach ($nameArr as $k => $v) {
				$names .= ucfirst($v);
			}
			if($names){
				$name = $names;
			}
		}
		if(substr($name, -4)=="View"){
			$qx_name = $name;
			$name = substr($name,0, -4);
		}
		$this->assign("model",$name);
		// 单据号是否可写
		$table = D($name)->getTableName();
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable($table);
		$this->assign("writable",$writable);
	
		$ConfigListModel = D('SystemConfigList');
		$lookupGeneralList = $ConfigListModel->GetValue('lookupGeneralInclude');// 快速新增配置列表
		$include = $lookupGeneralList[$name];//获取配置信息
		$layoutH = 96;//默认高度
		if($include){
			$layoutH = $include['layoutH'];//获取高度
			$this->assign("tplName",'LookupGeneral:'.$include['tpl']);//设置默认模版
			$this->assign("isauto",$include['isauto']);//设置编号自动生成
		}
		$this->assign("layoutH",$layoutH);//设置高度
		$scdmodel = D('SystemConfigDetail');
		$detailList = $scdmodel->getDetail($name);
		if ($detailList) {
			$inArray = array('action','remark','status');
			if ($_REQUEST['filterfield']) {
				$filterfield = explode(',', $_REQUEST['filterfield']);
				$inArray = array_merge($inArray,$filterfield);
			}
			foreach ($detailList as $k => $v) {
				if(in_array($v['name'], $inArray)){
					unset($detailList[$k]);
				}
			}
			$this->assign ( 'detailList', $detailList );
		}
// 		$action=A("Common");
		$action = $this;
		$map = $this->_search($name);
		$conditions = $_POST['conditions'];// 检索条件
		if($conditions){
			$this->assign("conditions",$conditions);
			$cArr = explode(';', $conditions);//分号分隔多个参数
			foreach ($cArr as $k => $v) {
				$wArr = explode(',', $v);//逗号分隔字段、参数、修饰符
				if ($wArr[0] == "_string") { // 判断是否传的为字符串条件
					$map['_string'] = $wArr[1];
				} else {
					if ($wArr[2]) {//存在修饰符的以修饰符形式进行检索
						$map[$wArr[0]] = array($wArr[2],$wArr[1]);
					} else {//普通检索
						$map[$wArr[0]] = $wArr[1];
					}
				}
			}
		}
		$map['status'] = 1;
		$filterfield = "_lookupGeneralfilter";
		if($_REQUEST['filtermethod']) $filterfield = $_REQUEST['filtermethod'];
		if (method_exists($this,$filterfield)) {
			call_user_func(array(&$this,$filterfield),&$map);
		}
// 		dump($this);
// 		dump($name);
		$action->_list ( $name, $map );
		$this->display();
	}
	/**
	 * @Title: _after_list
	 * @Description: todo(处理带回车辆时候标红的一行显示效果)
	 * @param unknown_type $volist
	 * @author yuansl
	 * @date 2014-7-17 下午4:15:32
	 * @throws
	 */
	public function _after_list(&$volist){
		//获取到车辆id 查询  如果这辆车在当前时间已经再使用则新组合一个字段进入$volist isBusy
		$newvolist = array();
		foreach($volist as $val){
			$temp = $this->is_busy($val['id']);
			$val['isBusy'] = $temp['isBusy'];
			$val['orderid'] = $temp['orderid'];
			array_push($newvolist,$val);
		}
		$this->assign('list1',$newvolist);
	}
	/**
	 * @Title: is_busy
	 * @Description: todo(判断在当前时间 改车辆是否正在被使用,如果在使用返回1,未使用返回0)
	 * @param string $carID
	 * @author yuansl
	 * @date 2014-7-17 下午4:38:04
	 * @throws
	 */
	private function is_busy($carID){
		if(!$carID){
			return false;
		}
		$time = time();
		$modelcarModel = D("MisSystemCar");
		$modelcarRequestModel = D("MisRequestCar");
		$misCarReturnModel = D("MisCarReturn");
		//$re = $modelcarModel->where("status = 1 and id = ".$carID)->find();
// 		if(!$re){
// 			$this->error("请确认改车辆是否存在!");
// 			exit;
// 		}
		$mapx['departureTime'] = array('elt',$time);//开始时间小于当前时间
		$mapx['expectRestitutionTime'] = array('egt',$time);//结束时间大于当前时间
		$mapx['status'] = array('gt',0);//
		$mapx['auditState'] = array('eq',3);//审核通过的
		// 并且是已经派过车的  且车没有正在被使用
// 		$mapx['returnTag'] = array('neq',1);
		$mapx['carID'] = array('eq',$carID);
		$rex = $modelcarRequestModel->where($mapx)->field("id,carID")->find();
		//是否还车
		//取申请单里里面该车辆的最后一条数据,根据这个申请单id,在还车列表里面查询,如有一条记录,则证明该车已经还了,则不变红.
		$is_use = $misCarReturnModel->where("status = 1 and roid = ".$rex['id'])->find();
		if($rex && !$is_use){
			return array('isBusy'=>1,"orderid"=>$rex['id']);
		}else{
			return array('isBusy'=>0);
		}
	}
	/**
	 * @Title: sendcarmessage 
	 * @Description: todo(派车之后邮件发送) 
	 * @param unknown_type $sendidArr
	 * @param unknown_type $modelName
	 * @param unknown_type $tableid
	 * @param unknown_type $noticeType  
	 * @author yuansl 
	 * @date 2014-7-29 上午10:37:05 
	 * @throws
	 */
	public function sendcarmessage($sendidArr,$modelName,$tableid,$noticeType){
		//派车人
		$sendcarid = getFieldBy($tableid, 'id', 'updateid', $modelName);
		$sendcarname = getFieldBy($sendcarid, 'id', 'name', "User");
		$model 		= D('SystemConfigDetail');
		$nodeModel = M('node');
		//通过modelname查找到对应的模块中文名
		$modelNameChinese = $nodeModel->where("name='".$modelName."'")->getField("title");
		//通过modelname查找到对应的单据名称
		$orderInfoname = D($modelName)->where("id='".$tableid."'")->field("name")->find();
		$ordername=$orderInfoname['name'];
		//获取制单人
		$createid=D($modelName)->where("id='".$tableid."'")->getfield("createid");
		$createname=getFieldBy($createid, 'id', 'name', "user");
		//通过modelname查找到对应的单据编号
		$orderInfo = D($modelName)->where("id='".$tableid."'")->field("orderno")->find();
		if($orderInfo){
			$orderno=$orderInfo['orderno'];
		}else{
			$orderInfo= D($modelName)->where("id='".$tableid."'")->field("code")->find();
			$orderno=$orderInfo['code'];
		}
		//知会还是执行
		if($noticeType=="1"){
			$noticeTypeName="工作知会：";
			$noticeUrl='<a class="edit" style="text-decoration:underline" title="工作中心" target="navTab" rel="MisWorkExecuting" href="__APP__/MisWorkExecuting/index/jump/6/md/'.$modelName.'/tableid/'.$tableid.'">' . $orderno . '</a>';
		}else{
			$worksetmodel=M("mis_work_executing_set");
			$typeid=$worksetmodel->where("name='".$modelName."'")->getField("typeid");
			$Nameid=$worksetmodel->where("name='".$modelName."'")->getField("id");
			$noticeTypeName="工作中心：";
			$noticeUrl='<a class="edit" style="text-decoration:underline" title="工作中心" target="navTab" rel="MisWorkExecuting" href="__APP__/MisWorkExecuting/index/jump/4/md/'.$modelName.'/typeid/'.$typeid.'/dotype/0/rel/'.$modelName.'_'.$Nameid.'/tableid/'.$tableid.'">' . $orderno . '</a>';
		}
		$modelNameChineseUrl='<a class="" style="text-decoration:underline" title="'.$modelNameChinese.'" target="navTab" rel="'.$modelName.'" href="__APP__/'.$modelName.'/index">'.$modelNameChinese.'</a>';
		//发送的系统日志的标题
		$messageTitle =$noticeTypeName.$modelNameChinese.' 单据号为  '.$orderno.' 的单据 '.$ordername.'已经派车成功，请关注！';
		//message信息拼装
		$messageContent="";
		$messageContent.='
			<p></p>
			<span></span>
			<div style="width:98%;">
				<p class="font_darkblue">您好！</p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;'. $modelNameChinese.' 单据号为  '.$orderno.' 的单据 '.$ordername.' 已经派车成功! </p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;单据的详细情况：</p>
				<ul>
					<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>单据系统：</strong>' . $modelNameChineseUrl . '
					</li>
					<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>单据编号：</strong>'.$noticeUrl.'
				</ul>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;如果您有任何问题，请联系派车人：' . $sendcarname . '。</p>
			</div>';
		//从动态配置获取到数据信息
		$result=$model->GetDynamicconfData($modelName,$tableid);
		//print_R($result);
		foreach($result as $key => $val){
			//初始化一个字符串容器
			$tmpstring="";
			foreach($val as $subkey => $subval){
				$tmpstring=$subkey.'：</b>'.$subval;
			}
			$messageContent.='<b class="t-gre1">'.$tmpstring.'<br/>';
		}
		//开始附件头部拼接
		$messageContent.='<div class="xyMessageAttach"><div style="padding:6px 10px 6px 8px;"><div class="attach left"></div><strong>附件：</strong></div><div class="xyMessageAttachItems">';
		//声明相关附件表
		$modelMAR = M('MisAttachedRecord');
		//获取附件信息
		$num=1;
		$map = array();
		$map["status"]  =1;
		$map["tableid"] =$tableid;
		$map["tablename"] =$modelName;
		$attarry=$modelMAR->field("id,upname,attached")->where($map)->select();
		if($attarry){
			foreach($attarry as $attkey => $attval){
				//下载路径
				$downloadName=__URL__."/misFileManageDownload/path/".base64_encode($attval['attached'])."/rename/".$attval['upname'];
				//归档路径
				$stockName=__APP__."/MisMessageInbox/lookupDocumentCollateAtta/t/0/id/".$attval['id'];
				//附件名称拼接
				$messageContent.='<div class="xyMessageAttachItem"><span class="tml-label tml-bg-orange tml-mr5">附件'.$num.'</span>';
				$messageContent.='</span><a class="attlink" rel="'.$attval['id'].'" target="_blank" href="'.$downloadName.'"><span>'.$attval['upname'].'</span>';
				$messageContent.='<a class="tml-btn tml-btn-small tml-btn-green" href="'.$stockName.'" title="文件归档" target="dialog"><span class="tml-icon tml-icon-file"></span><span class="tml-icon-text">归档</span></a></div>';
				$num++;
			}
		}
		//开始附件尾部拼接
		$messageContent.='</div></div>';
		//系统推送消息
		if(!is_array($sendidArr)){
			$sendidArr=array($sendidArr);
		}
		$messageexecuting=array();
		if($noticeType){
			$messageexecuting=array('tableid'=>$tableid,'tablename'=>$modelName,"noticeType"=>$noticeType);
		}
		$this->pushMessage($sendidArr, $messageTitle, $messageContent,'','','',$messageexecuting);
	}
}
?>