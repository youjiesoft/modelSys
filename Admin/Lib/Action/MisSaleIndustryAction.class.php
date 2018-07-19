<?php
/**
 * @Title: MisSalesIndustryAction
 * @Package package_name
 * @Description: todo(动态表单_自动生成-产业链)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-09-25 14:28:26
 * @version V1.0
*/
class MisSaleIndustryAction extends CommonAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)
			$map['status']=array("gt",-1);
	}
	public function index(){
		$name=$this->getActionName();
		$this->getSystemConfigDetail($name);
		$model=D($name);
		//查询当前所有行业类型
		$list=$model->where('status = 1')->order("orderno")->select();
		//封装行业类型结构树
		$listnew = $list;
		foreach($listnew as $k=>$v){
			$listnew[$k]['name'] = "(".$v['orderno'].")".$v['name'];
		}
		$param['rel']="MisSalesIndustryview";
		$param['url']="__URL__/index/jump/1/cy/#id#";
		$treemiso[]=array(
				'id'=>0,
				'pId'=>0,
				'name'=>'产业链档案',
				'title'=>'产业链档案',
				'open'=>true,
				'isParent'=>true,
		);
		$treearr = $this->getTree($listnew,$param,$treemiso,false);
		$this->assign("treearr",$treearr);
		//获取行业ID
		$cy = $_REQUEST['cy'];
		//定义一个存储行业数据数组
		$vo = array();
		if($cy){
			$map['id'] = $cy;
			$vo=$model->where($map)->find();
		}else{
			if($list){
				//判断是否存在行业
				$vo = $list[0];
				$cy = $list[0]['id'];
			}
		}
		$this->assign("valid",$cy);
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
	public function _before_delete(){
		$name = $this->getActionName();
		$map['parentid'] = $_REQUEST['id'];
		$map['status'] = 1;
		$model = D($name);
		$data = $model->where($map)->select();
		if($data){
			$this->error('此类下面有分类，不能删除');
		}
	}
}
?>