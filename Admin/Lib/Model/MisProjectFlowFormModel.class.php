<?php
/**
 * @Title: MisProjectFlowFormModel
 * @Package 实际项目-任务间链接：模型类
 * @Description: TODO(项目节点与任务)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2014-10-18 19:18:54
 * @version V1.0
 */
class MisProjectFlowFormModel extends MisSystemFlowFormModel {
	protected $trueTableName = 'mis_project_flow_form';
	public $_auto =array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			
			array('begintime','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('endtime','dateToTimeString',self::MODEL_BOTH,'callback'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
			
	);
	/**
	 * @Title: setWorkComplete
	 * @Description: todo(根据任务ID和项目ID更新项目进度状态) 
	 * @param 当前任务ID $workid
	 * @param 当前项目ID $projectid
	 * @param 验证列表 $step  状态为1 表示直接模板执行是否完成任务，但是需要验证是否为列表数据，其他表示无需验证。
	 * @return boolean  
	 * @author 黎明刚
	 * @date 2015年1月9日 上午11:08:18 
	 * @throws
	 */
	public function setWorkComplete($workid,$projectid,$step=1){
		//判断传入任务节点是否为NULL
		if($workid){
			//当前任务完成，验证当前任务是否是动态阶段任务
			$where = array();
			$where['id'] = $workid;
			$workvo = $this->where($where)->field('formtype,formobj,rules,rulesinfo,dycon')->find();
			if($workvo['formtype'] == 2 && $workvo['dycon']){
				//单据类型
				$formOjbModel = D($workvo['formobj']);
				$where = array ();
				$where ['projectid'] = $projectid;
				$where ['projectworkid'] = $workid;
				$where ['_string'] = $workvo['rules'];
				$formobjvo = $formOjbModel->where($where)->order("id desc")->find();
				if($formobjvo){
					//满足条件的数据,就修改动态阶段状态值。
					$where = array();
					$where['projectid'] = $projectid;
					$where['outlinelevel'] = 2;
					$where['orderno'] = array(' in ',explode(",", $workvo['dycon']));
					$flowtype = M ( "mis_project_flow_type" )->where($where)->count ( '*' );
					if($flowtype>0){
						$data = array();
						$data['isshow'] = 0;
						$data['complete'] = 1; //动态阶段一出来就标记为完成
						//存在可以修改的动态阶段
						M ( "mis_project_flow_type" )->where($where)->save($data);
					}
				}else{
					//不存在。则改成不需要执行的任务
					$where = array();
					$where['projectid'] = $projectid;
					$where['outlinelevel'] = 2;
					$where['orderno'] = array(' in ',explode(",", $workvo['dycon']));
					$data = array();
					$data['isshow'] = 1;
					//存在可以修改的动态阶段
					M ( "mis_project_flow_type" )->where($where)->save($data);
				}
			}
			//动态节点部分完成
			
// 			if($step){
				//判断是否为列表数据，如果为列表数据，任务完成将不使用此方法.
// 				$datatype = $this->where("id =".$workid)->getField("datatype");
// 			}else{
// 				$datatype = 0;
// 			}
// 			if($datatype==0){

			if(true){
				//更新任务完成时间
				$where = array();
				$where['id'] = $workid;
				$where['actualendtime'] = time();
				$where['complete'] = 1;
				$result = $this->save($where);
				if ($result === false) {
					return false; // 返回失败
				}
				
				//获取可执行的阶段
				$where = array();
				$where['projectid'] = $projectid;
				$where['outlinelevel'] = 2;
				$where['isshow'] = 0;
				$typeid = M ( "mis_project_flow_type" )->where($where)->getField("uid,id");
				// 当前任务类型，已经没有需要执行的阶段了，则判断是否还有非必须的任务执行 (项目完成标记)
				if($typeid){
					$where = array ();
					$where ['category'] = array(' in ',$typeid);
					$where ['projectid'] = $projectid;
					$where ['complete'] = 0; // 未完成
					$where ['outlinelevel'] = 4; // 任务
					$workcount = $this->where ( $where )->count ( '*' );
					if ($workcount == 0) {
						// 项目完成。
						$MisAutoEbmModel = D ( "MisAutoEbm" );
						$MisAutoEbmModel->where ( "id = " . $projectid )->setField ( "type", 2 );
					}
				}
				$map = array ();
				$map ['id'] = $workid;
				$map ['projectid'] = $projectid;
				//获取节点ID和阶段ID
				$vo = $this->where ( $map )->field("parentid,category")->find();
				if($vo['parentid']>0){
					// 获取阶段
					$map1 ['category'] = $vo['category'];
					$map1 ['projectid'] = $projectid;
					$map1 ['complete'] = 0; // 未完成
					$map1 ['critical'] = 1; // 关键任务
					$map1 ['outlinelevel'] = 4; // 关键任务
					//查询当前阶段是否还有未完成的任务
					$c = $this->where ( $map1 )->count ( '*' );
					if ($c == 0) {
						// 当前阶段为完成(必要任务完成)
						$result = M ( "mis_project_flow_type" )->where ( "id=" . $vo['category'] . " and projectid=" . $projectid )->setField ( 'complete', 1 );
						if ($result === false) {
							return false;
						} else {
							// 更新阶段状态为2，执行中(阶段中还存在未执行)
							$where = array();
							$where ['projectid'] = $projectid;
							$where ['isshow'] = 0; //非动态阶段
							$where ['status'] = 1; // 未完成
							$where ['outlinelevel'] = 2; // 任务
							$where ['complete'] = array('neq',1); // 任务
							$val = M ( "mis_project_flow_type" )->where ($where)->field("id")->order ( 'sort asc' )->select();
							if ($val) {
								foreach($val as $tkey=>$tval){
									//查询后面阶段是否存在任务
									$map1 = array();
									$map1 ['category'] = $tval['id'];
									$map1 ['projectid'] = $projectid;
									$map1 ['complete'] = 0; // 未完成
									$map1 ['critical'] = 1; // 关键任务
									$map1 ['outlinelevel'] = 4; // 关键任务
									$count = $this->where ( $map1 )->count ( '*' );
									if($count > 0){
										// 更新状态，然后跳出循环
										$result = M ( "mis_project_flow_type" )->where ( "id=" . $tval ['id'] . " and projectid=" . $projectid )->setField ( 'complete', 2 );
										break;
									}else{
										// 当前阶段为完成(必要任务完成)
										$result = M ( "mis_project_flow_type" )->where ( "id=" . $tval['id'] . " and projectid=" . $projectid )->setField ( 'complete', 1 );
									}
								}
							}
						}
					} else {
						// 完成判断
						return true;
					}
				}
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	
	/*
	 *
	* 获取当前任务节点，是否能执行下一步
	* @paramate
	* @paramate
	* */
	public function checkNextStep($data){
		$map['category']=$data['category'];
		//是否存在关键任务
		$map['complete']=1;
		//是否没有完成
		$map['complete']=0;
		//$map['hyid']=$data['hyid'];
		//$map['cylid']=$data['cylid'];
		$map['status']=1;
		$model=$this->where($map)->select();
	
		if($model===false){
			//查询错误
			return false;
		}elseif($model===null){
			//返回为NULL
			return true;
		}else{
			//有返回值
			return false;
		}
	}
	/**
	 * @Title: getFormList
	 * @Description: 根据节点ID，获取当前节点下面的任务清单数据
	 * @param int $formid 节点ID
	 * @return 返回节点下面的任务清单数组
	 * @author 黎明刚
	 * @date 2014年10月20日 上午11:06:46
	 * @see MisSystemFlowFormModel::getFormList()
	 */
	public function getFormList($formid,$projectid){
		$model=D('MisProjectFlowView');
		$where['mis_project_flow_type.status'] = 1; //类型正常
		$where['mis_project_flow_type.projectid'] = $projectid;
		$where['mis_project_flow_form.outlinelevel'] = 4;
		$where['mis_project_flow_form.parentid'] = $formid;
		if( !isset($_SESSION['a']) ){
			//是执行人或者是分派人
			$where['_string'] = 'FIND_IN_SET(  '.$_SESSION[C('USER_AUTH_KEY')].',executorid ) or FIND_IN_SET(  '.$_SESSION[C('USER_AUTH_KEY')].',alloterid )';
		}
		$formlist=$model->where($where)->order("mis_project_flow_type.sort,mis_project_flow_form.sort asc")->select();
		//echo $model->getlastSql();
		
		//分解执行人和分派人信息		
		$formlist = $this->getFormArr($formlist);
		
		return $formlist;
	}
	/**
	 * @Title: getFormArr
	 * @Description: 根据任务数据，解析执行人和分派人信息
	 * @param int $formid 节点ID
	 * @return 返回执行人和分派人信息
	 * @author 黎明刚
	 * @date 2014年10月20日 上午11:06:46
	 * @see MisSystemFlowFormModel::getFormArr()
	 */
	public function getFormArr($formlist,$jd,$projectid){
		// 计算任务数据条数
		$count = count ( $formlist );
		if ($count) {
			//实例化user模型
			$userModel = D ( "User" );
			//$rguModel = D ( "RolegroupUser" );
			$MisProjectFlowFormModel = D ( "MisProjectFlowForm" );
			$mis_system_flow_formcheckModel = M ( "mis_system_flow_formcheck" );
			
			$unset1Arr = array();
			$map = array();
			$map ['projectid'] = $projectid;
			$map ['outlinelevel'] = 2;
			$map ['status'] = 1;
			$map ['isshow'] = 0;
			$MisProjectFlowTypeModel = D ( "MisProjectFlowType" );
			// 查新项目结构
			$typelist = $MisProjectFlowTypeModel->where ( $map )->order("sort")->select();
			foreach($typelist as $kk=>$vv){
				$map = array();
				$map ['category'] = $vv['id'];
				$map ['projectid'] = $projectid;
				$map ['outlinelevel'] = 4;
				$map ['status'] = 1;
				$map ['critical'] = 1;
				$map ['complete'] = 0;
				$vo = $MisProjectFlowFormModel->where($map)->find();
				if(!$vo){
					array_push($unset1Arr, $vv['id']);
				}else{
					array_push($unset1Arr, $vv['id']);
					break;
				}
			}
			$companyid = $vo['companyid'];//单独参数加入json数组数据组装
			//项目查看人员
			$viewPerson = "";
			//实例化项目组表
			$mis_project_flow_managerDao = M("mis_project_flow_manager");
			$where = array();
			$where['projectid'] = $projectid;
			$manangeruser = $mis_project_flow_managerDao->where($where)->getField("id,userid");
			$viewPerson .=",".implode(",",array_filter($manangeruser));
			//分派人和执行人
			$mis_project_flow_resourceDao = M("mis_project_flow_resource");
			//查询
			$resuourceexecutorid = $mis_project_flow_resourceDao->where($where)->getField("id,executorid");
			$resuourcealloterid = $mis_project_flow_resourceDao->where($where)->getField("id,alloterid");
			$viewPerson .=",".implode(",",array_filter($resuourceexecutorid));
			$viewPerson .=",".implode(",",array_filter($resuourcealloterid));
			
			foreach($formlist  as $k=>$v){
				// 查看角色
				if ($v ['readtaskrole']) {
					// 查看人
					$viewPerson .=",".$v ['readtaskrole'];
				}
			}
			$readuseridArr = array_unique(explode(",", $viewPerson));
			//end
			
			/*
			 * 获取任务模型是否在子流程中挂号
			 * 1、如果是其他任务的转子流程来执行单据。那么关闭当前任务的执行按钮
			 * 2、如果是多任务，则不关闭执行按钮（先采用不关闭多数据的执行按钮方式）
			 */
			$process_relationDao = M("process_relation");
			$process_relation_formDao = M("process_relation_form");
			
			$bool = true; //只执行一次if进入标记
			foreach ( $formlist as $key => $val ) {
				if($bool){
					$map = array();
					$map ['projectid'] = $val['projectid'];
					$map ['outlinelevel'] = 2;
					$map ['status'] = 1;
					$map ['complete'] = 2;
					$MisProjectFlowTypeModel = D ( "MisProjectFlowType" );
					// 查新项目结构
					$typecount = $MisProjectFlowTypeModel->where ( $map )->count();
					$bool = false;
				}
				
				$executorname = $allotername = "";
				$executorArr = array ();
				if ($val ['executorid']) {
					// 执行人
					$where = array ();
					$executorArr = explode ( ",", $val ['executorid'] );
					$where ['id'] = array (' in ',$executorArr );
					$where ['status'] = 1;
					$executorname = $userModel->where ( $where )->getField ( "id,name" );
				}
				if ($val ['alloterid']) {
					// 分派人
					$where = array ();
					$where ['id'] = array (' in ',explode ( ",", $val ['alloterid'] ) );
					$where ['status'] = 1;
					$allotername = $userModel->where ( $where )->getField ( "id,name" );
				}
				$formlist [$key] ['executorname'] = $executorname;//执行人名称
				$formlist [$key] ['allotername'] = $allotername; //查看人名称
				
				//定义任务不可执行
				$overbool = 0;
				if($val['dostatus'] == 1){
					//子任务任务锁定问题， 当挂了子任务的主任务启动流程时，才进行子任务锁定(禁止操作)
					//第一步、查询当前模型是否存在已经流程启动的子任务
					$overbool = 1; //定义一个锁子任务的标记  未锁定
					$where = array();
					$where['isauditmodel'] = $val['formobj'];
					$where['projectid'] = $projectid;
					$where['auditState'] = 0;
					$where['doing'] = 1;//执行的审批节点才锁定
					$cout= $process_relation_formDao->where($where)->count ( '*' );
					if($cout){
						$overbool = 0; //锁定
					}
					if($overbool && $val['disabledobj']){
						//验证 该任务完成后禁止当前任务编辑
						//disabledobj 任务限制条件，该任务完成后。尽职操作当前任务
						//先查询限制任务是否完成
						$map = array ();
						$map['systemformid'] = $val['disabledobj'];
						$map['projectid'] = $projectid;
						$map['outlinelevel'] = 4;
						$map['complete'] = 1;
						//根据systemformid获取projectformid
						$completcount = $MisProjectFlowFormModel->where($map)->count ( '*' );
						if($completcount){
							$overbool = 0;
						}
					}
					//子任务锁定完毕
				}
				//判断是否所有的主要任务都完成了
				if($typecount==0){
					// 当前执行阶段,$formlist[$key]['ing'] 0不可操作 1是可执行 2.查看
					$formlist [$key] ['ing'] = 1;
					if ($val ['complete'] == 1) { // 当前任务执行完成
						
						// 如果是执行人，可以查看，是查看人，可以查看；都不是就禁止操作
						if (in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $executorArr ) || in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $readuseridArr) || $_SESSION ['a']) {
							$formlist [$key] ['ing'] = 2;
							//如果是执行人，则可以对多数据进行任务还原，再次进行执行
							if(in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $executorArr ) && $overbool ==1 ){
								$formlist [$key] ['ing'] = 3;
							}
						} else {
							$formlist [$key] ['ing'] = 2;
						}
					} else {
						// 如果是执行人，可以执行，是查看人，可以查看；都不是就禁止操作
						if (in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $executorArr ) || $_SESSION ['a'] ) {
							if($overbool==0){
								$formlist [$key] ['ing'] = 2;
							}else{
								$formlist [$key] ['ing'] = 1;
							}
						} else if (in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $readuseridArr) || $_SESSION ['a']) {
							$formlist [$key] ['ing'] = 2;
						} else {
							$formlist [$key] ['ing'] = 2;
						}
					}
				}else{
					if ($jd >= $val ['category']) {
						// 当前执行阶段，计算计划耗时，和计划剩余时间
							
						// 当前执行阶段,$formlist[$key]['ing'] 0不可操作 1是可执行 2.查看
						$formlist [$key] ['ing'] = 1;
						if ($val ['complete'] == 1) {
							// 当前任务执行完成
							// 如果是执行人，可以查看，是查看人，可以查看；都不是就禁止操作
							if (in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $executorArr ) || in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )],$readuseridArr ) || $_SESSION ['a']) {
								$formlist [$key] ['ing'] = 2;
								//如果是执行人，则可以对多数据进行任务还原，再次进行执行
								if(in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $executorArr ) && $overbool ==1){
									$formlist [$key] ['ing'] = 3;
								}
							} else {
								$formlist [$key] ['ing'] = 2;
							}
						} else {
							// 如果是执行人，可以执行，是查看人，可以查看；都不是就禁止操作
							if (in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $executorArr ) || $_SESSION ['a']) {
								if($overbool==0){
									$formlist [$key] ['ing'] = 2;
								}else{
									$formlist [$key] ['ing'] = 1;
								}
							} else if (in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $readuseridArr ) || $_SESSION ['a']) {
								$formlist [$key] ['ing'] = 2;
							} else {
								$formlist [$key] ['ing'] = 2;
							}
						}
					} else {
						// 不是当前执行阶段，则所有任务只能查看。或者什么都不能操作
						if(in_array($val ['category'], $unset1Arr)){
							// 如果是执行人，可以执行，是查看人，可以查看；都不是就禁止操作
							if (in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $executorArr ) || $_SESSION ['a']) {
								if($overbool==0){
									$formlist [$key] ['ing'] = 2;
								}else{
									$formlist [$key] ['ing'] = 1;
								}
							} else if (in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $readuseridArr ) || $_SESSION ['a']) {
								$formlist [$key] ['ing'] = 2;
							} else {
								$formlist [$key] ['ing'] = 2;
							}
						}else{
							// 如果是执行人,是查看人，可以查看；都不是就禁止操作
							if (in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $executorArr ) || in_array ( $_SESSION [C ( 'USER_AUTH_KEY' )], $readuseridArr ) || $_SESSION ['a']) {
								$formlist [$key] ['ing'] = 2;
							} else {
								$formlist [$key] ['ing'] = 2;
							}
						}
					}
				}
				$formlist[$key]['completeName'] = $val['complete']==1?"已完成":"未开始";//已建单
				/*
				 * 计算当前任务状态
				 * 0：未完成、1：完成、2：已建单、3:流程启动、4：审批中、5：转子流程、6：变更中、7：流程打回
				 */
				if($val['datatype'] == 1){
					//列表型
					if($val['formtype'] == 2){
						if($val['complete'] == 1){
							$formlist[$key]['completeName'] = "已完成";//已建单
						}else{
							//单据
							$Model = D($val['formobj']);
							//node节点数据
							//$nodeModel = M("node");
							//查询判断当前模型属于何种类型，1审批流 ，2普通表单
							//$where = array();
							//$where['name'] = $val['formobj'];
							//$isprocess = $nodeModel->where($where)->getField("isprocess");
							//根据项目ID，查询当前数据状态值
							$where = array();
							$where['projectid'] = $val['projectid'];
							$where['projectworkid'] = $val['work_id'];
							$vo = $Model->where($where)->find();
							if($vo){
								$formlist[$key]['completeName'] = "已建单";//已建单
							}
						}
					}
				}else{
					//单数据型
					if($val['formtype'] == 2){
						if($val['complete'] == 1){
							$formlist[$key]['completeName'] = "已完成";//已建单
						}else{
							//单据
							$Model = D($val['formobj']);
							//node节点数据
							$nodeModel = M("node");
							//查询判断当前模型属于何种类型，1审批流 ，2普通表单
							$where = array();
							$where['name'] = $val['formobj'];
							$isprocess = $nodeModel->where($where)->getField("isprocess");
							//根据项目ID，查询当前数据状态值
							$where = array();
							$where['projectid'] = $val['projectid'];
							$where['projectworkid'] = $val['work_id'];
							$vo = $Model->where($where)->find();
							if($vo){
								$formlist[$key]['completeName'] = "已建单";//已建单
								//审批单据
								if($isprocess == 1){
									if($vo['auditState']>1 && $vo['auditState'] <3){
										//审核中
										$formlist[$key]['completeName'] = "审核中";
									}
									else if($vo['auditState'] == 1){
										//启动
										$formlist[$key]['completeName'] = "流程启动";
									}
									else if($vo['auditState'] == -1){
										//打回
										$formlist[$key]['completeName'] = "流程打回";
									}
									else if($vo['auditState'] == 4){
										//变更
										$formlist[$key]['completeName'] = "变更中";
									}
									else if($vo['auditState'] == 3){
										$formlist[$key]['completeName'] = "已完成";
									}
								}else{
									if($vo['operateid'] == 1){
										$formlist[$key]['completeName'] = "已完成";
									}
								}
							}
						}
					}else{
						//附件
					}
				}
				
				// 当前登录人是否为该任务的执行人，还是该任务的查阅人
				$json = array ();
				
				//判断当前任务是否存在引用任务
				if($val['quote']){
					//将任务的指向改为引用任务
					$map = array ();
					$map['systemformid'] = $val['quote'];
					$map['projectid'] = $val ['projectid'];
					//根据systemformid获取projectformid
					$formcheckvo = $mis_system_flow_formcheckModel->where($map)->find();
					if($formcheckvo){
						$map = array ();
						$map['id'] = $formcheckvo['projectformid'];
						$quotevo = $MisProjectFlowFormModel->where ( $map )->find();
						// 封装任务ID和项目，以及类型JSON数据，以备执行用
						$json ['formtype'] = $quotevo ['formtype'];
						$json ['formobj'] = $quotevo ['formobj'];
						$json ['projectid'] = $quotevo ['projectid'];
						$json ['form_id'] = $quotevo ['id'];
						$json ['datatype'] = $quotevo ['datatype'];
						$json ['companyid'] = $quotevo ['companyid'];	//多数据、列表数据行
					}
				}else{
					//封装任务ID和项目，以及类型JSON数据，以备执行用
					$json ['formtype'] = $val ['formtype'];
					$json ['formobj'] = $val ['formobj'];
					$json ['projectid'] = $val ['projectid'];
					$json ['form_id'] = $val ['work_id'];
					$json ['datatype'] = $val ['datatype'];
					$json['companyid'] = $companyid;	//多数据、列表数据行
				}
				$formlist [$key] ['json'] = json_encode ( $json );
			}
			return $formlist;
		} else {
			return ;
		}
	}
	/**
	 * @Title: getWorkJhTime
	 * @Description: 计算计划完成时间，和计划剩余天数
	 * @param array $formlist 任务数据
	 * @param int $jd 当前执行的阶段
	 * @return number  
	 * @author 黎明刚
	 * @date 2014年11月19日 下午9:29:02 
	 * @throws
	 */
	public function getWorkJhTime($formlist,$jd){
		$count = count ( $formlist );
		if ($count) {
			$jhtime = $formlist[$count-1]['endtime'];
			$newtime = time();
			$day = 0;
			if($jhtime > $newtime){
				$day = intval(($jhtime - $newtime)/86400)+1;
			}
			$data['time'] = transTime($jhtime);
			$data['day'] = $day;
			
		}else{
			$data['time'] = "无任务时间";
			$data['day'] = 0;
		}
		return $data;
	}
}
?>
