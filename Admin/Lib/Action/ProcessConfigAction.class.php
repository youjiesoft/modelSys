<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(流程配置-走势) 
 * @author 杨东 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-6-1 下午2:17:53 
 * @version V1.0
 */
class ProcessConfigAction extends CommonAction {
	/**
	 * (non-PHPdoc)
	 * 首页列表展示输出模板页面
	 * @see CommonAction::index()
	 */
	public function index(){
		$model = D('ProcessConfig');
		$list = $model->getProcessConfig();
		$model2 = D('ProcessInfo');
		$plist = $model2->where('status = 1')->select();
		$this->assign('plist',$plist);
		$model = M("process_type");
		$typelist = $model->where("status = 1")->select();
		$this->assign ('typelist',$typelist);
		$this->assign('list',$list);
		$this->display();
	}
	/**
	 * (non-PHPdoc)
	 * 修改方法
	 * @see CommonAction::update()
	 */
	public function update() {
		$model = D('ProcessConfig');
		$list = $model->getProcessConfig();
		$modelname = $_POST["modulename"];
		$title = $_POST["title"];
		$processtype = $_POST["processtype"];
		$processlist = $_POST["processlist"];
		$rules = $_POST["rules"];
		$crosslevel = $_POST["crosslevel"];
		
		$list=array();
		foreach ($modelname as $k => $v) {
			$list[$k]['modulename'] = $v;
			$list[$k]['title'] = $title[$k];
			$list[$k]['process_rule']=array();
			foreach($processlist[$k] as $k2=>$v2 ){
				$list[$k]['process_rule'][]=array("pid"=>$v2,"typeid"=>$processtype[$k][$k2],"rules"=>$rules[$k][$k2],"crosslevel"=>$crosslevel[$k][$k2]);
			}
		}
		$model->setProcessConfig($list);
		$this->success( L('_SUCCESS_') );
	}
	/**
	 * @Title: comboxgetprocess 
	 * @Description: todo(页面JS加载动态生成流程选择)   
	 * @author liminggang 
	 * @date 2013-6-1 下午2:18:32 
	 * @throws
	 */
	function comboxgetprocess(){
		$model=M("process_info");
		$typeid =$_POST['typeid'];
		$arr=array(array("","请选择流程"));
		if ($typeid!='') {
			$map['typeid']=$typeid;
			$list = $model->where("typeid =".$typeid." or typeid=0")->select();
			foreach($list as $k=>$v ){
				array_push($arr,array($v['id'], $v['name']));
			}
		}
		
		echo json_encode($arr);
	}
}
?>