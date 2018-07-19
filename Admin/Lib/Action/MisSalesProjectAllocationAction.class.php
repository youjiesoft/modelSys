<?php
/**
 * @Title: MisSalesProjectAllocation
 * @Package package_name
 * @Description: todo(项目管理 里的项目分配) 
 * @author xiayuqin 
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2013-6-1 上午9:31:36 
 * @version V1.0
 */
class MisSalesProjectAllocationAction extends MisAutoEbmAction {
	public function _filter(&$map) {
		$MisWorkExecutingModel = D("MisWorkExecuting");
		$MisWorkExecutingModel->_filter("MisSalesProjectAllocation",$map);
	}
	
	
	public function index(){
		// 获取当前控制器名称
		$name = $this->getActionName();
		
		$jump = $_REQUEST['jump'];
		// 列表过滤器，生成查询Map对象
		$map = $this->_search ();
		//结合过滤条件方法
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		if($jump == 1){
			$typeid = $_REQUEST['typeid'];
			$this->assign("typeid",$typeid);
			//业务类型
			if($typeid){
				$map['typeid'] = $typeid;
			}
		}else{
			//第一步，左侧业务线树
			$mis_system_flow_typeDao = M("mis_system_flow_type");
			$where = array();
			$where['outlinelevel'] = 1;
			$where['status'] = 1;
			$data = $mis_system_flow_typeDao->where($where)->order("sort asc")->select();
			$param = array();
			$param['open']=true;
			$param['url']="__URL__/index/jump/1/typeid/#orderno#";
			$param['rel']="MisSalesProjectAllocation";
			$nodename = getFieldBy("MisSystemFlowType",'name','title','node');
			$returnarr[] = array(
					'id'=>0,
					'name'=>$nodename,
					'title'=>$nodename,
					'open'=>true,
			);
			$ztreeData = $this->getTree($data,$param,$returnarr);
			$this->assign("ztreedata",$ztreeData);
		}
		// 查询数据
		$this->_list ( 'MisSalesMyProject', $map );
		
		// begin
		$scdmodel = D ( 'SystemConfigDetail' );
		// 读取列名称数据(按照规则，应该在index方法里面)
		$detailList = $scdmodel->getDetail ( $name );
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
		// 扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail ( $name, true, 'toolbar' );
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		if($jump){
			$this->display("indexview");
		}else{
			$this->display();
		}
	}
	/**
	 * 项目人员概况信息
	 */
	public function lookupGaiKuang(){
		//获取项目ID
		$projectid = $_REQUEST['projectid'];
		//查询项目组信息
		$mis_auto_kimpuDao = M("mis_auto_kimpu");
		$where['id'] = $projectid;
		$vo = $mis_auto_kimpuDao->where($where)->find();
		$this->assign("projectInfo",$vo);
		$arr = array();
		$data= array();
		//第一步、构造项目组角色结构。
		if($vo['prolineorderno']){
			//实例化项目任务信息表
			$MisProjectFlowFormModel = D ( "MisProjectFlowForm" );
			//实例化项目组模型
			$MisAutoAhmModel = D("MisAutoAhm");
			//项目分派模型
			$MisAutoQzuModel = D("MisAutoQzu");
			$mis_auto_twidh_sub_fenpeixiangqingDao = M("mis_auto_twidh_sub_fenpeixiangqing");
			//项目组
			$prolineorderno = explode(",", $vo['prolineorderno']);
			//项目角色
			$suoshujiaose = explode(",", $vo['suoshujiaose']);
			//角色对应人员
			$deptjinli = explode(",", $vo['deptjinli']);
			
			$map = array();
			$map['orderno'] = array("in",$prolineorderno);
			$xiangmuzu = $MisAutoAhmModel->where($map)->select();
			$this->assign("xiangmuzu",$xiangmuzu);
			
			foreach($prolineorderno as $k=>$v){
				foreach($xiangmuzu as $key=>$val){
					if($v == $val['orderno']){
						//先将数据存储进去，然后用父类ID进行判断当前节点是否为子级
						array_push($arr, $val['id']);
						//存储默认基础信息
						$info['id'] = $val['id'];
						$info['name'] = $val['name'];
						//项目组下面的角色
						$suoshujiaose = getFieldBy($val['suoshujiaose'], "orderno", "name", "mis_auto_wqzrv");
						$info['pmjuese'] = $suoshujiaose;
						$info['username'] = getFieldBy($deptjinli[$k], "id", "name", "user");
						if(in_array($val['parentid'], $arr)){
							//存在tab空格
							$info['tab'] = 1;
							$info['class'] = "";
						}else{
							$info['tab'] = 0;
							$info['class'] = "first_dl";
						}
						//先根据项目ID和角色编号。查询到分配单头ID
						$where = array();
						$where['projectid'] = $projectid;
						$where['xiangmujiaose'] = $val['suoshujiaose'];
						$fenpeimas = $MisAutoQzuModel->where($where)->field("id,createtime,updatetime")->find();
						$fenpeisub = array();
						if($fenpeimas['id']){
							$fenpeisub = $mis_auto_twidh_sub_fenpeixiangqingDao->distinct("zhixingren")->field("zhixingren")->where("zhixingren<> 0 and masid = ".$fenpeimas['id'])->select();
						}
						//建议人员/或者分派执行人员
						$info['user'] = $fenpeisub;
						$info['jinrushijian'] = $fenpeimas['updatetime']?$fenpeimas['updatetime']:$fenpeimas['createtime'];
						//已分派人员
						$data[] = $info;
					}
				}
			}
		}
		//获取项目临时成员
		$mis_project_flow_temporarystaffDao = M("mis_project_flow_temporarystaff");
		$where = array();
		$where['projectid'] = $projectid;
		$useridArr = $mis_project_flow_temporarystaffDao->where($where)->getField("id,userid");
		$this->assign("useridArr",$useridArr);
		//print_r($data);	
		$this->assign("info",$data);
		$this->display();
	}
	
	
	
	
	public function abc2(){
		//获取项目ID
		$projectid = $_REQUEST['projectid'];
		//查询项目组信息
		$mis_auto_kimpuDao = M("mis_auto_kimpu");
		$where['id'] = $projectid;
		$vo = $mis_auto_kimpuDao->where($where)->find();
		$this->assign("projectInfo",$vo);
		$jump = $_REQUEST['jump'];
		if($jump == 1){
			
		}else{
			$newarray = array();
			//第一步、构造项目组角色结构。
			if($vo['prolineorderno']){
				//项目组
				$prolineorderno = explode(",", $vo['prolineorderno']);
				//实例化项目组模型
				$MisAutoAhmModel = D("MisAutoAhm");
				$map = array();
				$map['orderno'] = array("in",$prolineorderno);
				$xiangmuzu = $MisAutoAhmModel->where($map)->select();
				$this->assign("xiangmuzu",$xiangmuzu);
				//实例化任务模型
				$mis_project_flow_formDao = M("mis_project_flow_form");
				//存储业务阶段数据
				$jieduanArr = array();
				//存储业务节点数据信息
				$jiedianArr = array();
				//查询任务数据信息
				foreach($xiangmuzu as $key=>$val){
					$newv1 = array();
					$newv1['id'] = $val['id'];
					$newv1['pId'] = $val['parentid'];
					$newv1['title'] = $val['name']; //光标提示信息
					$newv1['name'] = missubstr($val['name'],20,true); //结点名字，太多会被截取
					$newv1['url']="__URL__/index/jump/1/";
					$newv1['target']='ajax';
					$newv1['rel']="jbsxNodeBox";
					$newv1['open'] = 'true';
					$newv1['isParent'] = true;
					$newarray[] = $newv1;
					//查询阶段结构数据，构造到树形结构上。
					$where = array();
					$where['projectid'] = $projectid;
					$where['xiangmujuese'] = $val['suoshujiaose'];
					$where['outlinelevel'] = 4;
					$formlist = $mis_project_flow_formDao->where($where)->select();
					//第一步，寻找业务阶段数据
					foreach ($formlist as $k1=>$v1){
						//在阶段信息的ID上面追加2222222数字。避免数据ID重复
						if(!in_array($v1['category'], array_keys($jieduanArr))){
							$jieduanname = getFieldBy($v1['category'], 'id', 'name', 'mis_system_flow_type');
							$newv2 = array();
							$newv2['id'] = "222222".$v1['id'];
							$newv2['pId'] = $val['id'];
							$newv2['title'] = $jieduanname; //光标提示信息
							$newv2['name'] = missubstr($jieduanname,20,true); //结点名字，太多会被截取
							$newv2['url']="__URL__/index/jump/1";
							$newv2['target']='ajax';
							$newv2['rel']="jbsxNodeBox";
							$newv2['open'] = false;
							$newarray[] = $newv2;
							$jieduanArr[$v1['category']] = "222222".$v1['id'];
						}
					}
					foreach ($formlist as $k2=>$v2){
						if(!in_array($v2['parentid'], $jiedianArr)){
							$jiedianname = getFieldBy($v2['parentid'], 'id', 'name', 'mis_project_flow_form','outlinelevel','3');
							$newv3 = array();
							$newv3['id'] = "333333".$v2['id'];
							$newv3['pId'] = $jieduanArr[$v2['category']];
							$newv3['title'] = $jiedianname; //光标提示信息
							$newv3['name'] = missubstr($jiedianname,20,true); //结点名字，太多会被截取
							$newv3['url']="__URL__/index/jump/1";
							$newv3['target']='ajax';
							$newv3['rel']="jbsxNodeBox";
							$newv3['open'] = false;
							$newarray[] = $newv3;
							array_push($jiedianArr, $v2['parentid']);
							unset($formlist[$k2]);
						}
					}
				}
			}
			$this->assign("json_data",json_encode($newarray));
		}
		if($jump == 1){
			$this->display("abcde");
		}else{
			$this->display();
		}
		//第二步、构造项目任务
		
	}
	
	
	
	public function projectallot(){
		//查询项目基础信息
		$name=$this->getActionName();
		$model = D ( $name );
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$projectid = $id;
		//查询临时项目人员
		$mis_project_flow_temporarystaffDao = M("mis_project_flow_temporarystaff");
		$where = array();		
		$where['projectid'] = $projectid;
		$useridArr = $mis_project_flow_temporarystaffDao->where($where)->getField("id,userid");
		$this->assign("useridArr",$useridArr);
		$this->assign("projectid",$projectid);
		$kimpuModel=D('MisAutoEbm');
		$projectInfo=$kimpuModel->where(array('id'=>$id))->find();
		$this->assign('projectInfo',$projectInfo);
		//根据阶段ID查询任务数据
		$where = array();
		$where['mis_project_flow_type.status'] = 1; //类型正常
		$where['mis_project_flow_type.projectid'] = $projectid;
		$where['mis_project_flow_form.outlinelevel'] = 4;
		$where['mis_project_flow_form.projectid'] = $projectid;
		$where['mis_project_flow_form.complete'] = array("neq",2);
		//if( !isset($_SESSION['a']) ){
			//是执行人或者是分派人
			$where['_string'] = 'FIND_IN_SET(  '.$_SESSION[C('USER_AUTH_KEY')].',alloterid )';
		//}
		$model=D('MisProjectFlowView');
		$rwlist=$model->where($where)->order("mis_project_flow_type.sort,mis_project_flow_form.id asc")->select();
		if(!$bool){
			//表示项目完结,所有任务都只能查看
			$dfaultJd = 0;
		}
		$MisProjectFlowFormModel = D("MisProjectFlowForm");
		$rwlist = $MisProjectFlowFormModel->getFormArr($rwlist);
		$this->assign("rwlist",$rwlist);
		//释放内存
		unset($flowtypelist);
		unset($jdlist);
		unset($rwlist);
		unset($map);
		$this->display();
	}
	
	public function lookupallot(){
		//获取项目ID
		$projectid = $_POST['projectid'];
		//插入临时人员
		$recipient = $_REQUEST['recipient'];
		if($recipient){
			$mis_project_flow_temporarystaffDao = M("mis_project_flow_temporarystaff");
			//清空原数据
			$delebool = $mis_project_flow_temporarystaffDao->where("projectid = ".$projectid)->delete();
			if(!$delebool){
				$this->error("临时人员保存失败");
			}
			$data = array();
			foreach($recipient as $k=>$v){
				$data[]=array(
						'userid'=>$v,
						'projectid'=>$projectid,
				); 
			}
			$result = $mis_project_flow_temporarystaffDao->addAll($data);
			if(!$result){
				$this->error("临时人员保存失败");
			}
		}
		if($_REQUEST['id']){
			$resourceModel=D('MisProjectFlowResource');
			$id=$_REQUEST['id'];
			$executorid=$_REQUEST['executorid'];
			$condition['id']=array('in ',$id);
			$list=$resourceModel->where($condition)->save(array('executorid'=>$executorid));
			if($list!=false){
				$this->success ( L('_SUCCESS_'));
			}else{
				$this->error ( L('_ERROR_') );
			}
		}
		$this->success ( L('_SUCCESS_'));
	}
}
