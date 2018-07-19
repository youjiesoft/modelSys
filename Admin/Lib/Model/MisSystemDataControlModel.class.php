<?php
class MisSystemDataControlModel extends CommonModel{
	protected $trueTableName = 'mis_system_data_control_mas'; 

	public function getAutoAllActionAndTable(){
		//获取所有的模型和对应的数据表（主从）
		$dyModel = D("MisDynamicFormManage");
		$dymap['status'] = 1;
		//内嵌表
		$sql = "SELECT d.formid,d.propertyid,d.tablename,if(p.title is null or p.title='' ,p.fieldname, p.title)  as tabletitle FROM mis_dynamic_form_datatable as d LEFT JOIN mis_dynamic_form_propery  as p ON p.id=d.propertyid where p.fieldname <> '' and p.fieldname is not null and p.status=1  group by d.formid,d.propertyid";
		$list = M()->query($sql);
		//主表
		$dysql = "SELECT g.actionname,g.actiontitle,m.tablename,m.tabletitle,m.formid FROM 	mis_dynamic_form_manage as g LEFT JOIN mis_dynamic_database_mas AS m ON g.id=m.formid WHERE g.status=1 and m.formid !='' and m.formid is not null";
		$dylist = M()->query($dysql);
		$newdata = array();
		//主表
		foreach($dylist as $key=>$val){
			$newdata[$val['formid']]['actionname'] = $val['actionname'];
			$newdata[$val['formid']]['actiontitle'] = $val['actiontitle'];
			$newdata[$val['formid']]['mastablename'] = $val['tablename'];
			$newdata[$val['formid']]['mastabletitle'] = $val['tabletitle'];
		}
		//从表
		foreach($newdata as $key=>$val){
			$temp = array();
			foreach($list as $k=>$v){
				if($key == $v['formid']){
					$temp['subtablename'] = $v['tablename'];
					$temp['subtabletitle'] = $v['tabletitle'];
					$temp['propertyid'] = $v['propertyid'];
					if($temp){
						$newdata[$key]['sublist'][$v['propertyid']] = $temp;
					}
				}
			}
				
		}
		return $newdata;
	}
	/**
	 * 
	 * @Title: main
	 * @Description: todo(數據控制核心方法) 
	 * @param unknown $modelname
	 * @param unknown $operation  
	 * @author renling 
	 * @date 2015年7月13日 上午11:24:20 
	 * @throws
	 */
	public function main($modelname,$operation,$pkey,$targetname,$type){
		$map=array();
		$modelnewname=$targetname?$targetname:$modelname;
		//查詢當前模型是否有數據控制
		$map['modelname']=$modelnewname;
		//查詢當前模型是操作类型
		$map['operation']=array("like",'%'.$operation.'%');
		$map['mstatus']=1;
		//查询是漫游前还是漫游后
		$map['roamtype']=$type;
		//判断当前控制表是否为此表
		$tablename=D($modelname)->getTableName();
		$map['objtable']=$tablename;
		$masViewModel=D("MisSystemDataControlView");
		$masViewList=$masViewModel->where($map)->select(); 
		logs("满足条件===={$masViewModel->getlastsql()}",'DataControlSelsql');
		$tablepost=array();
		$infostr="";
		//存在数据控制
		if($masViewList){
			foreach ($masViewList as $mkey=>$mval){
				//判断是否满足此条数据控制
				if($mval['rules']){
					$mapstr=$mval['rules'];
				}else{
					$mapstr=$map['_string']="1=1";
				}
					//直接执行此条数据控制	
					$exesql=unserialize(base64_decode($mval['sqlselectform']));
					$neexesql=str_replace ( array ( '&quot;', '&#39;', '&lt;','&gt;'), array ('"',"'",'<','>'), $exesql);
					$exenewsql=$neexesql." where {$mval['objtable']}.id={$pkey} and {$mapstr}";
					$execulist=$masViewModel->query($exenewsql);
					logs("我是查询数据===={$exenewsql}",'DataControlExesql');
					if(!$execulist){
						//不满足直接进行下次循环
						continue; 
					} 
 					//循环post进行替换
 					$str=$mval['sql'];
 					//替换提示信息
 					$infostr=$mval['msginfo'];
 					
 					$field = array();//用来存储可以替换的字段字符串
 					$repstr = "";//每一次替换的字段
 					$arr = array();
 					$fieldtwo = array();//用来存储可以替换的字符串
 					$repstrtwo = "";//每一次替换的字段
 					$arrtwo = array();
 					
					foreach ($execulist[0] as $ekey=>$eval){
						if(empty($repstr)){
							logs("我进来了||||{$repstr}=====>{$ekey}","DataControlGmlx");
							if(strpos($str, $ekey)!== false && !in_array($ekey, $arr)){
								if(!$eval){
									$seval=0;
								}else{
									if(is_string($eval)){
										$seval="'".$eval."'";
									}
									if(is_numeric($eval)){
										$seval=$eval;
									}
								}
								$repstr = $ekey;
								$field[$ekey] =$seval;
							}
						}else{
							//不为空的时候。
							foreach ($execulist[0] as $okey=>$oval){
								//循环第二次
								if(strpos($okey,$repstr)!==false && $okey!=$repstr){
									//找到了，说明字段有相同部分
									if(strpos($str, $okey)!== false){
										logs("我进来了222||||{$repstr}=====>{$okey}","DataControlGmlx");
										//重新复制新字段
										//首先取消上一次存储的内容
										unset($field[$repstr]);
										//重新复制key
										$repstr = $okey;
										//重新复制数组
										if(!$oval){
											$seval=0;
										}else{
											if(is_string($oval)){
												$seval="'".$oval."'";
											}
											if(is_numeric($oval)){
												$seval=$oval;
											}
										}
										$field[$okey] =$seval;
										array_push($arr, $okey);
									}
								}
							}
							//重新复制为空
							$repstr = "";
						}
						
						if(empty($repstrtwo)){
							if(strpos($infostr, $ekey)!== false && !in_array($ekey, $arrtwo)){
								if(!$eval){
									 $ieval=0;
								}else{
									if(is_string($eval)){
										$ieval="'".$eval."'";
									}
									if(is_numeric($eval)){
										$ieval=$eval;
									}
								}
								$repstrtwo = $ekey;
								$fieldtwo[$ekey] =$ieval;
							}
						}else{
							//不为空的时候。
							foreach ($execulist[0] as $wkey=>$wval){
								//循环第二次
								if(strpos($wkey,$repstrtwo)!==false && $wkey!=$repstrtwo){
									//找到了，说明字段有相同部分
									if(strpos($str, $wkey)!== false){
										//重新复制新字段
										//首先取消上一次存储的内容
										unset($fieldtwo[$repstrtwo]);
										//重新复制key
										$repstrtwo = $wkey;
										//重新复制数组
										if(!$wval){
											$ieval=0;
										}else{
											if(is_string($wval)){
												$ieval="'".$wval."'";
											}
											if(is_numeric($wval)){
												$ieval=$wval;
											}
										}
										$fieldtwo[$wkey] =$ieval;
										array_push($arrtwo, $wkey);
									}
								}
							}
							//重新复制为空
							$repstrtwo = "";
						}
					}
					logs($arr,"DataControlGxxx");
					//定义真假变量
					$bool = false;
					logs($field,"DataControlGml");
					if($field){
						foreach ($field as $kkk=>$vvv){
							if(strpos($str, $kkk)!== false){
								$bool = true;
								$str=str_replace($kkk,$vvv,$str);
							}
						}
					}
					
					if($fieldtwo){
						foreach ($fieldtwo as $kwk=>$vwv){
							if(strpos($infostr, $kwk)!== false){
								$infostr=str_replace($kwk,$vwv,$infostr);
							}
						}
					}
					
					logs("我是计算公式{$str}",'DataControl');
// 					$str="我是测试<eval>(3+5-6)</eval>我是测试";
					// 当前公式处理后有值，但也包含了未能被替换掉的字母、通过if判断时它的结果为true
					if($bool){
						if(@eval("return $str;")){
							//提示信息
							$ninfostr=strCalculate($infostr);
							logs("我是提醒计算公式{$infostr}",'DataControl');
							break;
						} 
					}
			}
		}
		return  $ninfostr;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}