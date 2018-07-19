<?php
class MisSalePIIndicatorAction extends commonAction{
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
}