<?php
/**
 * @Title: MisSaleBusinessSourceAction
 * @Package package_name
 * @Description: todo(动态表单_自动生成-商机来源)
 * @author 管理员
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2015-08-15 13:01:16
 * @version V1.0
*/
class MisSaleBusinessSourceAction extends MisSaleBusinessSourceExtendAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1){
			$map['status']=array("gt",-1);
		}
		$this->_extend_filter($map);
	}
	/**
	 * @Title: index
	 * @Description: todo(重写父类index函数)
	 * @author 管理员
	 * @date 2015-08-15 13:01:16
	 * @throws 
	*/
	function index(){		
		$name=$this->getActionName();
		//读取配置文件字段列信息
		$this->getSystemConfigDetail($name);
		$model=D($name);
		//查询当前模型数据类型
		$list=$model->where('status = 1')->select();
		//封装数据类型结构树
		$listnew = $list;
		foreach($listnew as $k=>$v){
			$listnew[$k]['name'] = "(".$v['orderno'].")".$v['name'];
		}
		$param['rel']="MisSaleBusinessSourceview";
		$param['url']="__URL__/index/jump/1/hy/#id#";
		$treemiso[]=array(
				'id'=>0,
				'pId'=>0,
				'name'=>'商机来源',
				'title'=>'商机来源',
				'open'=>true,
				'isParent'=>true,
		);
		$treearr = $this->getTree($listnew,$param,$treemiso);
		$this->assign("treearr",$treearr);
		//获取数据ID
		$hy = $_REQUEST['hy'];
		//定义一个存储数据数组
		$vo = array();
		if($hy){
			$map['id'] = $hy;
			$vo=$model->where($map)->find();
		}else{
			//判断是否有cookie默认 (作用于刷新)
			$cookiecheck = Cookie::get("MisSaleBusinessSourceview");
			Cookie::delete("MisSaleBusinessSourceview");
			if($cookiecheck){
				$hy = $cookiecheck;
				$map['id'] = $cookiecheck;
				$vo=$model->where($map)->find();
			}else{
				if($list){
					//判断是否存在数据信息
					$vo = $list[0];
					$hy = $list[0]['id'];
				}
			}			
		}
		//数据删除的默认选中ID (关联到toolbar配置文件)
		$_REQUEST['defaultid'] = $hy?$hy:0;
		$this->assign("valid",$hy);
		$this->assign("vo",$vo);
		//扩展工具栏操作
		$scdmodel = D('SystemConfigDetail');
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		if($_REQUEST['jump'] == 1){
			$this->display("indexview");
		}else{
			$this->display();
		}
	}
	/**
	 * @Title: edit
	 * @Description: todo(重写父类编辑函数)
	 * @author 管理员
	 * @date 2015-08-15 13:01:16
	 * @throws 
	*/
	function edit($isdisplay=1){
		$mainTab = 'mis_sale_business_source';
		//获取当前控制器名称
		$name=$this->getActionName();
		$model = D("MisSaleBusinessSourceView");
		//获取当前主键
		$map[$mainTab.'.id']=$_REQUEST['id'];
		$vo = $model->where($map)->find();
		if(!$vo){
		$this->getFormIndexLoad($vo);
		}
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		//读取动态配制
		$this->getSystemConfigDetail($name);
		//扩展工具栏操作
		$scdmodel = D('SystemConfigDetail');
		// 上一条数据ID
		$map['id'] = array("lt",$id);
		$updataid = $model->where($map)->order('id desc')->getField('id');
		$this->assign("updataid",$updataid);
		// 下一条数据ID
		$map['id'] = array("gt",$id);
		$downdataid = $model->where($map)->getField('id');
		$this->assign("downdataid",$downdataid);
		//lookup带参数查询
		$module=A($name);
		if (method_exists($module,"_after_edit")) {
			call_user_func(array($module,"_after_edit"),$vo);
		}
		$this->assign( 'vo', $vo );
		if($isdisplay)
		$this->display ();
	}
	/**
	 * @Title: _before_index
	 * @Description: todo(前置index函数)
	 * @author 管理员
	 * @date 2015-08-15 13:01:16
	 * @throws 
	*/
	function _before_index() {
		$this->_extend_before_index();
	}
	/**
	 * @Title: _before_edit
	 * @Description: todo(前置编辑函数)
	 * @author 管理员
	 * @date 2015-08-15 13:01:16
	 * @throws 
	*/
	function _before_edit(){
		$mainTab = 'mis_sale_business_source';
		//获取当前控制器名称
		$name=$this->getActionName();
		$model = D("MisSaleBusinessSourceView");
		//获取当前主键
		$map[$mainTab.'.id']=$_REQUEST['id'];
		$vo = $model->where($map)->find();
		$this->assign( 'vo', $vo );
		$this->_extend_before_edit();
	}
	/**
	 * @Title: _before_insert
	 * @Description: todo(新增前置函数，验证新增数据是否满足条件)
	 * @author 管理员
	 * @date 2015-08-15 13:01:16
	 * @throws 
	*/
	function _before_insert(){		
		// 插入之前，验证编码方案是否正确符合规定 @2015-08-15 13:01:16
		$name = $this->getActionName();
		$orderno = $_POST['orderno'];
		$MisSystemOrdernoDao = D("MisSystemOrderno");
		$data = $MisSystemOrdernoDao->validateOrderno($name,$orderno);
		if($data['result']){
			$_POST['parentid'] = $data['parentid'];
			
		}else{
			$this->error($data['altMsg']);
		}
		$this->_extend_before_insert();
	}
	/**
	 * @Title: _before_update
	 * @Description: todo(修改前置函数，验证数据是否满足条件)  
	 * @author 管理员
	 * @date 2015-08-15 13:01:16
	 * @throws
	*/
	function _before_update(){		
		//插入之前，验证编码方案是否正确符合规定 @2015-08-15 13:01:16
		$name = $this->getActionName();
		$orderno = $_POST['orderno'];
		$MisSystemOrdernoDao = D("MisSystemOrderno");
		$data = $MisSystemOrdernoDao->validateOrderno($name,$orderno,$_POST['id']);
		if($data['result']){
			$_POST['parentid'] = $data['parentid'];
		}else{
			$this->error($data['altMsg']);
		}
		$this->_extend_before_update();
	}
	/**
	 * @Title: _before_update
	 * @Description: todo(删除前置函数,验证数据是否满足条件)  
	 * @author 管理员
	 * @date 2015-08-15 13:01:16
	 * @throws
	*/
	function _before_delete(){		//删除之前，验证当前数据是否可删除 @2015-08-15 13:01:16
		$name = $this->getActionName();
		$map['parentid'] = $_REQUEST['id'];
		$map['status'] = 1;
		$model = D($name);
		$data = $model->where($map)->select();
		if($data){
			$this->error('该条数据下有子数据，不能删除');
		}
		$this->_extend_before_delete();
	}
	/**
	 * @Title: _after_edit
	 * @Description: todo(后置编辑函数)
	 * @author 管理员
	 * @date 2015-08-15 13:01:16
	 * @throws 
	*/
	function _after_edit($vo){
		$this->_extend_after_edit($vo);
	}
	/**
	 * @Title: _after_insert
	 * @Description: todo(后置insert函数)  
	 * @author 管理员
	 * @date 2015-08-15 13:01:16
	 * @throws
	*/
	function _after_insert($id){
		Cookie::set('MisSaleBusinessSourceview',$id);
		$this->_extend_after_insert($id);
	}
	/**
	 * @Title: _before_add
	 * @Description: todo(前置add函数)  
	 * @author 管理员
	 * @date 2015-08-15 13:01:16
	 * @throws
	*/
	function _before_add(){
		$this->_extend_before_add($vo);
	}
	/**
	 * @Title: _after_update
	 * @Description: todo(后置update函数)  
	 * @author 管理员
	 * @date 2015-08-15 13:01:16
	 * @throws
	*/
	function _after_update(){
		Cookie::set('MisSaleBusinessSourceview',$_POST['id']);
		$this->_extend_after_update();
	}
}
?>