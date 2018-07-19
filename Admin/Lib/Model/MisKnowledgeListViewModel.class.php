<?php
 class MisKnowledgeListViewModel extends ViewModel{
	public $viewFields = array(
		'mis_knowledge_list'=>array('_as'=>'mis_knowledge_list','id','title','content','createid','createtime','updatetime','totop','levels','categoryid','type','parentid','status','_as'=>'mis_knowledge_list','_type'=>'LEFT'),
		'user' =>array('_as'=>'user','name','_on'=>'user.id=mis_knowledge_list.createid','_type'=>'LEFT'),
		'mis_knowledge_type' =>array('_as'=>'mis_knowledge_type','name'=>'typename','_on'=>'mis_knowledge_list.categoryid=mis_knowledge_type.id','_type'=>'LEFT'),
	);
}
?>