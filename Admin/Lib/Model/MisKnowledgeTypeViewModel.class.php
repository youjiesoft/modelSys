<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(知识库) 
 * @author yuansl 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-1-9 下午2:54:44 
 * @version V1.0
 */
class MisKnowledgeTypeViewModel extends ViewModel{
// 	public function gettype(){
// 		$sql = "SELECT  mis_knowledge_type.id,
// 				mis_knowledge_type.parentid,
// 				mis_knowledge_type.name FROM `mis_knowledge_list`,	mis_knowledge_type 	WHERE mis_knowledge_list.categoryid = mis_knowledge_type.id AND mis_knowledge_type.parentid = 0";
// 		$effectarr = $this->query($sql);
// 		return $effectarr;		
// 	}
	public $viewFields = array(
			"mis_knowledge_type"=>array(
					'_as'=>'mis_knowledge_type',
					'id',
					'parentid',
					'name',
					'_type'=>'LEFT'
			),
			"mis_knowledge_list"=>array(
					'id'=>'articleid',
					'type',
					'createid',
					'categoryid',
					'createtime',
					'title',
					'content',
					'levels',
					'totop',
					'highlight',
					'isread',
					'count',
					'_as'=>'mis_knowledge_list',
					'_on'=>'mis_knowledge_type.id=mis_knowledge_list.categoryid'
			),
	);
}



















?>