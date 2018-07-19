<?php
	/**
	 * @Title: 视图类 
	 * @Package package_name 
	 * @Description: todo(专家顾问功能视图) 
	 * @author yuansl 
	 * @company 重庆特米洛科技有限公司
	 * @copyright 本文件归属于重庆特米洛科技有限公司
	 * @date 2014-1-22 上午10:16:56 
	 * @version V1.0
	 */
	class MisExpertQuestionViewModel extends  ViewModel {
		public $viewFields = array(
				"mis_expert_question_type"=>array(
						'_as'=>'mis_expert_question_type',
						'id',
						'name',
						'pid',
						'status',
						'_type'=>'LEFT'
				),
				"mis_expert_question_list"=>array(
						'id'=>'questionid',
						'type',//回复,提问,追问 'Q','A','C','Q_HIDDEN','A_HIDDEN','C_HIDDEN','Q_QUEUED','A_QUEUED','C_QUEUED','NOTE','ASK'
						'parentid',//该条回复所属的问题的id
						'createid',//创建人
						'categoryid',//该问题的分类id
						'closedbyid',//关闭该问题的人的id
						'createtime',
						'acount',
						'selchildid',//最佳答案
						'operateid',//操作人id
						'updateid',//更新人的id
						'views',//问题的状态
						'flagcount',//举报次数
						'createtime',//创建时间
						'updatetime',
						'title',
						'content',
						'expertid',//专家的id
						'status',
						'companyid',//公式id
						'expertype',//提问对象0专家1任务发布人2任务跟踪人
						'sourcetype',//来源  0---无    1----任务管理
						'sourceid',//问题来源id
						'isynchronous',//问题是否同步   0---已同步    1----未同步
						'closereason',//关闭标识
						'askto',//追问
						'askid',//追问id
						'count',//点击数
						'_as'=>'mis_expert_question_list',
						'_on'=>'mis_expert_question_type.id=mis_expert_question_list.categoryid'
				),
		);
	}