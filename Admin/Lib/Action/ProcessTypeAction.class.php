<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(流程类型控制器) 
 * @author liminggang 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-6-1 下午2:19:43 
 * @version V1.0
 */
class ProcessTypeAction extends CommonAction {
	/**
	 * @Title: _filter 
	 * @Description: todo(首页列表展示输出模板过滤器) 
	 * @param unknown_type $map  
	 * @author liminggang 
	 * @date 2013-6-1 下午2:19:56 
	 * @throws
	 */
	public function _filter(&$map){
		if ($_SESSION["a"] != 1){
			$map['status']=array("gt",0);
		}
	}
	/**
	 * @Title: _before_add 
	 * @Description: todo(新增之前操作数据)   
	 * @author liminggang 
	 * @date 2013-6-1 下午2:20:18 
	 * @throws
	 */
	public function _before_add(){
		$this->common();
	}
	/**
	 * @Title: _before_edit 
	 * @Description: todo(编辑之前操作数据方法)   
	 * @author liminggang 
	 * @date 2013-6-1 下午2:20:30 
	 * @throws
	 */
	public function _before_edit(){
		$map["id"]=array("neq",$_REQUEST["id"]);
		$this->common($map);
	}
	/**
	 * @Title: common 
	 * @Description: todo(公共方法，调用型) 
	 * @param unknown_type $map  
	 * @author liminggang 
	 * @date 2013-6-1 下午2:20:45 
	 * @throws
	 */
	private function common( $map=array() ){
		$m=M("process_type");
		$map["status"]=1;
		$knowleagetype=$m->where($map)->getField("id,name");
		$this->assign("knowleagetype",$knowleagetype);
	}
}
?>