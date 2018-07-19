<?php
/**
 * @Title: MisFinanceRateAction
 * @Package 财务配置-汇率信息：功能类
 * @Description: TODO(汇率的记录及维护)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
 */
class MisFinanceRateAction extends CommonAction{
	/**
	 * @Title: _filter
	 * @Description: todo(重写CommonAction的_filter方法，传递过滤参数后返回列表页面)
	 * @return string
	 * @author yangxi
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */	
	public function _filter(&$map){
		if(empty($_REQUEST['status'])){
		 if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
		}
	}
	
	/**
	 * @Title: _before_add
	 * @Description: todo(add页面打开前传递展示信息)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */	
	
	public function _before_add(){
	 	$model=M('mis_finance_currency');
	 	$list=$model->where("status = 1")->select();
	 	$list1=$model->where("status = 1 and basecurr =1")->select();
	 	$this->assign('vlist',$list);
	 	$this->assign('vlist1',$list1);
	 }
	 /**
	  * @Title: _before_edit
	  * @Description: todo(edit页面前传入数据)
	  * @return string
	  * @author 杨希
	  * @date 2013-5-31 下午3:59:44
	  * @throws
	  */
	public function _before_edit(){
 	   	$model = M('mis_finance_rate');
		$id = $_REQUEST [$model->getPk ()];
		$vo = $model->getById ( $id );
		$this->assign( 'vo', $vo );
		$model=M('mis_finance_currency');
	 	$list=$model->where("status = 1")->select();
	 	$list1=$model->where("status = 1 and basecurr =1")->select();
	 	$this->assign('vlist',$list);
	 	$this->assign('vlist1',$list1);
	}
	
	/**
	 * @Title: _before_insert
	 * @Description: todo(插入方法insert前执行操作)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	
	public 	function _before_insert(){
		$map['crfrom'] = $_POST['crfrom'];
		$map['crto'] = $_POST['crto'];
		if($map['crfrom'] == $map['crto']){
			$this->error('币别不能一致，请重新输入');
		}
	}
	
	/**
	 * @Title: _before_update
	 * @Description: todo(更新方法update前执行操作)
	 * @return string
	 * @author 杨希
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public 	function _before_update(){
		$map['crfrom'] = $_POST['crfrom'];
		$map['crto'] = $_POST['crto'];
		if($map['crfrom'] == $map['crto']){
			$this->error('币别不能一致，请重新输入');
		}
	}
}
?>