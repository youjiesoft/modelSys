<?php
//Version 1.0
/**
 * @Title: MisFinanceExpensesTypeAction
 * @Package 财务模块-费用分类：功能类
 * @Description: TODO(费用分类的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
 */
class MisFinanceExpensesTypeAction extends CommonAction{
	/**
	 * @Title: _filter
	 * @Description: todo(重写CommonAction的_filter方法，传递过滤参数后返回列表页面)
	 * @return string
	 * @author yangxi
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */	
	public function _filter(&$map){
		if ($_SESSION["a"] != 1){
			$map['status']=array("gt",-1);
		}
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
		$map=$this->_search();
		//调用检索
		$this->_filter($map);
		//费用类别model
		$misFinanceExpensesTypeModel=D('MisFinanceExpensesType');
		//科目表model
		$misFinanceAmountTitleModel=D('MisFinanceAmountTitle');
		$misFinanceAmountTitleList=$misFinanceAmountTitleModel->getField('id,name,code');
		$list = $misFinanceExpensesTypeModel->where($map)->select();
		$idlist = array();
		foreach ($list as $k => $v) {
			$idlist[$v['id']] = 1;
		}
		$topicjson["response"]= array();
		foreach ($list as $k => $v) {
			if($idlist[$v['parentid']] == false || $v['parentid'] == 0){
				$treeArr = array();
				$treeArr2 = $this->getFinanceExpensesTypeTree($v['id'],$v['name'],$misFinanceAmountTitleList,0,$list);
				$isLeaf = true;
				if($treeArr2){
					$isLeaf = false;
				}
				$parentname = '顶级节点';
				if ($v['parentid'] != 0) {
					$parentname = $misFinanceExpensesTypeModel->where('id='.$v['parentid'])->getField('name');
				}
				$topicjson["response"][] = array(
						'id'=>$v['id'],
						'code' => $v['code'],
						'name' => $v['name'],
						'parentname' => $parentname,
						'accountid' => $misFinanceAmountTitleList[$v['accountid']]['code'],
						'accountname' => $misFinanceAmountTitleList[$v['accountid']]['name'],
						'remark'=>$v['remark'],
						'level'=>0,
						'parent'=>$v['parentid'],
						'isLeaf' => $isLeaf,
						'expanded'=>true,
						'loaded'=>true,
				);
				if($treeArr2){
					$topicjson["response"] = array_merge($topicjson["response"],$treeArr2);
				}
			}
		}
		$topicjson=json_encode($topicjson);
		$this->assign("topicjson",$topicjson);
		$this->display();
	}
	
	/**
	 * 获取树形结构的数据源
	 * @param array  $map  查询参数
	 * @return string
	 */	
	private function getFinanceExpensesTypeTree($pid,$pname,$misFinanceAmountTitleList,$level,$list){
		$level = $level+1;
		$treeArr = array();
		$misFinanceExpensesTypeModel = D('MisFinanceExpensesType');
		$fetmap['status'] = 1;
		$fetmap['parentid'] = $pid;
		foreach ($list as $k => $v) {
			if($v['parentid'] == $pid){
				$treeArr2 = $this->getFinanceExpensesTypeTree($v['id'],$v['name'],$misFinanceAmountTitleList,$level,$list);
				$isLeaf = true;
				if($treeArr2){
					$isLeaf = false;
				}
				$treeArr[] = array(
						'id'=>$v['id'],
						'code' => $v['code'],
						'name' => $v['name'],
						'parentname' => $pname,
						'accountid' => $misFinanceAmountTitleList[$v['accountid']]['code'],
						'accountname' => $misFinanceAmountTitleList[$v['accountid']]['name'],
						'remark'=>$v['remark'],
						'level'=>$level,
						'parent'=>$v['parentid'],
						'isLeaf' => $isLeaf,
						'expanded'=>true,
						'loaded'=>true,
				);
				if($treeArr2){
					$treeArr = array_merge($treeArr,$treeArr2);
				}
			}
		}
		return $treeArr;
	}
// 	//原ztree  代码
// 	public function index1(){
// 		$map=array();
// 		$this->znodes( $map );
// 		$typeid = $_REQUEST['id'];
// 		if ($typeid) {
// 			$map['id'] = $typeid;
// 			$model=M("mis_finance_expenses_sub");
// 			$count=$model->where("typeid=".$typeid)->count();
// 			if($count>0)
// 			{
// 				$hasexpenses=1;
// 				$this->assign("hasexpenses",$hasexpenses);
// 			}
// 		}
// 		$this->assign("valid",$map['id']);
// 		$name=$this->getActionName();
// 		$model = D ( $name );
// 		$vo=$model->where($map)->find();

// 		$this->assign("vo",$vo);
// 		if ($_REQUEST['jump']) {
// 			$this->display('unitlist');
// 		} else {
// 			$this->display('indexcopy');
// 		}
// 	}
// 	/**
// 	 * 获取树形结构的数据源
// 	 * @param array  $map  查询参数
// 	 * @return string
// 	 */	
// 	private function znodes( &$map ){
// 		$name=$this->getActionName();
// 		$model=D($name);
// 		$list=$model->where($map)->select();
// 		if($list ) $map['id']=$list[0]['id'];
// 		$treearr=$this->getTree($list);
// 		$this->assign("treearr",$treearr);
// 	}

	/**
	 * 构造树形结构
	 * @param array  $alldata  所有部门信息
	 * @param int $pid  部门节点ID
	 * @param int $i  节点等级
	 * @return string
	 */
	public function getTree($alldata,$pid=0,$i=0){
		$returnarr=array(array('id'=>0,'pId'=>0,'name'=>'费用分类','type'=>'post','url'=>'__URL__/index','target'=>'ajax','rel'=>'misfinancecostcentermodel','open'=>'true'));
		foreach($alldata as $k=>$v){
			$newv=array();
			$newv['id']=$v['id'];
			$newv['pId']=$v['parentid'];
			$newv['name']=$v['name'];
			$newv['type']='post';
			$newv['url']='__URL__/index/jump/1/id/'.$v['id'];
			$newv['target']='ajax';
			$newv['rel']='misfinanceexpensestypeBox';
			$newv['open']='true';
			array_push($returnarr,$newv);
		}
		return json_encode($returnarr);
	}
	
    /**
     * @Title: update
     * @Description: todo(重写CommonAction的update方法，更新)
     * @return string
     * @author yangxi
     * @date 2013-5-31 下午3:59:44
     * @throws
     */    	
	public function update(){
		//取得原父节点与现父节点值及当前操作节点
		$parentid=$_POST["parentid"];
		$oldparentid=$_POST["oldparentid"];
		$id=$_REQUEST["id"];
		//自己不能与自己调换
		if($id==$parentid){
			$this->error ("新上级节点不能是本身！");
		}
		//当存在父节点时验证
		if($parentid){
			 if($parentid==$oldparentid){
				$this->error ("原父节点与调换节点相同，请检查！");
			}
		}
		else{
			//没选新上级时默认添加顶级节点
			if($_POST["parentid"]==0){
				$oldparentid=0;
			}else{
				//父节不变时，将父节点值赋为旧父节点值
				$_POST["parentid"]=$oldparentid;
			}
		}
		$model = D ("MisFinanceExpensesType");
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		// 更新数据
		$list=$model->save ();
		//		print_r($model->getLastSql());
		//		exit;
		if (false !== $list) {
			//执行成功则对新父节点的父节点做更新
			//如果新父节点的父节点与当前操作节点相同则执行改变
			$sign= $model->where("id=".$parentid)->getField("parentid");
			if($sign==$id){
				$maps['parentid']=$oldparentid;
				$model->where("id=".$parentid)->save($maps);
			}
			//	    print_r($model->getLastSql());
			//		exit;
			//成功提示，并提交事务
			$this->success ( L('_SUCCESS_'));
		} else {
			$this->error ( L('_ERROR_') );
		}
	}
	
	/**
	 * @Title: _before_delete
	 * @Description: todo(delete方法调用前运行)
	 * @return string
	 * @author yangxi
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	
	public function _before_delete(){
		$typeid = $_REQUEST['id'];
		if ($typeid) {
			$map['id'] = $typeid;
			$misFinanceExpensesSubModel=M("mis_finance_expenses_sub");
			$count=$misFinanceExpensesSubModel->where("typeid=".$typeid)->count();
			if($count>0)
			{
				$hasexpenses=1;
				$this->assign("hasexpenses",$hasexpenses);
			}
		}
	}
	
	/**
	 * @Title: delete
	 * @Description: todo(重写CommonAction的delete方法，删除)
	 * @return string
	 * @author yangxi
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function delete(){
		$typeid=$_REQUEST['id'];
		$name=$this->getActionName();
		$model=D($name);
		//判断是否有下节点
		$list=$model->where("parentid=".$typeid)->select();
		$oldparentid=$model->where("id=".$typeid)->getField("parentid");
		//判断是否为顶级节点，顶级节点父节点为0
		if($oldparentid==0){
			$this->error("此类型为顶级节点，不能删除");
		}else if($list){
			$this->error("此类型下存在子类，不能删除");
		}else{
			$checkModel=M("mis_finance_expenses_sub");
			$count=$checkModel->where("typeid=".$typeid)->count();
			if($count>0)
			{
			 //如果关联记录大于1，不允许删除请在这里处理
			 $this->error("删除失败,此类型下存在费用明细",true);
			}
			else{
				$as=$model->where("id=".$typeid)->setField("status","-1");
				if($as){
					$this->success("删除成功",true);
				}else{
					$this->error("删除失败",true);
				}
			}
		}
	}
}