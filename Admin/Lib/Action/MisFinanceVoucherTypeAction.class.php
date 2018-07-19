<?php
/**
 * @Title: MisFinanceVoucherTypeAction
 * @Package 财务模块-凭证分录分类：功能类
 * @Description: TODO(凭证分录分类的处理)
 * @author wangcheng
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
 */
class MisFinanceVoucherTypeAction extends CommonAction  {
	/** @Title: _filter
	 * @Description: (构造检索条件)
	 * @author
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */	
	public function _filter(&$map) {
		 if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
	}
}
?>