<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(借款申请类型) 
 * @author libo 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-6-20 上午10:48:57 
 * @version V1.0
 */
class MisFinanceBorrowmasTypeAction extends CommonAction{
	public function _filter(&$map){
		if( !isset($_SESSION['a']) ){
			$map['status']=1;
		}
	}
}