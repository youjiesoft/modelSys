<?php
 class MisExpertListViewModel extends ViewModel{

	public $viewFields = array(
		'mis_expert_list'=>array('_as'=>'mis_expert_list','id','orderno','name','userid','tel','email','qq','picpath','typeid','text','status','_as'=>'mis_expert_list','_type'=>'LEFT'),
		'user' =>array('_as'=>'user','id'=>'user_id','name'=>'user_name','_on'=>'user.id=mis_expert_list.userid','_type'=>'LEFT'),
	);
}
?>