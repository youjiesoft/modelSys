<?php
/**
 * @Title: MisAttachedTemplateModel 
 * @Package package_name 
 * @Description: todo(项目附件模板子项模型) 
 * @author wangzhaoxia 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-11-06 下午5:27:13 
 * @version V1.0
 */
class MisProjectAttachedTemplateSubViewModel extends ViewModel {
	public $viewFields = array(
			"mis_project_attached_template_sub"=>array('_as'=>'mis_project_attached_template_sub','id','name','isfile','_type'=>'LEFT'),
			"mis_system_attach_file"=>array('_as'=>'mis_system_attach_file','id'=>'fileid','orderno'=>'orderno','position'=>'position','page'=>'page','remark'=>'remark','attachid'=>'attachid','formtype'=>'formtype','_on'=>'mis_system_attach_file.attachid=mis_project_attached_template_sub.id'),

	);
}
?>