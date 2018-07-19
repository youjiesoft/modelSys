<?php
class MisProjectFlowLinkViewModel extends ViewModel {
	
	public $viewFields = array(
	     'mis_project_flow_form'=>array('_as'=>'mis_project_flow_form','id'=>'id','name'=>'name','critical'=>'critical','complete'=>'complete'),
	     'mis_project_flow_link'=>array('_as'=>'mis_project_flow_link','predecessorid','successorid','type','_on'=>'mis_project_flow_form.id=mis_project_flow_link.id'),
	   );
}
?>