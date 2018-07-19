<?php
/**
 * @Title: MisValueEditRulesModel
 * @Package package_name
 * @Description: todo(值更新规则Model)
 * @author benjamin
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2017-4-25 10:04
 * @version V1.0
 */
class MisValueEditRulesModel extends CommonModel{
	protected $trueTableName = 'mis_value_edit_rules';

	/**
	 * 获取表单控件规则
	 * @param $formid
	 * @param $propertyid
	 */
	public function getrules($formid,$propertyid=null){
		$map['formid']=$formid;
		if($propertyid) {
			$map['property_id'] = $propertyid;
		}
		return $this->where($map)->order('my_sort asc')->select();
	}

	/**
	 * 获取有规则的表单控件
	 * @param $formid
	 */
	public function getrulesproperty($formid){
		$sql="select id,category,fieldname,title from mis_dynamic_form_propery where id in(select property_id from mis_value_edit_rules group by formid,property_id) and formid={$formid}";
		$res=$this->query($sql);
		return $res;
	}

	/**
	 * 获取表单控件规则树形结构
	 * @param $formid
	 * @return mixed
	 */
	public function getpptyrulestree($formid){
		$ppys=$this->getrulesproperty($formid);
		$rules=$this->getrules($formid);
		if(!empty($ppys)&&!empty($rules)){
			foreach($ppys as $k=>$v) {
				foreach ($rules as $key => $val) {
					if ($val['property_id'] ==$v['id']){
						$ppys[$k]['rules'][]=$val;
						$ppys[$k]['edit_type']=$val['edit_type'];
					}
				}
			}
		}
		return $ppys;
	}
}