<?php
/**
 * @Title: MisSaleBasicIndicatorAction
 * @Package package_name
 * @Description: todo(动态表单_自动生成-指标)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-10-08 11:21:48
 * @version V1.0
*/
class MisSaleBasicIndicatorAction extends CommonAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)
			$map['status']=array("gt",-1);
	}
	public function index(){
		$name=$this->getActionName();
		$this->getSystemConfigDetail($name);
		$model=D($name);
		//查询当前所有行业类型
		$list=$model->where('status = 1')->order('orderno')->select();
		//封装行业类型结构树
		$listnew = $list;
		foreach($listnew as $k=>$v){
			$listnew[$k]['name'] = "(".$v['orderno'].")".$v['name'];
		}
		$param['rel']="MisSaleBasicIndicatorBox";
		$param['url']="__URL__/index/jump/1/zb/#id#";
		$treemiso[]=array(
				'id'=>0,
				'pId'=>0,
				'name'=>'基础指标',
				'title'=>'基础指标',
				'open'=>true,
				'isParent'=>true,
		);
		$defaultId = cookie::get("indicatorinfoid");// 新增时默认选中 cookie
		$defaultId=$defaultId?$defaultId:0;
		$this->assign("defaultId",$defaultId);
		$treearr = $this->getTree($listnew,$param,$treemiso,false);
		$this->assign("treearr",$treearr);
		//获取行业ID
		$zb = $_REQUEST['zb']?$_REQUEST['zb']:$defaultId;
		//定义一个存储行业数据数组
		$vo = array();
		if($zb){
			$map['id'] = $zb;
			$vo=$model->where($map)->find();
		}else{
			if($list){
				//判断是否存在行业
				$vo = $list[0];
				$zb = $list[0]['id'];
			}
		}
		$this->assign("valid",$zb);
		$this->assign("vo",$vo);
		
		if($_REQUEST['jump'] == 1){
			$this->display("indexview");
		}else{
			$this->display();
		}
	}
	function _before_insert(){
		$name = $this->getActionName();
		$orderno = $_POST['orderno'];
		$MisSystemOrdernoDao = D("MisSystemOrderno");
		$data = $MisSystemOrdernoDao->validateOrderno($name,$orderno);
		if($data['result']){
			$_POST['parentid'] = $data['parentid'];
			
		}else{
			$this->error($data['altMsg']);
		}
	}
	public function _before_update(){
		$name = $this->getActionName();
		$orderno = $_POST['orderno'];
		$MisSystemOrdernoDao = D("MisSystemOrderno");
		$data = $MisSystemOrdernoDao->validateOrderno($name,$orderno,$_POST['id']);
		if($data['result']){
			$_POST['parentid'] = $data['parentid'];
		}else{
			$this->error($data['altMsg']);
		}
	}
}
?>