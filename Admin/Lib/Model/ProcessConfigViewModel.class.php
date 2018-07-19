<?php
class ProcessConfigViewModel extends ViewModel {
	public $viewFields = array(
			'processNode' => array('_as'=>'process_node','id','pname','name','title','status','_type'=>'LEFT'),
			'processInfo'=>array('_as'=>'process_info','id'=>'pinfoid','typeid','informpersonid','executorid','pnodeid','rules','crosslevel','_on'=>'process_node.id=process_info.pnodeid'),
	);
}