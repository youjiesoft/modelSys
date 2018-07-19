<?php
/**
 * @Title: MisSalesProfessionAction
 * @Package package_name
 * @Description: todo(动态表单_自动生成-行业)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-09-25 14:28:00
 * @version V1.0
*/
class MisSaleProfessionAction extends CommonAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)
			$map['status']=array("gt",-1);
	}
	/* (non-PHPdoc)
	 * @see CommonAction::index()
	 */
	public function index(){
		$name=$this->getActionName();
		$this->getSystemConfigDetail($name);
		$model=D($name);
		//查询当前所有行业类型
		$list=$model->where('status >=0')->select();
		//封装行业类型结构树
		$listnew = $list;
		foreach($listnew as $k=>$v){
			$listnew[$k]['name'] = "(".$v['orderno'].")".$v['name'];
		}
		$param['rel']="MisSaleProfessionview";
		$param['url']="__URL__/index/jump/1/hy/#id#";
		$treemiso[]=array(
				'id'=>0,
				'pId'=>0,
				'name'=>'行业档案',
				'title'=>'行业档案',
				'open'=>true,
				'isParent'=>true,
		);
		$treearr = $this->getTree($listnew,$param,$treemiso,false);
		$this->assign("treearr",$treearr);
		//获取行业ID
		$hy = $_REQUEST['hy'];
		//定义一个存储行业数据数组
		$vo = array();
		if($hy){
			$map['id'] = $hy;
			$vo=$model->where($map)->find();
		}else{
			if($list){
				//判断是否存在行业
				$vo = $list[0];
				$hy = $list[0]['id'];
			}
		}
		$this->assign("valid",$hy);
		$this->assign("vo",$vo);
		
		if($_REQUEST['jump'] == 1){
			$this->display("indexview");
		}else{
			$this->display();
		}
	}
	/**
	 * @Title: _before_insert
	 * @Description: 插入之前，验证编码方案是否正确符合规定
	 * @author 黎明刚 
	 * @date 2014年11月3日 上午11:03:07 
	 * @throws
	 */
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