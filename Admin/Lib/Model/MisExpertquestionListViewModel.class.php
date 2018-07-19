<?php
 class MisExpertquestionListViewModel extends ViewModel{

	public $viewFields = array(
		'mis_expert_question_list'=>array('_as'=>'mis_expert_question_list','id','type','parentid','askid','categoryid','closereason','askto','selchildid','closedbyid','title','content','createid','acount','createtime','sourcetype','expertype','sourceid','expertid','isynchronous','status','_as'=>'mis_expert_question_list','_type'=>'LEFT'),
		'mis_expert_question_type'=>array('_as'=>'mis_expert_question_type','name'=>'typename','_on'=>'mis_expert_question_type.id=mis_expert_question_list.categoryid','_type'=>'LEFT'),
		'user' =>array('_as'=>'user','name','_on'=>'user.id=mis_expert_question_list.createid','_type'=>'LEFT'),
		'mis_hr_personnel_person_info'=>array('_as'=>'mis_hr_personnel_person_info','picture','_on'=>'user.employeid=mis_hr_personnel_person_info.id','_type'=>'LEFT'),
	);
}
?>