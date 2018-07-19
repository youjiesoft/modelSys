<?php
/**
 * @Title: MisSalesProjectCoreAction 
 * @Package package_name
 * @Description: todo(项目管理 里的项目纵览父类) 
 * @author xiafengqin 
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2013-6-1 上午9:31:36 
 * @version V1.0
 */
class MisSalesProjectCoreAction extends CommonAction {
	//防止明文传模型 在这里做一个键值对，暗码传参
	protected $arr = array(
			'pwr'=>'MisProjectWeekReport',//项目周报
			'psay'=>'MisProjectScheduleAnalysis',//阶段进度分析
			'pqay'=>'MisProjectQualityAnalysis', //阶段质量分析
			'pcay'=>'MisProjectCostAnalysis',//阶段进度分析
			'pmm'=>'MisProjectMilestoneMas',//项目里程碑
			'pmam'=>'MisProjectMaterialApplicationMas',//项目物质申请
			'pmr'=>'MisProjectMeasureReport',//工程量申报表
			'ppm'=>'MisProjectPaymentMas',//工程进度款审批
			'pcm'=>'MisProjectCloseoutMas',//工程结算款审批
			'FBWS'=>'MisFinanceBorrowmas',//工程结算款审批
		);
	/**
	 * @Title: _empty
	 * @Description: todo(判断页面是否存在函数)
	 * @author xiafengqin
	 * @date 2013-6-1 上午9:32:48
	 * @throws
	 */
	public function _empty() {
		//空操作
		$this->error("您访问的页面不存在！");
	}
	/**
	 * @Title: _filter
	 * @Description: todo(构造检索条件)
	 * @param unknown_type $map
	 * @author xiafengqin
	 * @date 2013-6-1 上午9:33:36
	 * @throws
	 */
	public function _filter(&$map){
		//判定是否为超级管理员
		if ($_SESSION["a"] != 1){
			$map['status']=1;
			//项目特殊权限控制
			$projectarr=$this->getPeculiarWhere();
			if($projectarr){
				$map['id'] = array(' in ',$projectarr);
			}
		}
	}
	/**
	 * @Title: index
	 * @Description: todo(TPL的index，主页面)
	 * @author xiafengqin
	 * @date 2013-6-1 上午9:34:12
	 * @throws
	 */
	public function index() {
		//查询当前用户设置默认进入界面
		/* $userModel=D('user');
		$userMap['status']=1;
		$userMap['id']=$_SESSION[C('USER_AUTH_KEY')];
		$userprojectdefset=$userModel->where($userMap)->getField("projectdefset");
		$this->assign("userprojectdefset",$userprojectdefset); */
		//执行区域树
		$this->getZtreelist();
		
		$siteid = $_REQUEST['siteid'];
		$executiontypeid = $_REQUEST['executiontypeid'];
		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		if(isset($siteid)){
			$map['siteid'] = $siteid;
		}
		if($executiontypeid){
			$map['executiontypeid'] = $executiontypeid;
		}
		$this->assign('executiontypeid',$executiontypeid);
		$this->assign('siteid',$siteid);
		$name = $this->getActionName();
		if (! empty ( $name )) {
			$this->_list ( $name, $map );
		}
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
		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		//判断进入的执行，或者审核，是否存在可以操作的模块
		$sclmodel = D('SystemConfigList');
		$mdarr = $sclmodel->getProjectMyWork();
		$stepAdd = 0; //默认为无执行权限
		$stepAuditProcess = 0; //默认为无审核权限
		if($mdarr){
			foreach($mdarr as $key=>$val){
				if($val['pId'] != 0){
					//第一步，判断当前模块是否有操作权限
					$md_add = strtolower($val['md'])."_add";
					//审核权限
					$md_auditProcess = $val['md']."_auditProcess";
					if($_SESSION[$md_add] || $_SESSION['a']){
						//有新增操作权限。
						if($stepAdd == 0){
							//默认只进入一次
							$stepAdd = 1;
						}
					}
					if($_SESSION[$md_auditProcess] || $_SESSION['a']){
						//有新增操作权限。
						if($stepAuditProcess == 0){
							//默认只进入一次
							$stepAuditProcess = 2;
						}
					}
				}
			}
		}
		$this->assign('stepAdd',$stepAdd);
		if ($_REQUEST['jump']) {
			if($_REQUEST['indexlist']){
				$this->assign("indexlist",$_REQUEST['indexlist']);
				$this->display('depindex');
			}else{
				$this->display('indexList');
			}
		} else {
			$this->display();
		}
		return;
	}
	/**
	 * @Title: getZtreelist
	 * @Description: todo(生成项目管理首页区域树方法)
	 * @author liminggang
	 * @date 2014-4-22 下午5:41:46
	 * @throws
	 */
	private function getZtreelist(){
		//实例化项目纵览的表
		$mModel = D('MisSalesProject');
	
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		//获得项目的启用状态
		$mExecutioTypeModel = D('MisExecutionType');
		$ExecutioTypeList = $mExecutioTypeModel->where('typeid = 01 and status = 1')->order('sort ASC')->field("id,name")->select();
		$treeNode = array();
		foreach ($ExecutioTypeList as $k=>$v) {
			//判断项目启动状态
			$map['executiontypeid'] = $v['id'];
			//$map['siteid'] = array('gt',0);
			$list = $mModel->where ($map)->field("id,siteid")->select();
			$count = count($list);
			$arr = array();
			foreach($list as $key=>$val){
				if($val['siteid']>0){
					$list[$key]['name'] = getFieldBy($val['siteid'],'id','name','MisSalesSite');
					if(in_array($val['siteid'],$arr)){
						unset($list[$key]);
					}else{
						array_push($arr, $val['siteid']);
					}
				}else{
					unset($list[$key]);
				}
			}
			$list[] = array(
					'id'=>0,
					'siteid'=>0,
					'name'=>'其他地区',
			);
			//从新排列数组下标
			array_merge($list);
			$returnarr = $this->notStarted($v,$list,$count);
			$treeNode = array_merge($treeNode, $returnarr);
		}
		$this->assign('MisSalesProjecTree',json_encode($treeNode));
	}
	/**
	 * @Title: notStarted
	 * @Description: todo(生成项目管理区域ztree 数组)
	 * @param 执行状态 $vo
	 * @param 区域数组 $list
	 * @param 区域总条数 $count
	 * @return Ambigous <multitype:string, 父级数组, multitype:string boolean 父级节点ID number unknown >
	 * @author liminggang
	 * @date 2014-4-22 下午5:46:05
	 * @throws
	 */
	private function notStarted($vo,$list,$count){
		$treeKey = $this->treeKey;
		$treeKey = $treeKey+1;
		$this->treeKey = $treeKey;
		$treeNode[] = array(
				'id' => $treeKey,
				'pId' => 0,
				'name' => $vo['name'] .'   ('. $count .')',
				'title' => $vo['name'],
				'rel' => "MisSalesProjectRel",
				'target' => 'ajax',
				'url' => '__URL__/index/jump/1/executiontypeid/'.$vo['id'].$indexlist,
				'open' => true
		);
		$aOrderTypestree = array();
		$treeNode = $this->getOrderTypestree($list,$treeKey,$vo['id'],$treeNode);
		return $treeNode;
	}
	/**
	 * @Title: getOrderTypestree
	 * @Description: todo(生成项目管理区域ztree 数组)
	 * @param 区域组数 $mOrderTypesList
	 * @param 父级节点ID $pid
	 * @param 当前节点ID $vid
	 * @param 父级数组 $istreeNode
	 * @return 返回等级数组
	 * @author liminggang
	 * @date 2014-4-22 下午5:43:13
	 * @throws
	 */
	private function getOrderTypestree($mOrderTypesList,$pid,$vid,$istreeNode){
		foreach ($mOrderTypesList as $key => $val) {
			$treeKey = $this->treeKey;
			$treeKey = $treeKey+1;
			$this->treeKey = $treeKey;
			$new = array(
					'id' => $treeKey,
					'pId' => $pid,
					'name' => $val['name'],
					'title' => $val['name'],
					'rel' => "MisSalesProjectRel",
					'target' => 'ajax',
					'url' => '__URL__/index/jump/1/executiontypeid/'.$vid.'/siteid/'.$val['siteid'].$indexlist,
					'open' => true
			);
			$istreeNode[] = $new;
		}
		return $istreeNode;
	}

	/**
	 * @Title: _before_common
	 * @Description: todo(新增和修改之前的公共方法)
	 * @author xiafengqin
	 * @date 2013-6-1 上午9:43:21
	 * @throws
	 */
	public function _before_common(){
		//获取项目类型
		$model = D('MisOrderTypes');
		$tlist = $model->where("type='01' and status = 1")->select();
		$this->assign("tlist", $tlist);
		//获取报价方式
		$odlist=$model->where('type = 55 and status = 1')->getField('id,name');
		$this->assign('odlist',$odlist);
		//获取销售区域
		$salesite = D('MisSalesSite');
		$sitelist = $salesite->where('status = 1')->select();
		$this->assign("sitelist", $sitelist);
		//业务人员
		$model = D('User');
		$ulist = $model->where('status = 1')->select();
		$this->assign("ulist", $ulist);
		//获得项目人员类型
		$MisSalesProjectUsertypeDAO=M('mis_sales_project_usertype');
		$list=$MisSalesProjectUsertypeDAO->where('status = 1')->order('sort')->select();
		$this->assign("list",$list);
		//项目执行状态  1:为销售项目执行状态
		$model = D('MisExecutionType');
		$elist = $model->where('status = 1 and typeid=1')->select();
		$this->assign("elist", $elist);
		//获取当前时间
		$this->assign('time',time());
		//获取当前登录人
		$this->assign('userid',$_SESSION[C('USER_AUTH_KEY')]);
		//单号是否可写
		$SystemConfigNumberModel	=D('SystemConfigNumber');
		$writable= $SystemConfigNumberModel->GetWritable('mis_sales_project');
		$this->assign("writable",$writable);
	}
	
	/**
	 * @Title: getLeadPersonName 
	 * @Description: todo(根据项目ID获取项目经理和分管领导 ) 
	 * @param 项目ID $projectid  
	 * @author liminggang 
	 * @date 2014-4-22 下午7:12:49 
	 * @throws
	 */
	public function getLeadPersonName($projectid){
		//获得项目人员表中的:项目经理和业务跟踪领导
		$MisSalesProjectUserModel = D('MisSalesProjectUser');
		$MisSalesProjectUserOuitnModel=D('MisSalesProjectUserOutin');
		//分管领导
		$leadUser = $MisSalesProjectUserModel->where('find_in_set(62,typeid) AND status = 1 AND projectid='.$projectid)->field('personid')->select();
		foreach ($leadUser as $key => $value) {
			$ispassauditl=$MisSalesProjectUserOuitnModel->where("auditstatus=1 AND status = 1 and projectid=".$projectid." and personid=".$value['personid'])->find();
			if($ispassauditl){
				$leadPersonName[] = getFieldBy($value['personid'],'id','name','mis_hr_personnel_person_info');
			}
		}
		$this->assign('leadPersonName',implode(',',$leadPersonName));
		//项目经理
		$leadProject = $MisSalesProjectUserModel->where('find_in_set(63,typeid) AND status = 1 AND projectid='.$projectid)->field('personid')->select();
		foreach ($leadProject as $key => $value) {
			$ispassaudit=$MisSalesProjectUserOuitnModel->where("auditstatus=1 AND status = 1 and projectid=".$projectid." and personid=".$value['personid'])->find();
			if($ispassaudit){
				$leadProjectName[] = getFieldBy($value['personid'],'id','name','mis_hr_personnel_person_info');
			}
		}
		$this->assign('leadProjectName',implode(',',$leadProjectName));
	}
	/**
	 * @Title: getSynthesize 
	 * @Description: todo(获得项目管理中，查看项目信息的综合信息) 
	 * @param 项目ID $projectid  
	 * @author liminggang 
	 * @date 2014-4-22 下午7:28:08 
	 * @throws
	 */
	public function getSynthesize($projectid){
		//累计完成产值
		$MisProjectWeekReportModel = D('MisProjectWeekReport');
		$allcost = $MisProjectWeekReportModel->where('status = 1 AND projectid='.$projectid)->order('id desc')->field('id,allcost,contracttotalprices')->find();
		//完工百分比
		$wgbfb = $allcost['allcost']/$allcost['contracttotalprices']*100;
		$this->assign('wgbfb',$wgbfb);
		$this->assign('allcost',$allcost);
		//进度监控
		$MisProjectScheduleAnalysisModel = D('MisProjectScheduleAnalysis');
		$day = $MisProjectScheduleAnalysisModel->where('auditState = 3 AND status = 1 AND projectid='.$projectid)->order('id desc')->field('id,planday,presentday,completeday')->find();
		$this->assign('day',$day);
		//成本监控
		$MisProjectCostAnalysisModel = D('MisProjectCostAnalysis');
		$cost = $MisProjectCostAnalysisModel->where('auditState = 3 AND status = 1 AND projectid='.$projectid)->order('id desc')->field('id,budgetcost,occucost,collected,arrate,tprofit,mprofit,tprofrate,mprofrate,quantities')->find();
		$zczbl = $cost['occucost']/$cost['quantities']*100;
		$this->assign('zczbl',$zczbl);
		$this->assign('cost',$cost);
		//项目人员
		$MisSalesProjectUserModel = D('MisSalesProjectUser');
		//在值人员名称
		$MisSalesProjectUserOuitnModel=D('MisSalesProjectUserOutin');
		$injobingname = $MisSalesProjectUserOuitnModel->where('status = 1 AND projectid='.$projectid.' AND isaudit=1 AND auditstatus=1')->distinct('personid')->field('personid')->select();
		//人事表
		$MisHrPersonnelPersonInfoModel = D('MisHrPersonnelPersonInfo');
		$technology=array();//技术人员
		$notechnology=array();//非技术人员
		foreach ($injobingname as $key => $value) {
			$workkind = $MisHrPersonnelPersonInfoModel->where('status = 1 AND id='.$value['personid'])->field('workkind')->find();
			if ($workkind['workkind'] == 1) {//技术人员
				$technology[] = $value['personid'];
			}
			if ($workkind['workkind'] == 2) {//非技术人员
				$notechnology[] = $value['personid'];
			}
		}
		$this->assign('injobingname',count($injobingname));
		$this->assign('technology',count($technology));
		$this->assign('notechnology',count($notechnology));
		$this->assign('projectid',$projectid);
	}
	/**
	 * @Title: getCharts
	 * @Description: todo(仪表盘页面ajax自动请求方法，返回图形数据)
	 * @author xiafengqin
	 * @date 2013-6-1 上午9:48:09
	 * @throws
	 */
	public function lookupgetCharts(){
		import('@.ORG.BaseCharts.Chart');
		$projectid = $_REQUEST['projectid'];
		$chartsModel = D('ReportCharts');
		$type = $_REQUEST['type'];
		$datalist = $chartsModel->getprojectanalysyList($projectid,$type);
		//获取当前项目开工日期
		$projectmodel=D($this->getActionName());
		$startdate = $projectmodel->where('id='.$projectid)->getField('startdate');
		$data = array();
		switch ($type) {
			// 项目成本监控
			case 'cost':
				$data = array();
				$data[] = array(
						'name' => '已完成工程量',
						'occurdate' => date ('Y-m-d',$startdate),
						'val' => 0
				);
				$data[] = array(
						'name' => '预算成本价',
						'occurdate' => date ('Y-m-d', $startdate),
						'val' => 0
				);
				$data[] = array(
						'name' => '已发生成本',
						'occurdate' => date ('Y-m-d', $startdate),
						'val' => 0
				);
				if($datalist){
					foreach($datalist as $key=>$val){
						$data[] = array(
								'name' => '已完成工程量',
								'occurdate' => date ('Y-m-d', $val['occurdate']),
								'val' => $val['quantities']
						);
						$data[] = array(
								'name' => '预算成本价',
								'occurdate' => date ('Y-m-d', $val['occurdate']),
								'val' => $val['budgetcost']
						);
						$data[] = array(
								'name' => '已发生成本',
								'occurdate' => date ('Y-m-d', $val['occurdate']),
								'val' => $val['occucost']
						);
					}
				}
				break;
				//项目质量监控
			case 'quality':
				if($datalist){
					foreach ($datalist as $key=>$val) {
						$data[] = array(
								'name' => '预计苗木存活率',
								'occurdate' => date ('Y-m-d', $val['occurdate']),
								'val' => $val['svratewishmm']
						);
						$data[] = array(
								'name' => '实际苗木存活率',
								'occurdate' => date ('Y-m-d', $val['occurdate']),
								'val' => $val['svraterealmm']
						);
					}
				}else{
					$data[] = array(
							'name' => '预计苗木存活率',
							'occurdate' => date ('Y-m-d', time()),
							'val' => 0
					);
					$data[] = array(
							'name' => '实际苗木存活率',
							'occurdate' => date ('Y-m-d', time()),
							'val' => 0
					);
				}
				break;
		}
		//创建chart对象
		$chart = new Chart();
		// 默认参数
		$graphAttribute = array('useRoundEdges'=>'1','formatNumberScale'=>'0');
		//调用方法进行设置
		$chart->setGraphAttribute($graphAttribute);
		switch($type){
			case 'cost':
			case 'quality':
				//设置x坐标
				$chart->setX('name');
				//设置Y坐标orderno
				$chart->setY('val');
				//生成图表
				$chart->setSeries('occurdate');
				break;
			case 'person':
				//设置x坐标
				$chart->setX('label');
				//设置Y坐标orderno
				$chart->setY('value');
				//生成图表
				$chart->setSeries();
				break;
		}
	
		//生成图表
		$chart->builderChart(Chart::$MULTI_SERIES_CHARTS, $data);
	}

	/**
	 * @Title: commonanalysis
	 * @Description: todo(项目查看的阶段进度，质量，成本分析列表的公共操作)
	 * @param 项目id $projectid 
	 * @param 对应的model名称 $name 
	 * @param 条件   $map 
	 * @param 刷新的divID $rel
	 * @param 方法名称  $mf  
	 * @author xiafengqin
	 * @date 2014-4-16 下午5:01:47
	 * @throws
	 */
	protected function commonanalysis($projectid,$name,$map,$rel,$method,$view){
		$this->_list ( $name, $map );
		$scdmodel = D('SystemConfigDetail');
		$detailList = $scdmodel->getDetail($name);
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
		//扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		$this->assign('rel',$rel);
		$this->assign('mf',$method);
		$this->assign('modelname',$name);
		$this->assign('projectid',$projectid);
	}
	/**
	 * @Title: arraymergerec
	 * @Description: todo()
	 * @param 存储预算清单数据数组 $array
	 * @return multitype:boolean multitype:NULL unknown
	 * @author xiafengqin
	 * @date 2014-2-25 下午3:42:03
	 * @throws
	 */
	protected function arraymergerec($array) {  // 参数是使用引用传递的
		$group = array();
		foreach ( $array as $key=>$item ) {
			$group[$item['retimes']][] = $item;
		}
		// 遍历当前数组的所有元素
		foreach ($group as $k=>$v){
			// 定义一个新的数组
			$new_array = array ("budget"=>false,"performance"=>false,"project"=>false);
			foreach ( $v as $key=>$item ) {
				if($item['uploadtimes'] === "1" ){
					$inputFileName ="project_budget_excel/".$item['path'];
					$a = array(
							'filepath'=>base64_encode($inputFileName),
							'projectid'=>$item['projectid'],
							'filename'=>$item['filename'],
							'id'=>$item['id'],
							'uploadtimes'=>$item['uploadtimes'],
							'retimes'=>$item['retimes'],
					);
					$new_array['budget'] = $a;
					continue;
				}
				if($item['uploadtimes'] === "2"){
					$inputFileName ="project_budget_excel/".$item['path'];
					$b = array(
							'filepath'=>base64_encode($inputFileName),
							'projectid'=>$item['projectid'],
							'filename'=>$item['filename'],
							'id'=>$item['id'],
							'uploadtimes'=>$item['uploadtimes'],
							'retimes'=>$item['retimes'],
					);
					$new_array['performance'] = $b;
					continue;
				}
				if($item['uploadtimes'] === "3"){
					$inputFileName ="project_budget_excel/".$item['path'];
					$c = array(
							'filepath'=>base64_encode($inputFileName),
							'projectid'=>$item['projectid'],
							'filename'=>$item['filename'],
							'id'=>$item['id'],
							'uploadtimes'=>$item['uploadtimes'],
							'retimes'=>$item['retimes'],
					);
					$new_array['project'] = $c;
					continue;
				}
			}
			$filishval[$k] = $new_array;
		}
		// 修改引用传递进来的数组参数值
		return $filishval;
	}
	/**
	 * @Title: getProjectWork
	 * @Description: todo(构造工作流可操作内容结构)
	 * @param 刷新的div的ID $rel
	 * @param 提交的地址 $url
	 * @return 返回一个数组
	 * @author liminggang
	 * @date 2014-3-5 上午9:38:03
	 * @throws
	 */
	protected function getProjectWork($rel,$url){
		$sclmodel = D('SystemConfigList');
		//获取项目可以执行的工作
		$mdarr = $sclmodel->getProjectMyWork();
		//判断是否有该控制器的操作权限
		$arr = array();
		if($mdarr){
			foreach($mdarr as $key=>$val){
				if($val['pId'] != 0){
					//第一步，判断当前模块是否有操作权限
					$md_add = strtolower($val['md'])."_index";
					//print_r($md_add);
					if(!$_SESSION[$md_add] && !$_SESSION['a']){
						//没有新增权限
						unset($mdarr[$key]);
					}else{
						//封装rel 和 url进数组中
						$mdarr[$key]['rel'] = $rel;
						$mdarr[$key]['url'] = $url.$val['md'];
					}
				}
			}
		}
		$mdarr=array_merge($mdarr);
		return $mdarr;
	}
}
?>