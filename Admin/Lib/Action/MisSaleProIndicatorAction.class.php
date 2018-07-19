<?php
class MisSaleProIndicatorAction extends CommonAction{
	public function index(){
//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name = $this->getActionName();
		if (! empty ( $name )) {
			$qx_name=$name;
			if(substr($name, -4)=="View"){
				$qx_name = substr($name,0, -4);
			}
			//验证浏览及权限
			if( !isset($_SESSION['a']) ){
				$map=D('User')->getAccessfilter($qx_name,$map);
			}
			$this->_list ( "MisSaleProIndicatorView", $map );
		}
		//begin
		$scdmodel = D('SystemConfigDetail');
		//读取列名称数据(按照规则，应该在index方法里面)
		$detailList = $scdmodel->getDetail($name);
		//var_dump($detailList);
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
		//扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		//end

		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");
		}
		//首页收件箱调用方法，为ajax调用
		if ($_GET['type'] == "ajaxcall") {
			$this->display ("ajax_index");exit;
		}
		if($_REQUEST['jump'] == "jump"){
			$this->display('indexview');exit;
		}
		$this->display ();
	}
	public function _before_add(){
		$mode = D('MisSalePI');
		$list = $mode->professionlevel();
		$this->assign('list',$list);
		$model = M("mis_sale_basic_indicator");
		$indicator = $model->where("status=1")->select();
		$this->assign('indicator',$indicator);
// 		$model=M("mis_sale_profession");
// 		$plist = $model->select();
// 		$this->assign('plist',$plist);
		$model = M("mis_sale_industry");
		$ilist = $model->select();
		$this->assign('ilist',$ilist);
	}
	public function insert(){
		$name=$this->getActionName();
		$model = D ($name);
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		//保存当前数据对象
		$professionid="";
		foreach ($_POST['professionid'] as $key=>$val){
			if($val!=-1){
				$professionid=$val;
			}
		}
		$data['professionid'] = $professionid;
		$data['industryid'] = $_POST['industryid'];
		$data['remark'] = $_POST['remark'];
		$indicatorid = $_POST['indicatorid'];		
		foreach($indicatorid as $v){
			$data['indicatorid'] = $v;
			$unique = $model->where("prefessionid=".$data['prefessionid']." and industryid=".$data['industryid']." and indicatorid=".$v)->find();
			if($unique) continue;
			$list=$model->add($data);
		}
		if ($list!==false) {
			$mrdmodel = D('MisRuntimeData');
			$mrdmodel->setRuntimeCache($_POST,$name,'add');
			$module2=A($name);
			if (method_exists($module2,"_after_insert")) {
				call_user_func(array(&$module2,"_after_insert"),$list);
			}
			$this->success ( L('_SUCCESS_') ,'',$list);
			exit;
		} else {
			$this->error ( L('_ERROR_') );
		}
	}
	public function edit(){
		//获取当前控制器名称
		$name=$this->getActionName();
		$model = D ( $name );
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$map['id']=$id;
		$vo = $model->where($map)->find();
		if(empty($vo)){
			$this->display ("Public:404");
			exit;
		}
		$model = M("mis_sale_profession");
		$pro = $model->where("id=".$vo['professionid'])->find();
		$mode = D('MisSalePI');
		$list = $mode->professionlevel();
		$this->assign('list',$list);
		$model = M("mis_sale_profession");
		$arr = $model->select();
		$prof = $model->where("id=".$vo['professionid'])->find();
		$proid = $this->findjiapu2($arr,$prof['id']);
		$proid=substr($proid,2);
		$this->assign('proid',$proid);
		$model = M("mis_sale_basic_indicator");
		$indicator = $model->where("status=1")->select();
		$this->assign('indicator',$indicator);
		$this->assign( 'vo', $vo );
		$indica = $model->where("id=".$vo['indicatorid'])->find();
		$this->assign('indica',$indica);
		$model = M('mis_sale_industry');
		$indu = $model->select();
		$this->assign('indu',$indu);
		$induid=$model->where("id=".$vo['industryid'])->find();
		$this->assign('induid',$induid);
		$this->display ();
	}
	function update(){
	$name=$this->getActionName();
		$model = D ( $name );
		if (false === $data = $model->create ()) {
			$this->error ( $model->getError () );
		}
		$professionid="";
		foreach ($_POST['professionid'] as $key=>$val){
			if($val!=-1){
				$professionid=$val;
			}
		}
		$data['professionid'] = $professionid;
		// 更新数据
		//print_r($model);exit;
		$list=$model->save ($data);
		if (false !== $list) {
			$module2=A($name);
			if (method_exists($module2,"_after_update")) {
				call_user_func(array(&$module2,"_after_update"),$list);
			}
			$this->success ( L('_SUCCESS_'));
		} else {
			$this->error ( L('_ERROR_') );
		}
	}
	public function _before_view(){
		//获取当前控制器名称
		$name=$this->getActionName();
		$model = D ( $name );
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$map['id']=$id;
		$vo = $model->where($map)->find();
		if(empty($vo)){
			$this->display ("Public:404");
			exit;
		}
		$this->assign( 'vo', $vo );
		$model = M("mis_sale_profession");
		$pro = $model->where("id=".$vo['professionid'])->find();
		$this->assign('pro',$pro['name']);
		$model = M("mis_sale_basic_indicator");
		$indicator = $model->where("id=".$vo['indicatorid'])->find();
		$this->assign('ind',$indicator);
		$model = M('mis_sale_industry');
		$induid=$model->where("id=".$vo['industryid'])->find();
		$this->assign('induname',$induid['name']);
	}
 //找数组父级
	function findjiapu2($area,$id){
	   $row=$id;
	    while($id!=0){//只要id不为0就找家谱
	    foreach($area as $v){
	      if($v['id']==$id){//找到id为8的那条记录
	        $row=$row?$v['pid'].','.$row:$v['pid'];//找到的记录加到数组中
	        $id=$v['pid'];//赋值id=2（因为id为8的parent为2）  ，作为下次foreach所用 
	        break;//跳出foreach循环，进行下个id（2）的查询
	      }
	    }
	  }
	    return $row;
	}
}





























