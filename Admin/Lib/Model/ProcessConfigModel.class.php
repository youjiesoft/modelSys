<?php
/**
 * 流程配置模板
 * @author 杨东
 * @data 2012-8-22
 * */
class ProcessConfigModel extends CommonModel {
	/**
	 * 设置流程配置
	 * @param $data 流程配置信息
	 * */
	public function setProcessConfig($data=array()){
		$field = $this->getFile();
		$this->writeover($field,"return ".$this->pw_var_export($data).";\n",true);	
	}
	/**
	 * 获取流程配置
	 * @return $list 流程配置信息
	 * */
	public function getProcessConfig() {
		$field = $this->getFile();
		if (file_exists($field)) {
			$list = require $field;
			$arr = array();
			foreach ($list as $k => $v) {
				if ($_SESSION["a"] == 1 || $_SESSION[strtolower($k)."_index"] == 1) {
					$arr[$k] = $v;
					$arr[$k]['name'] = getFieldBy($k,'name','title','Node');
				}
			}
			return $arr;
		} else {
			return '';
		}
	}
	/**
	 * 获取流程
	 * @param $data 流程配置信息
	 * @return $list 流程配置信息
	 * */
	public function getpcfor($vol,$name) {
		$field = $this->getFile();
		if (file_exists($field)) {
			$list = require $field;
			$pcarr = array();
			foreach ($list as $k => $v) {
				if($vol == $k) {
					$pcarr = $v;
					break;
				}
			}
			return $pcarr;
		} else {
			return '';
		}
	}
	/**
	 * 获取流程信息
	 * @author 	wangcheng
	 * @param 	$module 模型名称
	 * @return 	$param  模型参数
	 **/
	public function getprocessinfo($module,$vo=array()) {
		$ProcessConfigViewModel=D('ProcessConfigView');
		$scdmodel = D('SystemConfigDetail');
		$viewMap['process_node.status']=1;
		//$viewMap['process_node.name']=$module;
		//$viewMap['process_info.name']=$module;
		$viewMap['process_info.status']=1;
		$ProcessConfigViewList=$ProcessConfigViewModel->where($viewMap)->select();
		$list=array();
		foreach($ProcessConfigViewList as $key=>$val){
			$process_rule = array();
			if(in_array($val['name'],array_keys($list))){
				$process_rule = array(
						'informpersonid'=>$val['informpersonid'],
						'executorid'=>$val['executorid'],
						'pid' => $val['pinfoid'],
						'typeid' =>$val['typeid'],
						'rules' => $val['rules'],
						'crosslevel' =>$val['crosslevel'],
				);
				$list[$val['name']]['process_rule'][] = $process_rule;
				
			}else{
				$process_rule[] = array(
						'informpersonid'=>$val['informpersonid'],
						'executorid'=>$val['executorid'],
						'pid' => $val['pinfoid'],
						'typeid' =>$val['typeid'],
						'rules' => $val['rules'],
						'crosslevel' =>$val['crosslevel'],
				);
				$list[$val['name']] = array(
						'modulename'=>$val['name'],
						'title'=>$val['title'],
						'process_rule'=>$process_rule,
					);
			}
		}
		if ($list) {
			$pcarr =array();
			foreach ($list as $k => $v) {
				if($module == $v['modulename']) {
					$detailList = $scdmodel->getDetail($v['modulename'],false);
					foreach( $v['process_rule'] as $k2=>$v2 ){
						if($v2['rules']){
							$matches=array();
							//全局正则表达式匹配
							preg_match_all('|#+(.*)#|U', $v2['rules'], $matches);
							foreach($matches[1] as $k3=>$v3){
								if(isset($vo[$v3])){
									//判断是否查询外键
									foreach($detailList as $k4=>$v4){
										if($v4['name']==$v3){
											if( isset($dv['processSelectField']) && isset($dv['processSelectField']["left"]) ){
												$processFieldInfo = $dv['processSelectField']["left"];
												$tbmodel=D($processFieldInfo[2]);
												$vo[$v3]= getFieldBy($vo[$v3],$processFieldInfo[0],$processFieldInfo[1],$processFieldInfo[2]);
												break; 
											}
										}
									}
									$matches[1][$k3]=$vo[$v3];
								}else{
									if($_REQUEST[$v3]) $matches[1][$k3]=$_REQUEST[$v3];
								}
							}
							$a="";
							$a = str_replace($matches[0],$matches[1],$v2['rules']);
							$a = str_replace (array ('&quot;','&#39;','&lt;','&gt;'), array ('"', "'",'<','>'),$a);

							eval("\$a =(".$a.");");
							if($a){
								$pcarr['pid']=$v2['pid'];
								$pcarr['crosslevel']=intval($v2['crosslevel']);
								$pcarr['informpersonid']=$v2['informpersonid'];
								$pcarr['executorid']=$v2['executorid'];
								break;
							}
						}else{
							$pcarr['pid']=$v2['pid'];
							$pcarr['crosslevel']=intval($v2['crosslevel']);
							$pcarr['informpersonid']=$v2['informpersonid'];
							$pcarr['executorid']=$v2['executorid'];
							break;
						}
					}
					break;
				}
			}
			return $pcarr;
			
		} else {
			return array();
		}
	}
	
	/*
	*判断是否进入下一节点，返回false则流程结束。
	*@author wangcheng
	*@param array $vo 传入当前数据审批表单数据
	*return bool      返回为true 说明终止于改节点
	**/
	public function processJudgment( $vo=array() ,$current_audit_node_id=0) {
		if( $vo && $current_audit_node_id){
			$allnode = explode(",",$vo['allnode']);
			$noderule = explode(",",$vo['noderule']);
			foreach($allnode as $k=>$v ){
				if($v== $current_audit_node_id){
					if(isset($noderule[$k])){
						$current_node_rules=$noderule[$k];
						break;
					}
				}
			}
			if( $current_node_rules ){//判断当前审核的节点id 对应的rule规则是否满足
				$matches=array();
				preg_match_all('|#+(.*)#|U', $current_node_rules, $matches);
				foreach($matches[1] as $k=>$v){
					if(isset($vo[$v])){
						$matches[1][$k]=$vo[$v];
					}
				}
				$a="";
				$a = str_replace( $matches[0],$matches[1],$current_node_rules );
				eval("\$a =".$a.";");
				if( $a ){
					return true;
				}
			}
		}
		return false;
	}
	
	
	/**
	 * 获取文件
	 * @return 文件路径
	 * */
	public function getFile(){
		return DConfig_PATH . "/System/processconfig.inc.php";
	}
}
?>