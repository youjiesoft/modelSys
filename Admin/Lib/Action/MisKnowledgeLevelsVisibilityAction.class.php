<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(知识库文章等级管理和等级附件配置下载限制) 
 * @author yuansl 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-6-30 上午11:55:46 
 * @version V1.0
 */
class MisKnowledgeLevelsVisibilityAction extends CommonAction{
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)$map['status']=array("gt",0);
	}
	public function index(){
		$MisExpertQuestionTypeModel = D("MisKnowledgeLevelsVisibility");
		$name = $this->getActionName();
		//列表过滤器，生成查询Map对象
		$map = $this->_search ($name);
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		//验证浏览及权限
		if( !isset($_SESSION['a']) ){
			$map=D('User')->getAccessfilter($qx_name,$map);
		}
		/**
		 * //样式修改。做成基本资料类左树 右详细页面  kaishi
		 */
		
		import ( '@.ORG.Browse' );
		//map附加
		if($_REQUEST['remindMap']){
			$remindMap=base64_decode($_REQUEST['remindMap']);
			if($map){
				$map.=" and ".$remindMap;
			}else{
				$map=$remindMap;
			}
		}
		if ($_SESSION ['a'] != 1) {
			$broMap = Browse::getUserMap ( $this->getActionName() );
			if ($broMap) {
				if($map['_string']){
					$map['_string'] .= " and " . $broMap;
				}else{
					$map['_string']= $broMap;
				}
			}
		}
		$model = D($name);
		/* ***************** 修改 ***************** */
		if($_POST['search_flag'] == 1){
			$this->setAdvancedMap($map);
		}	
		$voList = $model->where($map)->order('code desc')->select();
		$param['rel']="MisKnowledgeLevelsVisibilityBox";
		$param['url']="__URL__/index/jump/1/hy/#id#";
		//构建标题
		$treemiso[]=array(
				'id'=>0,
				'pId'=>0,
				'name'=>'文章编号',
				'title'=>'文章编号',
				'open'=>true,
				'isParent'=>true,
		);
		//构建树
		foreach($voList as $k=>$v){
			$newv=array();
			$matches=array();
			preg_match_all('|#+(.*)#|U', $param['url'], $matches);
			foreach($matches[1] as $k2=>$v2){
				if(isset($v[$v2])) $matches[1][$k2]=$v[$v2];
			}
			$url = str_replace($matches[0],$matches[1],$param['url']);
			$newv['id']=$v['id'];
			$newv['pId']=$v['parentid']?$v['parentid']:0;
			$newv['type']='post';
			$newv['url']=$url;
			$newv['target']='ajax';
			$newv['rel']=$param['rel'];
			$newv['title']=$v['code']; //光标提示信息
			$newv['name']=missubstr($v['code'],18,true); //结点名字，太多会被截取,针对于现在的ZTREE，宽度不能超过18个字符。
			if($v['parentid']==0){
				$newv['open']=$v['open'] ? $v['open']:'true';
			}
			if($param['open']){
				$newv['open']='true';
			}
			$newv['isParent'] = $param['isParent']=="true" ? true:false;
			array_push($treemiso,$newv);
		}
		$treearr=json_encode($treemiso);
		$this->assign("treearr",$treearr);
		//获取ID
		$hy = $_REQUEST['hy'];
		//定义一个存储数据数组
		$vo = array();
		if($hy){
			$map['id'] = $hy;
			$vo=$model->where($map)->find();
		}else{
			if($voList){
				//判断是否存在行业
				$vo = $voList[0];
				$hy = $voList[0]['id'];
			}
		}
		$this->assign('valid',$hy);
		$this->assign('vo',$vo);
		/**
		 * jieshu
		 */
		//处理$vo数据
		if(empty($vo)){
			$this->display ("Public:404");
			exit;
		}
		$deptList = explode(',',$vo['deptid']);
		$dutyList = explode(',',$vo['dutyid']);
		if($vo['deptid']){
			$this->assign('deptList',$deptList);
		}
		if($vo['dutyid']){
			$this->assign('dutyList',$dutyList);
		}
		
		//$this->_list ( $name, $map );
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
		if($_REQUEST['jump']){
			$this->display('edit');
		}else{
			$this->display('index');
		}
	}
	/**
	 * @Title: _before_add 
	 * @Description: todo(这里用一句话描述这个方法的作用)   
	 * @author yuansl 
	 * @date 2014-7-1 上午11:00:31 
	 * @throws
	 */
	public function _before_add(){
		//订单是否可写
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable('mis_knowledge_levels_visibility');
		$this->assign("writable",$writable);
		//自动生成编号
		$code = $scnmodel->GetRulesNO('mis_knowledge_levels_visibility');
		$this->assign("code", $code);
// 		$this->common();
	}
	/**
	 * @Title: _before_insert 
	 * @Description: todo(这里用一句话描述这个方法的作用)   
	 * @author yuansl 
	 * @date 2014-7-1 上午11:00:35 
	 * @throws
	 */
	public function _before_insert(){
// 		$_POST['title'] = $this->get_title($_POST['levels']);
		$_POST['dutyid'] = implode(',',$_POST['dutyid']);
		$_POST['deptid'] = implode(',',$_POST['deptid']);
		$this->checklevel($_POST['title']);
	}
	/**
	 * @Title: _before_edit 
	 * @Description: todo(这里用一句话描述这个方法的作用)   
	 * @author yuansl 
	 * @date 2014-7-1 上午11:00:39 
	 * @throws
	 */
	public function _before_edit(){
// 		$this->common();
		$id = $_REQUEST['id'];
		$modelname = $this->getActionName();
		$model = D($modelname);
		$map['id']=$id;
		if ($_SESSION["a"] != 1) $map['status'] = 1;
		$vo = $model->where($map)->find();
		if(empty($vo)){
			$this->display ("Public:404");
			exit;
		}
		$deptList = explode(',',$vo['deptid']);
		$dutyList = explode(',',$vo['dutyid']);
		if($vo['deptid']){
			$this->assign('deptList',$deptList);
		}
		if($vo['dutyid']){
			$this->assign('dutyList',$dutyList);
		}
	}
	public function _after_insert($id){
		$modelname = $this->getActionName();
		$model = D($modelname);
		$model->where("id = ".$id)->setField("levels",$id);
	}
	/**
	 * @Title: _beofor_update 
	 * @Description: todo(这里用一句话描述这个方法的作用)   
	 * @author yuansl 
	 * @date 2014-7-1 上午11:00:43 
	 * @throws
	 */
	public function _before_update(){
// 		$_POST['title'] = $this->get_title($_POST['levels'],$_REQUEST['id']);
		$this->checklevel($_POST['title'],$_REQUEST['id']);
		/* print_r($_POST['dutyid']);
		print_r($_POST['deptid']);
		exit(); */
		if($_POST['dutyid']){
			$_POST['dutyid'] = implode(',',$_POST['dutyid']);
		}else{
			$_POST['dutyid'] = '';
		}
		if($_POST['deptid']){
			$_POST['deptid'] = implode(',',$_POST['deptid']);
		}else{
			$_POST['deptid'] = '';
		}
	}
	//查询结果
	public function lookupdepartment($par){
		$this->assign('par', $_REQUEST['par']);
		$map['status']=1;
		if(isset($_POST['keyword'])&&$_POST['keyword']!=null){
			$map['name']=array('like','%'.$_POST['keyword'].'%');//名字
		}
		$this->assign('keyword',$_POST['keyword']);
		$this->assign('searchby',$_POST['seachby']);//下拉框选定,传回去
		$this->_list($_REQUEST['par'], $map);
		//搜索角色
		if($_REQUEST['par']=='Duty'){
			$this->display('lookupduty');
			exit;
		}
		//搜索部门
		if ($_REQUEST['par'] == 'MisSystemDepartment') {
			$this->display('lookupdepartment');
			exit;
		}
	}
/**
 * @Title: checklevel 
 * @Description: todo(修改的时候,除去本身限制) 
 * @param unknown_type $leveltitle
 * @param unknown_type $nid  
 * @author yuansl 
 * @date 2014-7-1 下午5:33:28 
 * @throws
 */
	private function checklevel($leveltitle,$nid){
		$modelname = $this->getActionName();
		$model = D($modelname);
		if($nid){
			$map['id'] = array('neq',$nid);
		}
		$map['title'] = $leveltitle;
		$rex = $model->where($map)->find();
		if($rex){
			$this->error("已存在相同名称");
			exit;
		}
	}
	/**
	 * @Title: common
	 * @Description: todo(这里用一句话描述这个方法的作用)
	 * @param unknown_type $px
	 * @return Ambigous <string>
	 * @author yuansl
	 * @date 2014-7-1 上午11:00:46
	 * @throws
	 */
 	/* private function common($px){
		$Levas = array(
				array(
						'key'=>'1',
						'title'=>'技术_A'
				),
				array(
						'key'=>'2',
						'title'=>'技术_B'
				),
				array(
						'key'=>'3',
						'title'=>'技术_C'
				),
				array(
						'key'=>'4',
						'title'=>'技术_D'
				),
				array(
						'key'=>'5',
						'title'=>'技术_E'
				),
				array(
						'key'=>'6',
						'title'=>'技术_F'
				),
				array(
						'key'=>'1',
						'title'=>'管理_A'
				),
				array(
						'key'=>'2',
						'title'=>'管理_B'
				),
				array(
						'key'=>'3',
						'title'=>'管理_C'
				),
				array(
						'key'=>'4',
						'title'=>'管理_D'
				),
				array(
						'key'=>'5',
						'title'=>'管理_E'
				),
				array(
						'key'=>'6',
						'title'=>'管理_F'
				)
		);
		$this->assign('newLevas',$Levas);
	}  */
	/**
	 * @Title: get_title
	 * @Description: todo(这里用一句话描述这个方法的作用)
	 * @param unknown_type $leve
	 * @author yuansl
	 * @date 2014-7-1 下午5:17:59
	 * @throws
	 */
	/* private function get_title($leve){
		$tit = "";
		switch ($leve)
		{
			case 1:
				$tit = A;
				break;
			case 2:
				$tit = B;
				break;
			case 3:
				$tit = C;
				break;
			case 4:
				$tit = D;
				break;
			case 5:
				$tit = E;
				break;
			case 6:
				$tit = F;
				break;
			default:
				$tit = false;
				break;
		}
		return $tit;
	} */
}