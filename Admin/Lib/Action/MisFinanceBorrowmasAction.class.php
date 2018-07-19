<?php
/**
 * @Title: MisFinanceBorrowmasAction
 * @Package 财务模块-借款申请：功能类
 * @Description: TODO(借款申请的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
*/
class MisFinanceBorrowmasAction extends CommonAuditAction {
	
	function inde2323x(){
// 		MisDynamicFormManageAction
// 		//更新后
// 		$aryRule1 = require  CONF_PATH."/MisAutoAnameList1.inc.php";
// 		//更新前
// 		$aryRule2 = require  CONF_PATH."/MisAutoAnameList2.inc.php";
		
// 		$aryRule_key1= array_keys($aryRule1);
// 		$aryRule_key2= array_keys($aryRule2);
// 		//更新前和更新后对比
// 		$a = array_diff($aryRule_key1, array());
// 		print_r($a);
// 		echo 11;
// 		exit;
		$aryRule = require  CONF_PATH."/controlls.php";
		$keysss = array_keys($aryRule);
		
		$mis_dynamic_form_templateDao =M("mis_dynamic_form_template");
		$mis_dynamic_form_properyDao = M("mis_dynamic_form_propery");
		
		$list = $mis_dynamic_form_templateDao->select();
		if($list){
			foreach($list as $k=>$v){
				if($v['tablename']){
					$bool = file_exists(DConfig_PATH."/autoformconfig/".$v['tablename'].".php");
					if($bool){
						$auto = require  DConfig_PATH."/autoformconfig/".$v['tablename'].".php";
						if($auto && $auto[$v['tplname']]){
							foreach($auto[$v['tplname']] as $prok=>$prov){
								$data = array();
								foreach($keysss as $k2=>$v2){
									$fileds = $this->getProperty($v2);
									if($fileds){
										foreach($fileds as $kkk=>$vvvv){
											$data[$vvvv['dbfield']] = $prov[$vvvv['name']];
										}
									}
								}
								$data['ids'] = $v['id'];
								$data['formid'] = $v['formid'];
								$data['modelname'] = $v['tablename'];
								$mis_dynamic_form_properyDao->add($data);
							}
						}
					}
				}
			}
			$this->success("成功");
		}
	}
	
	public function abc(){
		$aryRule = require  DConfig_PATH."/autoformconfig/MisAutoAnameList.inc.php";
		
		
		
		//主系统文件
		$mis_dynamic_form_manageDao = M("nydbzs");
		
		
// 		$where = array();
// 		//获取manange数据ID
// 		$where['actionname'] = array(" in ",array_keys($aryRule));
// 		$vo = $mis_dynamic_form_manageDao->where($where)->field('actionname')->select();
// 		echo $mis_dynamic_form_manageDao->getlastSql();
// 		echo "||";
// 		exit;
		
		
		//模板文件
		$mis_dynamic_form_templateDao =M("mis_dynamic_form_template");
		//数据库mas头
		$mis_dynamic_database_masDao  = M("mis_dynamic_database_mas");
		//数据库sub数据
		$mis_dynamic_database_subDao = M("mis_dynamic_database_sub");
		foreach($aryRule as $key=>$val){
			$where = array();
			//获取manange数据ID
			$where['actionname'] = array("eq",$key);
			$vo = $mis_dynamic_form_manageDao->where($where)->field('id')->find();
			if($vo){
				//存在manange
				if(isset($val['temp']) && $val['temp']){
					foreach($val['temp'] as $temk=>$temv){
						$data = array();
						$data['tplname'] = $temv['tempname'];
						$data['tpltitle'] = $temv['temptitle']?$temv['temptitle']:'';
						$data['tablename'] = $key;
						$data['formid'] = $vo['id'];
						//存在模板
						$tempid = $mis_dynamic_form_templateDao->add($data);
						if(!$tempid){
							$this->error("模板插入失败");
						}
					}
				}
				if(isset($val['datebase']) && $val['datebase']){
					foreach($val['datebase'] as $dbmask=>$dbmasv){
						$data = array();
						$data['tablename'] = $dbmasv['tablename'];
						$data['tabletitle'] = $dbmasv['tabletitle'];
						$data['isprimay'] = $dbmasv['isprimay']? $dbmasv['isprimay']:0;
						$data['ischoise'] = $dbmasv['ischoise']?$dbmasv['ischoise']:0;
						$data['formid'] = $vo['id'];
						$data['modelname'] = $key;
						$masid = $mis_dynamic_database_masDao->add($data);
						if($masid){
							if(isset($dbmasv['list']) && $dbmasv['list']){
								foreach($dbmasv['list'] as $subk=>$subv){
									$data = array();
									$data['masid'] = $masid;
									$data['field'] = $subv['filed'];
									$data['title'] = $subv['title']?$subv['title']:"";
									$data['type'] = $subv['type'];
									$data['length'] = $subv['length'];
									$data['category'] = $subv['category'];
									$data['weight'] = $subv['weight'];
									$data['sort'] = $subv['sort'];
									$data['isshow'] = $subv['isshow'];
									$data['isdatasouce'] = $subv['isdatasouce']?$subv['isdatasouce']:0;
									$data['formid'] = $vo['id'];
									$data['modelname'] = $key;
									$subid = $mis_dynamic_database_subDao->add($data);
									if(!$subid){
										$this->error("sub插入失败");
									}
								}
							}
						}else{
							$this->error("mas插入失败");
						}
					}
				}
			}
		}
		$list = $mis_dynamic_form_templateDao->select();
		if($list){
			foreach($list as $k=>$v){
				if($v['tablename']){
					$bool = file_exists(DConfig_PATH."/autoformconfig/".$v['tablename'].".php");
					if($bool){
						$auto = require  DConfig_PATH."/autoformconfig/".$v['tablename'].".php";
						if($auto && $auto[$v['tplname']]){
							$fleids = implode(",", array_keys($auto[$v['tplname']]));
							$data=array();
							$data['id'] = $v['id'];
							$data['tplfield'] = $fleids;
							$result = $mis_dynamic_form_templateDao->save($data);
							if(!$result){
								$this->error("字段集合修改失败");
							}
						}
					}
				}
			}
		}
		$this->success("成功");
	}
	
	function aaa(){
		
		
		//$aryRule = require  CONF_PATH."/autoformconfig/MisAutoAnameList.inc.php";
		
	}
	
	
	
	
	
	
	public function _filter(&$map){
		if( !isset($_SESSION['a']) ){
			$map['status']=1;
		}
	}
	public function _before_add(){
		$this->assign('time',time());
	}
	public function _before_edit(){
		$this->assign('time',time());
	}
	/**
	 * @Title: overProcess 
	 * @Description: todo(审批后执行 向统计表插入借款金额)   
	 * @author libo 
	 * @date 2014-6-20 下午4:07:12 
	 * @throws
	 */
	public function overProcess($masid){
		//查询该单 借款金额
		$BorrowmasModel=D("MisFinanceBorrowmas");
		$borrowmoney=$BorrowmasModel->where("id=".$masid)->field("createid,borrowmoney")->find();
		$collectionModel=M("mis_finance_borrow_collection");
		//查询是否存在借款记录
		$list=$collectionModel->where("userid=".$borrowmoney['createid'])->find();
		if($list){//存在 则修改借款余额
			//查询原 借款余额
			$residualsum=$list['residualsum'];
			$residualsumNew=$residualsum+$borrowmoney['borrowmoney'];
			$re=$collectionModel->where("userid=".$borrowmoney['createid'])->setField("residualsum", $residualsumNew);
			if($re===false){
				$this->error("操作失败");
			}
		}else{//不存在 则新增借款记录
			$data=array();
			$data['userid']=$borrowmoney['createid'];
			$data['deptid']=getFieldBy($borrowmoney['createid'], "id", "dept_id", "user");
			$data['residualsum']=floatval($borrowmoney['borrowmoney']);
			$data['createid']=$borrowmoney['createid'];
			$data['createtime']=time();
			//保存当前数据对象
			$list=$collectionModel->add ($data);
			if($list === false){
				$this->error("操作失败");
			}
		}
	}
	/**
	 * @Title: lookupborrowquota 
	 * @Description: todo(选择借款类型 获取借款类型限额)   
	 * @author libo 
	 * @date 2014-6-23 上午11:22:59 
	 * @throws
	 */
	public function lookupborrowquota(){
		$id=$_REQUEST['quotaid'];
		$BorrowmasTypeModel=D("MisFinanceBorrowmasType");
		$quota=$BorrowmasTypeModel->where("id=".$id)->getField("quota");
		echo $quota;
	}
	
	public function printout(){
		$BorrowmasModel=D("MisFinanceBorrowmas");
		$list=$BorrowmasModel->where("id=".$_REQUEST['id'])->find();
		//转大写金额
		$acount=$this->get_amount($list['borrowmoney']);
		$this->assign("acount",$acount);
		//查询流程
		$prmodel = D('ProcessRelation');//构造流程与节点关系表模型
		$plist=$prmodel->field("tid")->where("pid=".$list['ptmptid'])->select();
		$tempid=array();
		foreach ($plist as $k=>$v){
			$tempid[]=$v['tid'];
		}
		$ptmodel = D('process_template');//构造流程节点模型
		$map['id']=array('in',$tempid);
		$ptmlist=$ptmodel->field("name")->where($map)->select();
		
		$pihmodel = D('process_info_history');//构造流程明细模型
		$pihlist=$pihmodel->field("doinfo,userid")->where("pid=".$list['ptmptid']." and auditstatus=2 and tableid=".$_REQUEST['id'])->select();
		foreach ($pihlist as $k=>$v){
			$username=getFieldBy($v['userid'], "id", "name", "user");
			$ptmlist[$k]["doinfo"]=$username.":".$v['doinfo'];
		}
		$this->assign("ptmlist",$ptmlist);
		$this->assign("vo",$list);
		$this->display('Lodop:MisFinanceBorrowmas');
	}
}
?>