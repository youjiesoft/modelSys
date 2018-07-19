<?php
/**
 * @Title: MisProductUnittypeAction 
 * @Package package_name
 * @Description: todo(产品单位类型) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-6-1 下午2:36:57 
 * @version V1.0
 */
class MisProductUnittypeAction extends CommonAction{
	/**
	 * @Title: _filter 
	 * @Description: todo(构造检索条件) 
	 * @param unknown_type $map  
	 * @author renling 
	 * @date 2013-5-31 下午5:17:05 
	 * @throws
	 */
	public function _filter(&$map){
	if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
	}
}