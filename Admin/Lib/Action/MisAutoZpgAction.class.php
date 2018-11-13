<?php
/**
 * @Title: MisAutoZpgAction
 * @Package package_name
 * @Description: todo(动态表单_自动生成-表决)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-12-23 15:20:57
 * @version V1.0
*/
class MisAutoZpgAction extends MisAutoZpgExtendAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1){
			$map['status']=array("gt",-1);
		}
		$this->_extend_filter(&$map);
	}
	public function index() {
		$param['rel']="MisAutoZpgindexview";
		$param['url']="__URL__/index/jump/jump/pingshenhuileixing/#pingshenhuileixing#/biaojueStatus/#biaojueStatus#";
		$treemiso[]=array(
				'id'=>0,
				'pId'=>0,
				'name'=>'评审表决单',
				'title'=>'评审表决单',
				'open'=>true,
				'isParent'=>true,
		); 
		//查询评审会类型
		$MisAutoJtmModel=D('MisAutoJtm');
		$MisAutoJtmList=$MisAutoJtmModel->where(array('status'=>1))->select();
		foreach ($MisAutoJtmList as $jtmk=>$jtmv){
			$list[]=array(
					'id'=>$jtmv['id'],
					'parentid'=>0,
					'name'=>$jtmv['name'],
					'title'=>$jtmv['name'],
					'open'=>true,
					'isParent'=>true,
					'pingshenhuileixing'=>$jtmv['id'],
					'biaojueStatus'=>1,
					);
			$list[]=array(
					'id'=>'99999'.$jtmv['id'],
					'parentid'=>$jtmv['id'],
					'name'=>'未表决',
					'title'=>'未表决',
					'open'=>true,
					'isParent'=>true,
					'pingshenhuileixing'=>$jtmv['id'],
					'biaojueStatus'=>1,
					);
			$list[]=array(
					'id'=>'9888'.$jtmv['id'],
					'parentid'=>$jtmv['id'],
					'name'=>'已表决',
					'title'=>'已表决',
					'open'=>true,
					'isParent'=>true,
					'pingshenhuileixing'=>$jtmv['id'],
					'biaojueStatus'=>2,
			);
		}
		$treearr = $this->getTree($list,$param,$treemiso);
		// 默认选中
        $treelist = json_decode($treearr);
        $this->assign('zid',$treelist[0]->id);

        $this->assign("treearr",$treearr);
		$name = $this->getActionName();
		//列表过滤器，生成查询Map对象
		$pingshenhuileixing=$_REQUEST['pingshenhuileixing'];
		$biaojueStatus=$_REQUEST['biaojueStatus'];
		if($biaojueStatus==null){
			$biaojueStatus=1;
			$_REQUEST['biaojueStatus']=1;
		}
		if($pingshenhuileixing==null){
			$pingshenhuileixing=$MisAutoJtmList[0]['id'];
		}
		$this->assign('biaojueStatus',$biaojueStatus);
		$this->assign('pingshenhuileixing',$pingshenhuileixing);
		//查询当前用户是否已经表决
		$subModel=M('mis_auto_fuhhu_sub_datatable5');
		$subList=$subModel->select();
		$name1='MisAutoVphSubView';
		
		//查询评审会类型下的表决模板
		$leixingList=$MisAutoJtmModel->where(array('id'=>$pingshenhuileixing))->find();
		$ModelAction=$leixingList['duiyingmoban'];
		$_REQUEST['ModelAction']=$ModelAction;
		$this->assign('ModelAction',$ModelAction);
		if($biaojueStatus==2){
			$map = $this->_search ($ModelAction);
		}else{
			$map = $this->_search ('MisAutoZpg');
		}
		if($biaojueStatus==1){
			$listName='MisAutoZpg';
			$map['conveneStatus']=2;
			$map['shifoujieshu']=0;
			foreach ($subList as $k=>$val){
				//查询是否该用户是否在需要表决里面
				$neibuArr= explode(',',$val['neiburenyuan']);
				$neibiaojueArr=explode(',',$val['userid']);
				$waibuArr= explode(',',$val['waiburenyuan']);
				$waibiaojueArr=explode(',',$val['expertid']);
				$waibulist=in_array($_SESSION[C('USER_AUTH_KEY')],$waibuArr);
				$waibiaojuelist=in_array($_SESSION[C('USER_AUTH_KEY')],$waibiaojueArr);
				$neibulist=in_array($_SESSION[C('USER_AUTH_KEY')],$neibuArr);
				$neibiaojuelist=in_array($_SESSION[C('USER_AUTH_KEY')],$neibiaojueArr);
			
				//查询该用户是否已经表决
				$model=D($ModelAction);
				$biaojueMap['pingshenhuiid']=$val['pingshenhuiid'];
				$biaojueMap['zhaojidanid']=$val['masid'];
				$biaojueMap['zhaojidansubid']=$val['id'];
				$biaojueMap['_string']='userid='.$_SESSION[C('USER_AUTH_KEY')].' or expertid='.$_SESSION[C('USER_AUTH_KEY')];
				$biaojuelist=$model->where($biaojueMap)->select();
				if(($neibulist && !$neibiaojuelist) || ($waibulist && !$waibiaojuelist)){
					if(empty($biaojuelist)){
					$subId[]=$val['id'];
					}
				}
			}
			$map['pingshenhuileixing']=$pingshenhuileixing;
			$map['id']=array('in',$subId);
		}elseif($biaojueStatus==2){
			$name1=$ModelAction;
			$listName=$ModelAction;
			$map['_string']='userid='.$_SESSION[C('USER_AUTH_KEY')].' or expertid='.$_SESSION[C('USER_AUTH_KEY')];
			$map['pingshenhuileixing']=$pingshenhuileixing;
		}
		
		
		if (! empty ( $name )) {
			$qx_name=$name;
			if(substr($name, -4)=="View"){
				$qx_name = substr($name,0, -4);
			}
			
			//列表页排序 ---开始-----2015-08-06 15:07 write by xyz
			if($_REQUEST['orderField']&&strpos(strtolower($_REQUEST['orderField']),' asc')===false&&strpos(strtolower(strpos($_REQUEST['orderField'])),' desc')===false){
				$this->_list ( $name1, $map);
			}else{
				$sortsorder = '';
				$sortsmap['modelname'] = $name1;
				$sortsmap['sortsorder'] = array("gt",0);
				//管理员读公共设置
				if($_SESSION['a']){
					$listincModel = M("mis_system_public_listinc");
					$sortslist = $listincModel->where($sortsmap)->order("sortsorder")->select();
				}else{
					//个人先读个人设置、没有再读公共设置
					$sortsmap['userid'] = $_SESSION [C ( 'USER_AUTH_KEY' )];
					$listincModel = M("mis_system_private_listinc");
					$sortslist = $listincModel->where($sortsmap)->order("sortsorder")->select();
					if(empty($sortslist)){
						unset($sortsmap['userid']);
						$listincModel = M("mis_system_public_listinc");
						$sortslist = $listincModel->where($sortsmap)->order("sortsorder")->select();
					}
				}
				//如果在设置里有相关数据、提取排序字段组合order by
				if($sortslist){
					foreach($sortslist as $k=>$v){
						$sortsorder .= $v['fieldname'].' '.$v['sortstype'].',';
					}
					$sortsorder = substr($sortsorder,0,-1);
				}
				//列表页排序 ---结束-----
				$this->_list ( $name1, $map,'', false,'','',$sortsorder);
			}
				
				
		}
		
		
		
		
		
		
		
		
		
// 		if (! empty ( $name )) {
// 			$qx_name=$name;
// 			if(substr($name, -4)=="View"){
// 				$qx_name = substr($name,0, -4);
// 			}
// 			//验证浏览及权限
// 			/* if( !isset($_SESSION['a']) ){
// 				$map=D('User')->getAccessfilter($qx_name,$map);
// 			} */
// 			$this->_list ( $name1, $map );
// 		}
		// 		//begin
		$scdmodel = D('SystemConfigDetail');
		//读取列名称数据(按照规则，应该在index方法里面)
		
		$detailList = $scdmodel->getDetail($listName);
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
		// 		//扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		 if($biaojueStatus==3 || $biaojueStatus==null){
			unset($toolbarextension['js-edit']);
			unset($toolbarextension['js-add']);
		}elseif($biaojueStatus==2){
			unset($toolbarextension['js-add']);
		}elseif($biaojueStatus==1){
			unset($toolbarextension['js-edit']);
		}else{
			unset($toolbarextension['js-view']);
		} 
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
		if($_REQUEST['jump']){
			$this->display('indexview');exit;
		}
		$this->display ();
		return;
	}
	
	/**
	 * @Title: edit
	 * @Description: todo(重写父类编辑函数)
	 * @author 管理员
	 * @date 2014-12-23 15:20:57
	 * @throws 
	*/
	function edit(){
		//查询评审会类型
		$leixingMap['id']=$_REQUEST['pingshenhuileixing'];
		$leixingModel=M('mis_auto_fwvvg');
		$leixingList=$leixingModel->where($leixingMap)->find();
		$mobanAction=$leixingList['duiyingmoban'];
		
		$name = $mobanAction;
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
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		//读取动态配制
		$this->getSystemConfigDetail($name,$vo);
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
		$module=A($mobanAction);
		if (method_exists($module,"_after_edit")) {
			call_user_func(array(&$module,"_after_edit"),&$vo);
		}
		$this->assign( 'vo', $vo );
		
		$this->display ($mobanAction.':edit');
	}
	

	function add(){
		$mainTab = 'mis_auto_fuhhu_sub_datatable5';
		//获取当前控制器名称
		$name=$this->getActionName();
		$model = D("MisAutoVphSubView");
		//获取当前主键
		$map[$mainTab.'.id']=$_REQUEST['id'];
		$vo = $model->where($map)->find();
		//查询用户是内部评审还是外部评审
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		$neibuArr= explode(',',$vo['neiburenyuan']);
		$waibuArr= explode(',',$vo['waiburenyuan']);
		$waibulist=in_array($userid,$waibuArr);
		$neibulist=in_array($userid,$neibuArr);
		if($waibulist){
			$vo['shifuzhuanjia']=2 ;
		}else{
			$vo['shifuzhuanjia']=1 ;
		}
		
		$vo['zhaojidansubid']=$vo['id'];
		//查询评审会类型
		$leixingMap['id']=$vo['pingshenhuileixing'];
		$leixingModel=M('mis_auto_fwvvg');
		$leixingList=$leixingModel->where($leixingMap)->find();
		$mobanAction=$leixingList['duiyingmoban'];
		$vo['jumpaction']=$mobanAction;
		$shenqingmoban=$leixingList['shenqingmoban'];
		$sqModel=D($shenqingmoban);
		$sqList=$sqModel->where(array('id'=>$vo['pingshenhuiid']))->find();
		unset($sqList['id']);
		$vo=array_merge($vo,$sqList);
		$vo['yewuleixing']=$sqList['yewuleixing'];
		$vo['zijinyongtu']=$sqList['zijinyongtu'];
		$vo['dangqianfengxiandeng']=$sqList['dangqianfengxiandeng'];
		$vo['baohouleixing']=$sqList['baohouleixing'];
		$vo['shouqubaozhengjinbil']=$sqList['baozhengjinlv'];
		$vo['jianyidanbaolv']=$sqList['jianyidanbaofeilv'];
		$vo['shouqubaozhengjinbil']=$sqList['baozhengjinlv'];
		$vo['baohouzhixingdanhao']=$sqList['baohoujihuahao'];
		$vo['biaojueriqi']=time();
		$vo['xiangmuxinxina']=$vo['xiangmubianma'];
		$vo['xiangmuxinxiwai']=$vo['xiangmubianma'];
		$vo['danbaojiekuanleixing']=$sqList['danbaojiekuanleixing'];
		$vo['zhudiao']=$sqList['zhudiao'];
		$vo['fengkongrenyuan']=$sqList['fengkongrenyuan'];
		if($vo['pingshenhuileixing']==7){
			$vo['baozhengjinjianmianl']=$sqList['baozhengjinlv'];
		}else{
			$vo['baozhengjinjianmianl']=$sqList['baozhengjinjianmianl'];
		}
		$vo['touzirennianhuashouy']=$sqList['touzirennianhuashouy'];
		$vo['yixiangdanbaofeilv']=$sqList['yixiangdanbaofeilv'];
		
		//业务人员意见
		$vo['yewurenyuanyijian']=$sqList['yewurenyuanyijian'];
		if($vo['pingshenhuileixing']==2){
			//业务人员建议借(贷)款金额
			$vo['yewurenyuanjianyijie']=$sqList['yewurenyuanjianyijie'];
			//业务人员建议借(贷)款期限
			$vo['yewurenyuanjianyijier']=$sqList['yewurenyuanjianyijiet'];
			//风控人员建议借(贷)款金额
			$vo['fengkongrenyuanjiany']=$sqList['fengkongrenyuanjianyq'];
			//风控人员建议借(贷)款期限
			$vo['fengkongrenyuanjianye']=$sqList['fengkongrenyuanjianyn'];
		}else{
			//业务人员建议借(贷)款金额
			$vo['yewurenyuanjianyijie']=$sqList['yewurenyuanjianyijin'];
			//业务人员建议借(贷)款期限
			$vo['yewurenyuanjianyijier']=$sqList['yewurenyuanjianyiqix'];
			//风控人员建议借(贷)款金额
			$vo['fengkongrenyuanjiany']=$sqList['fengkongrenyuanjiany'];
			//风控人员建议借(贷)款期限
			$vo['fengkongrenyuanjianye']=$sqList['fengkongrenyuanjianyf'];
		}
		
		//业务人员建议直投金额
		$vo['yewurenyuanjianyizhi']=$sqList['yewurenyuanjianyizhi'];
		//业务人员建议直投期限	
		$vo['yewurenyuanjianyizhiy']=$sqList['yewurenyuanjianyizhib'];
		//业务人员建议总金额
		$vo['yewurenyuanjianyizon']=$sqList['yewurenyuanjianyizon'];
		//风控人员意见
		$vo['fengkongrenyuanyijia']=$sqList['fengkongrenyuanyijia'];
		//风控人员建议直投金额
		$vo['fengkongrenyuanjianyg']=$sqList['fengkongrenyuanjianyfg'];
		//风控人员建议直投期限
		$vo['fengkongrenyuanjianyi']=$sqList['fengkongrenyuanjianyk'];
		//风控人员建议总金额
		$vo['fengkongrenyuanjianyk']=$sqList['fengkongrenyuanjianyr'];
		//客户基础信用量化
		$vo['kehujichuxinyonglian']=$sqList['kehujichuxinyonglian'];
		//产品类型
		$vo['chanpinleixing']=$sqList['chanpinleixing'];
		$vo['jijianfuwufeilv']=$sqList['jijianfuwufeilv'];//居间服务费率
		//是否三产融合项目
		$vo['shifusanchanronghexi']=$sqList['shifusanchanronghexi'];
		
		$biaoming=D($mobanAction)->getTableName();
		$scnmodel = D('SystemConfigNumber');
		
		$ordernoInfo = $scnmodel->getOrderno($biaoming,"MisAutoZoq");
		$vo['orderno']=$ordernoInfo['orderno'];
		$this->getSystemConfigDetail($mobanAction,$vo);
		$this->assign( 'vo', $vo ); 
		$this->display ($mobanAction.':add');
// 		$module2 = A($mobanAction);
// 		if (method_exists($module2,"_after_add")) {
// 			call_user_func(array(&$module2,"_after_add"),$data);
// 		}
	}
	
	function view(){
		//查询评审会类型
		$leixingMap['id']=$_REQUEST['pingshenhuileixing'];
		$leixingModel=M('mis_auto_fwvvg');
		$leixingList=$leixingModel->where($leixingMap)->find();
		$mobanAction=$leixingList['duiyingmoban'];
		
		$name = $mobanAction;
		$model = D($name);
		//获取当前主键
		$map[$mainTab.'.id']=$_REQUEST['id'];
		if($_REQUEST['preview']==1){
			$name = $this->getActionName();
			$this->previewPost();
			//读取动态配制
			$this->getSystemConfigDetail($name);
			$this->display();
			exit;
		}
		$module=A($this->getActionName());
		if (method_exists($module,"_before_edit")) {
			call_user_func(array(&$module,"_before_edit"));
		}
		$this->edit ($num);
		$this->display ($mobanAction.":view");
	}
	/**
	 * @Title: _before_index
	 * @Description: todo(前置index函数)
	 * @author 管理员
	 * @date 2014-12-23 15:20:57
	 * @throws 
	*/
	function _before_index() {
		$this->_extend_before_index();
	}
	/**
	 * @Title: _before_edit
	 * @Description: todo(前置编辑函数)
	 * @author 管理员
	 * @date 2014-12-23 15:20:57
	 * @throws 
	*/
	function _before_edit(){
		$this->_extend_before_edit();
	}
	
	/**
	 * @Title: _after_edit
	 * @Description: todo(后置编辑函数)
	 * @author 管理员
	 * @date 2014-12-23 15:20:57
	 * @throws 
	*/
	function _after_edit($vo){
		$this->_extend_after_edit($vo);
	}
	
	
	/**
	 * @Title: _before_add
	 * @Description: todo(前置add函数)  
	 * @author 管理员
	 * @date 2014-12-23 15:20:57
	 * @throws
	*/
	function _before_add(){
		$model=D('Selectlist');
		$selectlis = $model->GetRules('YesOrNo');
		$selectlistshifutongyi=array();
		foreach($selectlis['YesOrNo'] as $k=>$v){
			$temp['key']=$k;
			$temp['val']=$v;
			$selectlistshifutongyi[]=$temp;
		}
		$this->assign("selectlistshifutongyi",$selectlistshifutongyi);
		$this->_extend_before_add();
	}
	
	function insert($isrelation){
		$jumpAction=A($_POST['jumpaction']);
		try {
			C("TOKEN_ON",false);
			if (method_exists($jumpAction,"_before_insert")) {
				call_user_func(array(&$jumpAction,"_before_insert"));
			}
			
			if($isrelation){
				$isret = $jumpAction->insert($isrelation);
				return $isret;
			}
				
			C("TOKEN_ON",true);
		}catch (Exception $e){
			C("TOKEN_ON",true);
			$this->error($e->__toString());
		}
	}
	
	
	function update($isrelation){
		$jumpAction=A($_POST['jumpaction']);
		try {
			C("TOKEN_ON",false);
			if (method_exists($jumpAction,"_before_update")) {
				call_user_func(array(&$jumpAction,"_before_update"));
			}
				
			if($isrelation){
				$isret = $jumpAction->update($isrelation);
				return $isret;
			}
		
			C("TOKEN_ON",true);
		}catch (Exception $e){
			C("TOKEN_ON",true);
			$this->error($e->__toString());
		}
	}
	
}
?>
