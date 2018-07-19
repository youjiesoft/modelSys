<?php
/**
 * @Title: MisFinanceBankAccountAction
 * @Package 财务配置-银行账号信息：功能类
 * @Description: TODO(银行账号信息的记录及维护)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2012-6-10 19:18:54
 * @version V1.0
 */
class MisFinanceBankAccountAction extends CommonAction{
	/**
	 * @Title: _filter
	 * @Description: todo(重写CommonAction的_filter方法，传递过滤参数后返回列表页面)
	 * @return string
	 * @author yangxi
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function _filter(&$map){
		 if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
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
		//银行信息
		$banklist = D('MisFinanceBank')->where('status = 1')->select();
		$this->assign("banklist", $banklist);
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
		//银行信息
		$banklist = D('MisFinanceBank')->where('status = 1')->select();
		$this->assign("banklist", $banklist);
	}
}
?>