<?php
class MisSystemDataRoamingModel extends CommonModel{
	protected $trueTableName = 'mis_system_data_roaming';
	static protected $debug=true;
	static protected $debugRandnum="";
	static protected $dataRoamID="";
	public  function main($type,$sourcemodel,$pkValue,$sourcetype,$targetmodel,$updateBackup){		
		//漫游表验证是否要漫游
		switch($type){
			//普通漫游
			case 1:
				$dataRoamMas=self::dataRoamMasCheck($isbindsettable=0,$sourcemodel,$pkValue,$sourcetype,$targetmodel);				
				break;
			//套表漫游
			case 2:
				$dataRoamMas=self::dataRoamMasCheck($isbindsettable=1,$sourcemodel,$pkValue,$sourcetype,$targetmodel);
				break;
			//子流程漫游
			case 3:
				$dataRoamMas=self::dataRoamMasCheck($isbindsettable=2,$sourcemodel,$pkValue,$sourcetype,$targetmodel);				
				break;
		}
		
		//是字符串，或空数据查询，中断并返回
		if(is_string($dataRoamMas)||empty($dataRoamMas))return $dataRoamMas;
		
		foreach($dataRoamMas as $roamMasKey => $roamMasVal){
			//通过配置判断是否需要调试
			self::$debug=$roamMasVal['isdebug'];
			self::$debug=true;//强制执行
			self::$dataRoamID=$roamMasVal['id'];
			//首先通过主模型核验是否需要执行，不执行就直接中断，执行就赋值给主模型对象及通过它获取视图对象结果
			$sourceMainTable=D($roamMasVal['sourcemodel'])->gettablename();
			$canDataRoaming=self::dataRoamSourceObject($sourceMainTable,$pkValue,$roamMasVal['rules']);
			//如果返回false直接中断并继续返回false;
			if(is_string($canDataRoaming))return $canDataRoaming;
			if(empty($canDataRoaming))continue;
			//print_R($canDataRoaming);
			//获取来源与目标动作信息
			$dataRoamType=array();
			$dataRoamType['sourcetype']=$sourcetype;
			$dataRoamType['targettype']=$roamMasVal['targettype'];
			//获取来源数据并分流
			$mainObject=array();
			//数据源对象
			$tableObj=json_decode($roamMasVal['strelation'],true);
            //print_r($tableObj);
			//循环对象
			$cycleObj=$roamMasVal['cycle'];
			$cycleNum=1;//初始化循环次数
			foreach($tableObj as $key => $val){
				//目标对象类型 1为主表 2为内嵌表
				$targetObjType=$val['targettable']['tablecategory'];
				//目标对象表
				$targetObjTable=$val['targettable']['name'];
				//来源数据源类型 1为主表 2为内嵌表 3为视图
				$sourceObjType=$val['sourcetable']['tablecategory'];
				//来源数据源对应表
				$sourceObjTable=$val['sourcetable']['name'];
				switch($sourceObjType){
					//主表
					case 1:
						
						//主表与来源模型对比，如果相同
						if($sourceMainTable==$sourceObjTable){
						    $object=$canDataRoaming;
						}else{
							$object=self::dataRoamSourceObject($sourceObjTable,$pkValue);
						}
						break;
				    //内嵌表
					case 2:
						$object=self::dataRoamSublistObject($sourceObjTable,$pkValue);
						break;
					//视图
					case 3:
						//视图需要循环体，1视图本身多少条记录就循环多少次 2指定一个循环对象
						$object=self::dataRoamViewObject($sourceObjTable,$roamMasVal['id'],$canDataRoaming);
//						print_r($object);
						//$object="";
// 						$cycleNumView=count($object);
// 						//对数据进行循环赋值
// 						for($i=1;$i<$cycleNumView;$i++){
// 							$object[$i]=$object[0];
// 						}
						break;
				}
				//获取循环插入次数，这里是主表单生成单据次数
				if($cycleObj==$sourceObjTable){
					$cycleNum=count($object);
				}
				//print_r($object);
				//存在object值时
				if($object){
				$mainObject[$targetObjTable]['sourcetable']=$sourceObjTable;
				$mainObject[$targetObjTable]['sourceobjtype']=$sourceObjType;				
				$mainObject[$targetObjTable]['targettable']=$targetObjTable;
				$mainObject[$targetObjTable]['targetobjtype']=$targetObjType;
				$mainObject[$targetObjTable]['data']=$object;
				}
			}
			//print_r($mainObject);
			//获取子表字段对应信息
			$roamSubVal=self::dataRoamSubCheck($roamMasVal['id']);
			//$sourcetype=4;
			switch($sourcetype){
				//漫游生单，这个是不可能有循环的
				case 4:
					$result=$this->dataRoamOrderno($mainObject,$roamMasVal,$roamSubVal);
					//print_R($result);
					return $result;
					break;
					//静默漫游
				default:
					//当为子流程漫游时获取projectworkid
					if($type==3 || $type===1){
						$getProjectWorkid=true;
					}
					//开始循环多次生成单据
					for($i=0;$i<$cycleNum;$i++){
					//数据源，漫游主表id
					unset($sqlArr);
					$sqlArr=array();
					$sqlArr=self::dataRoam($dataRoamType,$mainObject,$roamMasVal,$roamSubVal,$getProjectWorkid,$thisCycle=$i,$updateBackup);
					$result=self::dataRoamSqlExecute($sqlArr,$roamMasVal['id'],$roamMasVal['sourcemodel'],$roamMasVal['targetmodel'],$pkValue);
					 //执行漫游SQL失败
					 if($result)return $result;
					}
					break;
			}			
	  }
	}
	/**
	 +----------------------------------------------------------
	 * 数据漫游检查
	 +----------------------------------------------------------
	 * @access dataRoamCheck
	 +----------------------------------------------------------
	 * @param string $do    1是点击触发  2是数据自动穿透（钩子）
	 +----------------------------------------------------------
	 * @param string $type  执行范围 （‘update,insert,delete’）
	 +----------------------------------------------------------
	 * @param string $do  当即执行标示
	 +----------------------------------------------------------
	 * @return false|integer
	 +----------------------------------------------------------
	 */	
	static private function dataRoamMasCheck($isbindsettable,$sourcemodel,$pkValue,$sourcetype,$targetmodel){
		switch($sourcetype){
			case 4:
				//生单漫游
				$masModel=D("MisSystemDataRoamMasView");
				//主表数据
				$map=array();
				$map['sourcemodel']=$sourcemodel;
				if($targetmodel){
				$map['targetmodel']=$targetmodel;
				}	
				$map['sourcetype']=$sourcetype;
				$map['isbindsettable']=$isbindsettable;
				$map['status']=1;
				
				$masResult=$masModel->where($map)->select();
 				//print_r($masModel->getLastSql());				
				if($masResult!==false){
					//如果存在漫游调试，才写入，这里可以监控是否存在多个漫游的情况
					if($masResult[0]['isdebug']||self::$debug){
					//数据漫游调试
					$dataRoamTrace=self::dataRoamTrace('生单漫游初始化:'.$sourcemodel."-".$pkValue,$masModel->getLastSql(),"1-S",self::$debugRandnum,self::$debugRandnum);if($dataRoamTrace){return $dataRoamTrace;}	
					self::$debugRandnum=rand(100,999);
					}			
					return $masResult;
				}else{
					return "生单漫游初始化存在错误，请检查漫游配置。sql:".$masModel->getLastSql();
				}								
	        break;
	        //静默漫游
			default:
				//实例化对象
				$masModel=D("MisSystemDataRoamMasView");
				$map=array();
				
				//$map['sourcemodel']=$model->getModelName();
				$map['sourcemodel']=$sourcemodel;
				if($targetmodel){
					$map['targetmodel']=$targetmodel;
				}
				$map['isbindsettable']=$isbindsettable;
				$map['status']=1;
				$map['_string'] = 'FIND_IN_SET('.$sourcetype.',mis_system_data_roam_relation_rules.sourcetype)';
				$masResult=$masModel->where($map)->select();
  			    //print_r($masModel->getLastSql());               
                if($masResult!==false){
                	//如果存在漫游调试，才写入，这里可以监控是否存在多个漫游的情况
                	if($masResult[0]['isdebug']||self::$debug){
                	$dataRoamTrace=self::dataRoamTrace('静默漫游初始化'.$sourcemodel."-".$pkValue,$masModel->getLastSql(),"1-J",self::$debugRandnum);if($dataRoamTrace)return $dataRoamTrace;
                	self::$debugRandnum=rand(100,999);
                	}
                	return $masResult;
                }else{
                	return "静默漫游初始化存在错误，请检查漫游配置。sql:".$masModel->getLastSql();
                }
			break;

		}
		//print_r($masResult);
		return $masResult;
	}
	static private function dataRoamSubCheck($roamMasid){
		$map['masid']=$roamMasid;
		$map['status']=1;
		$subResult=M('mis_system_data_roam_sub')->where($map)->order('tsort desc')->select();
		//print_r(M('mis_system_data_roam_sub')->getLastSql());
		if($subResult!==false){
			//数据漫游调试
			if(self::$debug){
				$dataRoamTrace=self::dataRoamTrace('数据漫游：字段匹配信息',M('mis_system_data_roam_sub')->getLastSql(),"3",self::$debugRandnum);if($dataRoamTrace)return $dataRoamTrace;
			}
		}else{
			return "数据漫游：字段匹配配置错误，请检查漫游配置。sql:".M('mis_system_data_roam_sub')->getLastSql();
		}
		//以targettable为key重新复制
		$object=array();
		$group="";//分组初始化
		$num=0;//key初始化
		foreach($subResult as $key => $val){
			if($val['targettable']!=$group){
				$group=$val['targettable'];
				$num=0;
				//开始新的分组
				$object[$group]['sourcetable']=$val['sourcetable'];
				//并将当前数据压入
				$object[$group]['data'][$num]=$val;
			}else{
				//直接将当前数据压入
				$object[$group]['data'][$num]=$val;
			}
			$num++;
		}
		return 	$object;
	}

	static private function dataRoamSourceObject($tableObj,$pkValue,$rules){
		//`mis_system_data_roam_relation_rules`
		$map=array();
		$map['id']=$pkValue;
		$map['status']=1;
		$map['_string']=$rules?$rules:"1=1";
		//var_dump($roamMasVal['rules']);
		//print_r($map);
		//根据来源模型来做判断是否能执行数据漫游
 		$object=M($tableObj)->where($map)->select();
 		 //       print_r($object);
 		//        print_r(M($tableObj)->getLastSql());			
		if($object!==false){
			//数据漫游调试
            if(self::$debug){
            	$dataRoamTrace=self::dataRoamTrace('漫游：主数据信息查询',M($tableObj)->getLastSql(),"2-1",self::$debugRandnum);if($dataRoamTrace)return $dataRoamTrace;
            }
			return $object;
		}else{
			return "查询漫游主数据存在错误，请检查漫游配置数据对象对应关系。sql:".M($tableObj)->getLastSql();
		}
		
	}
	//内嵌表对象
	static private function dataRoamSublistObject($tableObj,$pkValue){
		//获取数据源记录形成对象
        $map="";
		$map['masid']=$pkValue;
		//内嵌表好像没有status字段呢
		//$map['status']=1;
		$object = M( $tableObj )->where($map)->select ();
		//print_r($object);
		//print_r(M($tableObj)->getLastSql());
		if($object!==false){
			//数据漫游调试
			if(self::$debug){
				$dataRoamTrace=self::dataRoamTrace('漫游：内嵌表信息查询',M($tableObj)->getLastSql(),"2-2",self::$debugRandnum);if($dataRoamTrace)return $dataRoamTrace;
			}
			return $object;
		}else{
			return "查询漫游内嵌表数据存在错误，请检查漫游配置数据对象对应关系。sql:".M($tableObj)->getLastSql();
		}
	}
	
	//视图对象
	static private function dataRoamViewObject($tableObj,$roamMasID,$sourceObject){
		//首先获取视图关联关系
		//初始化whereArray条件
		$whereArr="";
		$map=array();
		$map['masid']=$roamMasID;
		$map['viewtable']=$tableObj;
		$whereArr=M('mis_system_data_roam_relation_view')->where($map)->select();
		if($whereArr!==false){
			//数据漫游调试
			if(self::$debug){
				$dataRoamTrace=self::dataRoamTrace('漫游：视图关联关系查询',M('mis_system_data_roam_relation_view')->getLastSql(),"2-3-1",self::$debugRandnum);if($dataRoamTrace)return $dataRoamTrace;
			}
		}else{
			return "查询漫游视图数据存在错误，请检查漫游视图关联配置。sql:".M('mis_system_data_roam_relation_view')->getLastSql();
		}
		//print_r(M('mis_system_data_roam_relation_view')->getLastSql());
		$where="";
		$num=1;//计数器		
		foreach($whereArr as $whereKey => $whereVal){
			
			//条件环节拼装
			$viewfield="";//字段
			$viewfieldValue="";//字段值
			//数据
			$viewfield=$whereVal['vfield'];
			//字段值：来源模型的元数据（注意：为了统一，这里取的是二维数组）,元数据是指向性的，只可能取下标为0的
			if(isset($sourceObject[0][$whereVal['sfield']])){
				$viewfieldValue= $sourceObject[0][$whereVal['sfield']];
			}else{
				$viewfieldValue="";
			}
			if($num>1){
				$connect=" AND ";
			}else{
				$connect=" ";
			}
			//更新值环节拼装,视图字段带了表名，不用加`符号
			$where.=$connect." ".$viewfield."='".$viewfieldValue."' ";
			$num++;
		}
		//视图信息
		$map=array();
		$map['name']=$tableObj;
		$viewInfo=D("MisSystemDataviewMas")->where($map)->field('condition,spellwheresql')->find();
		if($viewInfo!==false){
			//数据漫游调试
			if(self::$debug){
				$dataRoamTrace=self::dataRoamTrace('漫游：视图对象选定查询',D("MisSystemDataviewMas")->getLastSql(),"2-3-2",self::$debugRandnum);if($dataRoamTrace)return $dataRoamTrace;
			}
		}else{
			return "查询漫游视图数据存在错误，请检查系统视图关联配置。sql:".D("MisSystemDataviewMas")->getLastSql();
		}
		//视图条件
		if($viewInfo['condition']){
			if(empty($where)){
				$where.=$viewInfo['condition'];
			}else{
				$where.=" and ".$viewInfo['condition'];
			}
		}
		$map=array();
		$map['_string']=$where;
		//$map['status']=1;
		$object = D ( $tableObj )->where($map)->query($viewInfo['spellwheresql'],true);
 		//print_r($object);
// 		print_R( D ( $tableObj )->getLastSql());
		if($object!==false){
			//数据漫游调试
			if(self::$debug){
				$dataRoamTrace=self::dataRoamTrace('漫游：视图对象选定查询',D ( $tableObj )->getLastSql(),"2-3-3",self::$debugRandnum);if($dataRoamTrace)return $dataRoamTrace;
			}
			return $object;
		}else{
			return "查询漫游视图对象存在错误，请检查漫游视图关联配置。sql:".D ( $tableObj )->getLastSql();
		}	
		
	}
	
	 public  function dataRoamOrderno($mainObject,$roamMasVal,$roamSubVal){
	 	//数据漫游调试
	 	if(self::$debug){
	 		$dataRoamTrace=self::dataRoamTrace('数据漫游：进入生单漫游分发','',"4-S",self::$debugRandnum);if($dataRoamTrace)return $dataRoamTrace;
	 	}
		//抽离对象，将数据与表关系匹配分离,这里$roamSubVal与$mainObject都是key为targettable，data为
// 		print_r($mainObject);
// 		print_r($roamSubVal);
		$dataArr=array();//SQL记录初始化
		$num=0;//key初始化
		$objType=0;//初始化对象类型，分为1主表，2内嵌表
		foreach($roamSubVal as $targettable => $roamSubData){
			$sourcetable=$roamSubData['sourcetable'];
			$roamSub=$roamSubData['data'];
			//数据对象为多条时，进行数据循环
			if(count($mainObject[$targettable]['data'])>1){
				//这个时候再来做循环过滤
				foreach($mainObject[$targettable]['data'] as $key => $object){
					$dataArr[$targettable][$key]=self::dataRoamOrdernoCombox($object,&$roamMasVal,$roamSub,$sourcetable,$targettable);
					//$num++;//这里也继续循环计数
				}
			}else{
				//数据对象为一条时，直接赋值
				$dataArr[$targettable][0]=self::dataRoamOrdernoCombox($mainObject[$targettable]['data'][0],$roamMasVal,$roamSub,$sourcetable,$targettable);
				$num++;
			}				
		}
// 		print_r($dataArr);
		return $dataArr;
		/**数据处理实例-start**/
		foreach($dataArr as $targettable=>$data){
			//print_R($data);
			foreach($data as $k => $v){
				foreach($v as $k1 => $v1){
			    $vo[key($v1)] = reset($v1);			   
				}
			}
		}
// 		print_R($vo);
// 		exit;
		/**数据处理实例-end**/
	}
	/**
	 +----------------------------------------------------------
	 * 生成单据方法
	 +----------------------------------------------------------
	 * @access dataRoamOrderno
	 +----------------------------------------------------------
	 * @param string $do    1是点击触发  2是数据自动穿透（钩子）
	 +----------------------------------------------------------
	 * @param string $type  执行范围 （‘update,insert,delete’）
	 +----------------------------------------------------------
	 * @param string $do  当即执行标示
	 +----------------------------------------------------------
	 * @return false|integer
	 +----------------------------------------------------------
	 */
	static private  function dataRoamOrdernoCombox($object,$roamMasVal,$roamSubVal){
	//数据漫游调试
	 	if(self::$debug){
	 		$dataRoamTrace=self::dataRoamTrace('数据漫游：进入生单漫游分发拼装','',"5-S",self::$debugRandnum);if($dataRoamTrace)return $dataRoamTrace;
	 	}
		$data=array();//初始化空数据
		$num=0;//初始化计数
		foreach($roamSubVal as $subKey => $subVal){
			//字段
			$field=$subVal['tfield'];
			//直接替换
			if($subVal['expdo']==1){
				//字段值
				if(isset($object[$subVal['sfield']])){
					$fieldValue= $object[$subVal['sfield']];
				}else{
					//暂定，后续调整
					$fieldValue=$object[$subVal['sfield']];
				}
			}
			//SQL函数，在生单漫游这里无效
			if($subVal['expdo']==2){
				//字段值
				if(isset($object[$subVal['sfield']])){
					$fieldValue= $object[$subVal['sfield']];
				}else{
					//暂定，后续调整
					$fieldValue=$object[$subVal['sfield']];
				}
			}
			//SQL语句
			if($subVal["expdo"]==3){
				$qSql="";//初始化查询语句
				if($subVal['sfield']){
					$subVal['sfield']="'".$object[$subVal['sfield']]."'";
					$qSql.= str_replace("###",$subVal['sfield'],$subVal["expremark"]);
				}
				$reValue =M('mis_system_data_roam_sub')->query($qSql);
				if($reValue){
					foreach($reValue as $resultkey=>$resultval){
						$resultval=array_values($resultval);
						$fieldValue=$resultval[0];
						break;
					}
				}
				else{
					$fieldValue = "";
				}
			}
			//人工设置
			if($subVal['expdo']==4){
				if(!empty($subVal['expremark'])){
					$fieldValue=$subVal['expremark'];
				}else{
					$fieldValue = "";
				}
			}
			$data[$num]=array($field=>$fieldValue);
			$num++;
		}
		return $data;
	}	

	/**
	 +----------------------------------------------------------
	 * 延时更新检查 返回false表示需要延时
	 * 否则返回实际写入的数值
	 +----------------------------------------------------------
	 * @access dataRoam
	 +----------------------------------------------------------
	 * @param string $sourcetype  1来源模型新增动作  2来源模型更新动作  3来源模型删除动作）
     +----------------------------------------------------------
	 * @param string $do    1是点击触发  2是数据自动穿透（钩子）
	 +----------------------------------------------------------
	 * @param string $dataromaDebug    1是数据漫游调试
	 +----------------------------------------------------------
	 * @param string $do    1是点击触发  2是数据自动穿透（钩子）
	 +----------------------------------------------------------
	 * @return false|integer
	 +----------------------------------------------------------
	 */
	 static private  function dataRoam($dataRoamType,$mainObject,$roamMasVal,$roamSubVal,$getProjectWorkid,$thisCycle,$updateBackup){
	 	//数据漫游调试
	 	if(self::$debug){
	 		$dataRoamTrace=self::dataRoamTrace('数据漫游：进入静默漫游分发','',"4-J",self::$debugRandnum);if($dataRoamTrace)return $dataRoamTrace;
	 	}
	 	//抽离对象，将数据与表关系匹配分离,这里$roamSubVal与$mainObject都是key为targettable，data为
	 	$sqlArr=array();//SQL记录初始化
	 	$num=0;//key初始化
	 	$objType=0;//初始化对象类型，分为1主表，2内嵌表
	 	
		foreach($roamSubVal as $targettable => $roamSubData){
			$sourcetable=$roamSubData['sourcetable'];
			$roamSub=$roamSubData['data'];			
			//如果不存在来源数据，继续下一个循环
			if(!$mainObject[$targettable]['data']) continue;
			//$sourceObjType=$mainObject[$targettable]['sourceobjtype'];//来源对象类型
			//拼装来源表与目标表信息
			$objInfo['sourcetable']=$mainObject[$targettable]['sourcetable'];//来源表
			$objInfo['sourceobjtype']=$mainObject[$targettable]['sourceobjtype'];//来源表类型
			$objInfo['targettable']=$mainObject[$targettable]['targettable'];//目标表
			$objInfo['targetobjtype']=$mainObject[$targettable]['targetobjtype'];//目标表类型
			//如果为主表时
			switch ($objInfo['targetobjtype']) {
				case 1:
					//数据对象为主表时
					//如果存在内嵌表仅按单行插入
					if($roamMasVal['onlyoneinsert']){
							if($mainObject[$targettable]['data'][$thisCycle]){
								$sqlArr[$num]=self::dataRoamSqlCombox($dataRoamType,$mainObject[$targettable]['data'][$thisCycle],$roamMasVal,$roamSub,$sqlParam,$objInfo,$getProjectWorkid,$updateBackup);
							}else{
								$sqlArr[$num]=self::dataRoamSqlCombox($dataRoamType,$mainObject[$targettable]['data'][0],$roamMasVal,$roamSub,$sqlParam,$objInfo,$getProjectWorkid,$updateBackup);
							}
					}else{
						$sqlArr[$num]=self::dataRoamSqlCombox($dataRoamType,$mainObject[$targettable]['data'][0],$roamMasVal,$roamSub,$sqlParam,$objInfo,$getProjectWorkid,$updateBackup);					 
					}
					//附加属性	  
					  switch ($roamMasVal ['targettype']) {
					  	//如果是插入的情况下，需要获取到最新插入的主表id并返回回来当masid插入
					  	case 1:
					  	$num= $num+1;
					  	$sqlArr[$num]['sql']="SELECT LAST_INSERT_ID() as returnval";
					  	$sqlArr[$num]['return']=true;
					  	$sqlArr[$num]['replace']=false;
					  	$sqlArr[$num]['type']='select';
					  	break;
					  	//如果是修改，获取修改id
					  	case 2:
					  		$num= $num+1;
					  		$sqlArr[$num]['sql']="SELECT id as returnval from `".$targettable."` ".$sqlArr[$num-1]['sqlwhere'];
					  		$sqlArr[$num]['return']=true;
					  		$sqlArr[$num]['replace']=true;
					  		$sqlArr[$num]['type']='select';					  		
					  		break;					  	
					  }
					  $num++;
			    break;
				case 2:
					//数据对象为内嵌表时
					//数据对象为多条时，进行数据循环
					foreach($mainObject[$targettable]['data'] as $key => $object){
						//对Sql执行进行替换
						unset($sqlParam);
						//如果主表不是内嵌表对象
						if(!$roamMasVal['issubtable']){
						$sqlParam=array(
								'field'=>'masid',
						        'return'=>false,
								'replace'=>true
								);
						}
						//如果存在内嵌表仅按单行插入
						if($roamMasVal['onlyoneinsert']){
							if($key==$thisCycle){					
						      $sqlArr[$num]=self::dataRoamSqlCombox($dataRoamType,$object,$roamMasVal,$roamSub,$sqlParam,$objInfo,false,$updateBackup);
							}
						}else{							
						   $sqlArr[$num]=self::dataRoamSqlCombox($dataRoamType,$object,$roamMasVal,$roamSub,$sqlParam,$objInfo,false,$updateBackup);
						}
						$num++;//这里也继续循环计数
					}
				break;				
			}			
		}
		return $sqlArr;
	}
    	


	/**
	 +----------------------------------------------------------
	 * 数据漫游时的静默漫游分发中心 dataRoamSqlCombox
	 +----------------------------------------------------------
	 * @access dataRoam
	 +----------------------------------------------------------
	 * @param array $dataRoamType 存储来源动作类型，目标动作类型 $dataRoamType['sourcetype']$dataRoamType['targettype']
	 * @param array  $object      数据源对象
	 * @param array  $roamMasVal  漫游主表 $roamSubVal 漫游子表  重构key键为目标表
	 * @param array  $sqlParam    SQL关联参数，衔接上下SQL处理用$objInfo['sourcetable']
	 * @param array  $objInfo     数据源对象  $objInfo['sourcetable']来源表 $objInfo['sourceobjtype']来源表类型  $objInfo['targettable']目标表$objInfo['targetobjtype']目标表类型
	 * @param boolean $getProjectWorkid  是否获取项目任务id
	 * @param array   $updateBackup  这里是获取修改前数据记录
	 +----------------------------------------------------------
	 * @return string  sql
	 +----------------------------------------------------------
	 */	
	static private function dataRoamSqlCombox($dataRoamType,$object,$roamMasVal,$roamSubVal,$sqlParam,$objInfo,$getProjectWorkid=false,$updateBackup){
		//数据漫游调试
		if(self::$debug){
			$dataRoamTrace=self::dataRoamTrace('数据漫游：进入静默漫游SQL拼装分发','',"5-J",self::$debugRandnum);if($dataRoamTrace)return $dataRoamTrace;
		}
		switch ($dataRoamType ['targettype']) {
				// 新增,这里都是压入到一整行
				case "1" :
					$sql = "";
					$sql = self::dataRoamInsert ($dataRoamType,$object,$roamMasVal,$roamSubVal,$sqlParam,$objInfo,$getProjectWorkid);
					break;
					// 修改
				case "2" :
					$sql = "";
					$sql = self::dataRoamUpdate ($dataRoamType,$object,$roamMasVal,$roamSubVal,$sqlParam,$objInfo,$getProjectWorkid,$updateBackup);
					break;
					// 删除
				case "3" :
					$sql = "";
					$sql = self::dataRoamDelete ($dataRoamType,$object,$roamMasVal,$roamSubVal,$sqlParam,$objInfo,$getProjectWorkid,$updateBackup);
					break;
				case "0" :
					break;
			}
			return $sql;		
	}
	
	 static private function dataRoamSqlExecute($sqlArr,$roamid,$sourcemodel,$targetmodel,$pkValue,$do=1){
	 	//数据漫游调试
	 	if(self::$debug){
	 		$dataRoamTrace=self::dataRoamTrace('数据漫游：进入静默漫游SQL批量执行','',"6-J",self::$debugRandnum);if($dataRoamTrace)return $dataRoamTrace;
	 	}
		if (! empty ( $sqlArr )) {
			//当即执行
			if($do){
				$data = array (); // 日志记录
				$sort =1;//计数器
				$sqlreturn="";//初始化返回值使用方式
				foreach ( $sqlArr as $key => $val ) {
					//第一步，判断是否需要替换返回值,如果sort大于1才执行，第一次不可能有返回值
					if($sort>1 && $val['replace']){
						$sql= str_replace("###",$sqlreturn,$val['sql']);
					}else{
						$sql= $val['sql'];
					}
					//第二步，确定操作方式用读或者写
					$findWhere    = 'where';
					switch($val['type']){
					case 'insert':
						$result = M()->execute ( $sql );
						break;
					case 'update':
						//如果SQL不存在where条件则不执行
						if(stripos($sql,$findWhere)){
							$result = M()->execute ( $sql );
						}else{
							return "漫游更新语句没有where条件！";
						}
						break;						
					case 'delete':
						//如果SQL不存在where条件则不执行
						if(stripos($sql,$findWhere)){
							$result = M()->execute ( $sql );
						}else{
							return "漫游删除语句没有where条件！";
						}
						break;
					case 'select':
						$result = M()->query ( $sql );
					    break;
					}
					// 第三步，确定是否执行成功
					if ($result === false) {
						//如果错了直接全部回滚了，不再执行下面记录
						return "数据漫游错误！漫游对象：".$roamid.",SQL语句:".$sql;
						//echo $error;
						$data [$key] ['result'] = 0;
						//第四步，是否要重新给返回值赋值，这里因为本语句已经出错，可以强制给予一个特别值
						if($val['return']){
							$sqlreturn = 'error';
						}
					} else {
						$data [$key] ['result'] = 1;
						//第四步，是否要重新给返回值赋值？，赋值最新的返回结果,这里是2维数组，必须制定第一个数组的别名为returnval的字段
						if($val['return']){
							$sqlreturn = $result[0]['returnval'];
						}
					}
					
					$data [$key] ['createid'] = $_SESSION [C ( 'USER_AUTH_KEY' )];
					$data [$key] ['createtime'] = time ();
					$data [$key] ['companyid'] = $_SESSION ['companyid'];
					$data [$key] ['departmentid'] = $_SESSION ['user_dep_id'];
					$data [$key] ['sql'] = $sql;
					$data [$key] ['resume'] = $val['resume'];
					$data [$key] ['roamid'] = $roamid;
					$data [$key] ['sourcemodel'] = $sourcemodel;
					$data [$key] ['targetmodel'] = $targetmodel;
					$data [$key] ['sourceid'] = $pkValue;
					$data [$key] ['sqlreturn'] = $val['return'];
					$data [$key] ['sqlreturnval'] = $sqlreturn;
					$data [$key] ['sqlreplace'] = $val['replace'];
					$data [$key] ['sqltype'] = $val['type'];
					$sort++;//增加计数
				}
				// 数据漫游调试
				$Debug = false;
				if ($Debug) {
					print_r ( $data );
					//exit ();
				}
				// 写入日志
				$msdrModel = M ( "mis_system_data_roaming" );
				$msdrModel->addAll($data);
// 				foreach($data as $kk=>$vv){
// 					$result = $msdrModel->add($vv);
// 					if($result === false){
// 						return "错误：".$msdrModel->getLastSql();
// 					}
// 				}
			} else {
				// 压入到队列执行
			}
		}		
	}
	/**
	 +----------------------------------------------------------
	 * 数据漫游时的数据插入 dataRoamInsert
	 +----------------------------------------------------------
	 * @access dataRoam
	 +----------------------------------------------------------
	 * @param mix data  写入标识
	 +----------------------------------------------------------
	 * @return string  sql
	 +----------------------------------------------------------
	 */
	
	static private function dataRoamInsert($dataRoamType,$object,$roamMasVal,$roamSubVal,$sqlParam,$objInfo,$getProjectWorkid){   
		/****************新增时需要附加的数组**********************/
		$autoFiledArr=array();//附加数组初始化
		switch ($objInfo['targetobjtype']){
			case 1:
				//主表
				//新增时要更新单号规则
				$scnModel=D("SystemConfigNumber");
				$ordernoInfo=$scnModel->getOrderno($objInfo['targettable'],$roamMasVal['targetmodel']);
				//如果编码规则存在，强制转换，排除数据漫游设置；否则以数据漫游设置为准
				if($ordernoInfo['status']){
				   $autoFiledArr=array(
				   		'orderno'=>$ordernoInfo['orderno'],'createtime'=>time(),'createid'=>$_SESSION[C('USER_AUTH_KEY')],
				   		'companyid' => $_SESSION ['companyid'],'departmentid' => $_SESSION ['user_dep_id'],
				   		);
				}else{
					$autoFiledArr=array(
					     'createtime'=>time(),'createid'=>$_SESSION[C('USER_AUTH_KEY')],
						 'companyid' => $_SESSION ['companyid'],'departmentid' => $_SESSION ['user_dep_id'],
						);
				}
				break;
			case 2:
				
				break;
		}
		
		/************数据是项目插入时,是否要提出来？**********/
		if($roamMasVal['sourcemodel']=='MisSalesMyProject'){
			$mis_project_flow_formDao = M("mis_project_flow_form");
			$projectmap['projectid'] = $object['id'];
			$projectmap['formobj'] = $roamMasVal['targetmodel'];
			$projectworkid = $mis_project_flow_formDao->where($projectmap)->getField("id");
			//print_R($mis_project_flow_formDao->getLastSql());
			$autoFiledArr['projectworkid']=$projectworkid;
		}else if($getProjectWorkid){
			$mis_project_flow_formDao = M("mis_project_flow_form");
			$projectmap['projectid'] = $object['projectid'];
			$projectmap['formobj'] = $roamMasVal['targetmodel'];
			$projectworkid = $mis_project_flow_formDao->where($projectmap)->getField("id");			
			//print_R($mis_project_flow_formDao->getLastSql());
            $autoFiledArr['projectworkid']=$projectworkid;			
		}
	    /************对sqlArr进行操作************************/
		  if($sqlParam['field']){
		  	$autoFiledArr[$sqlParam['field']]='###';
		  } 		
		/************先确定来源类型，获取对应的处理模式*******************/
		  switch ($dataRoamType['sourcetype']){
		  	case 1://新增
		  		$opetaionDo="expdo";
		  		$opetaionValue="expremark";
		  		break;
		  	case 2://修改
		  		$opetaionDo="expdo";
		  		$opetaionValue="expremark";
		  		break;
		  	case 3://删除
		  		$opetaionDo="deldo";
		  		$opetaionValue="delremark";
		  		break;
		  }
		/***************************************************/		  
		$sqlArr="";//销毁之前的SQL返回数组
		$sql="INSERT INTO " . $objInfo['targettable'] . " ( ";//初始化SQL语句前缀
		$field="";//字段
		$sqlField="";//SQL拼装
		$fieldValue="";//字段值
		$sqlFieldValue="";//SQL拼装
		$sort=1;//计数器
		//获取明细信息
		foreach($roamSubVal as $subKey => $subVal){

			//先判断是否在自动插入数组内，在的话进入下一个循环
			if(array_key_exists($subVal['tfield'],$autoFiledArr))continue;			
			//字段
			$field=$subVal['tfield'];
			//字段值
			//处理模式选择
			switch ($subVal[$opetaionDo]){
				case 1://直接替换
					if(isset($object[$subVal['sfield']])){
						switch ($dataRoamType['sourcetype']){
							case 1://来源动作为新增
							case 2://来源动作为修改
//							case 3:
								//字段值
								$fieldValue= "'".$object[$subVal['sfield']]."'";
								break;
								//删除类型直接清空
							case 3://来源动作为删除
								//字段值
								$fieldValue= "''";
								break;
						}
					}else{
						//暂定，后续调整
						$fieldValue="'".self::dataRoamExchange($subVal['sfield'])."'";
					}										
				break;
				case 2://SQL函数
					//字段值
					if(isset($object[$subVal['sfield']]) && isset($subVal[$opetaionValue])){
						switch ($dataRoamType['sourcetype']){
							case 1://新增
							case 2://修改
							case 3://删除
								$fieldValue = self::dataRoamFunction($subVal[$opetaionValue],$object[$subVal['sfield']],0,0);
								break;
						}
					}else{
						$fieldValue=self::dataRoamExchange($subVal['sfield']);
					}										
				break;					
				case 3://SQL语句
					$qSql="";//初始化查询语句
					if($subVal['sfield']){
						$subVal['sfield']="'".$object[$subVal['sfield']]."'";
						$qSql.= str_replace("###",$subVal['sfield'],$subVal[$opetaionValue]);
					}
					$reValue = M('mis_system_data_roam_sub')->query($qSql);
					if($reValue){
						foreach($reValue as $resultkey=>$resultval){
							$resultval=array_values($resultval);
							$fieldValue="'".$resultval[0]."'";
							break;
						}
					}
					else{
						$fieldValue = "''";
					}					
				break;					
				case 4://直接替换
					if(!empty($subVal[$opetaionValue])){
						$fieldValue="'".$subVal[$opetaionValue]."'";
					}else{
						$fieldValue = "''";
					}					
				break;					
			}			

			/*****************************************/
			//这里开始匹配字段与字段值	
			//第一个数据,因为是插入不能有,号分隔
			if($sort==1){
					$sqlField.="`".$field."`";
					$sqlFieldValue.=" ".$fieldValue;							
			}else{
					$sqlField.=",`".$field."`";
					$sqlFieldValue.=",".$fieldValue;
			}
			$sort++;
		}
		//循环补充自动增补数组
		foreach($autoFiledArr as $autokey=> $autoval){
			if($sort==1){
				$sqlField.="`".$autokey."`";
				$sqlFieldValue.="'".$autoval."'";
			}else{
				$sqlField.=",`".$autokey."`";
				$sqlFieldValue.=",'".$autoval."'";				
			}
			$sort++;
		}		
		$sql.=$sqlField." ) VALUES ( ".$sqlFieldValue." )";
		//拼装sqlArr
		//执行前是否替换
		$sqlParam['replace']?$sqlArr['replace']=$sqlParam['replace']:$sqlArr['replace']=false;
		//执行后是否返回值
		$sqlParam['return']?$sqlArr['return']=$sqlParam['return']:$sqlArr['return']=false;
		//执行类型,写入操作
		$sqlArr['type']='insert';
		$sqlArr['sql']=$sql;
		
		return $sqlArr;
	}
	/**
	 +----------------------------------------------------------
	 * 数据漫游时的数据更新 dataRoamUpdate
	 +----------------------------------------------------------
	 * @access dataRoam
	 +----------------------------------------------------------
	 * @param mix data  写入标识
	 +----------------------------------------------------------
	 * @return string  sql
	 +----------------------------------------------------------
	 */                    
	static private function dataRoamUpdate($dataRoamType,$object,$roamMasVal,$roamSubVal,$sqlParam,$objInfo,$getProjectWorkid,$updateBackup){

		//得到本次修改前的数据记录
        $updateBackupData=self::dataRoamOldData($updateBackup);
        $fieldWhere=self::dataRoamUpdateWhere($object,$roamMasVal,$objInfo['sourcetable'],$objInfo['targettable']);
        //echo $fieldWhere;
        $sqlArr="";//销毁之前的SQL返回数组
        //这里开始准备一个要还原的SQL语句
        $sqlArr['sqlwhere']=$fieldWhere;//where条件
        $sqlArr['resume']=self::dataRoamResumeSql($objInfo['targettable'],$roamSubVal,$fieldWhere,$operation='update',$type=false);
        //内嵌表修改会返回NULL；则跳转到新增方法
        if($sqlArr['resume']===false && $objInfo['targetobjtype']==2){
        	return self::dataRoamInsert ($dataRoamType,$object,$roamMasVal,$roamSubVal,$sqlParam,$objInfo,$getProjectWorkid);
        }        
        //先确定来源类型，获取对应的处理模式
        switch ($dataRoamType['sourcetype']){
        	case 1://新增
        		$opetaionDo="expdo";
        		$opetaionValue="expremark";
        		break;
        	case 2://修改
        		$opetaionDo="expdo";
        		$opetaionValue="expremark";
        		break;
        	case 3://删除
        		$opetaionDo="deldo";
        		$opetaionValue="delremark";
        		break;
        }
		//初始化SQL前缀
		$sql="UPDATE " . $objInfo['targettable'] . " SET ";
		foreach($roamSubVal as $subKey => $subVal){
			//获取明细信息
			$field="";//字段
			$fieldValue="";//字段值
			//字段名
			$field=$subVal['tfield'];
            //处理模式选择
			switch ($subVal[$opetaionDo]){
				case 1://直接替换
					if(isset($object[$subVal['sfield']])){
					switch ($dataRoamType['sourcetype']){
						case 1:
						case 2:
						//字段值						
							$fieldValue= "'".$object[$subVal['sfield']]."'";
						break;
						//删除类型直接清空
						case 3:
						//字段值
							$fieldValue= "''";
						break;					
					}
					}else{
						//暂定，后续调整
						$fieldValue="'".self::dataRoamExchange($subVal['sfield'])."'";
					}					
					break;
				case 2://SQL函数执行
					//字段值
					if(isset($object[$subVal['sfield']]) && isset($subVal[$opetaionValue])){					
						switch ($dataRoamType['sourcetype']){
							case 1://新增
									$fieldValue = self::dataRoamFunction($subVal[$opetaionValue],$object[$subVal['sfield']],0,$field);
								break;
							case 2://修改
									$fieldValue = self::dataRoamFunction($subVal[$opetaionValue],$object[$subVal['sfield']],$updateBackupData[$subVal['sfield']],$field);
								break;
							case 3://删除
									$fieldValue = self::dataRoamFunction($subVal[$opetaionValue],0,$updateBackupData[$subVal['sfield']],$field);
								break;
						}
					}else{
						$fieldValue=self::dataRoamExchange($subVal['sfield']);
					}					
					break;
				case 3://数据库函数
					$qSql="";//初始化查询语句
					if($subVal['sfield']){
						$subVal['sfield']="'".$object[$subVal['sfield']]."'";
						$qSql.= str_replace("###",$subVal['sfield'],$subVal[$opetaionValue]);
					}
					$reValue = M('mis_system_data_roam_sub')->query($qSql);
					if($reValue){
						foreach($reValue as $resultkey=>$resultval){
							$resultval=array_values($resultval);
							$fieldValue="'".$resultval[0]."'";
							break;
						}
					}
					else{
						$fieldValue = "''";
					}					
					break;
				case 4://人工设置
					if(!empty($subVal[$opetaionValue])){
						$fieldValue="'".$subVal[$opetaionValue]."'";
					}else{
						$fieldValue = "''";
					}					
					break;
			}
		
			if($subKey===0){
				//更新值环节拼装
				$sql.="`".$field."`=".$fieldValue;
			}else{
				$sql.=",`".$field."`=".$fieldValue;
			}
	
		}
	    //加上where条件
		$sql.=$fieldWhere;
	    //拼装sqlArr
		//执行前是否替换
		$sqlParam['replace']?$sqlArr['replace']=$sqlParam['replace']:$sqlArr['replace']=false;
		//执行后是否返回值
		$sqlParam['return']?$sqlArr['return']=$sqlParam['return']:$sqlArr['return']=false;
		//执行类型,写入操作
		$sqlArr['type']='update';
		$sqlArr['sql']=$sql;
		return $sqlArr;
	}
	/**
	 +----------------------------------------------------------
	 * 数据漫游时的数据删除  dataRoamDelete
	 +----------------------------------------------------------
	 * @access dataRoam
	 +----------------------------------------------------------
	 * @param mix data  写入标识
	 +----------------------------------------------------------
	 * @return string  sql
	 +----------------------------------------------------------
	 */
	static private function dataRoamDelete($dataRoamType,$object,$roamMasVal,$roamSubVal,$sqlParam,$objInfo,$getProjectWorkid){
        $fieldWhere=self::dataRoamUpdateWhere($object,$roamMasVal,$objInfo['sourcetable'],$objInfo['targettable']);
        //echo $fieldWhere;
        $sqlArr="";//销毁之前的SQL返回数组
		//初始化SQL前缀
        $sql="DELETE form  ".$objInfo['targettable']." ";		
		
		$sql.=$fieldWhere;
		//这里开始准备一个要还原的SQL语句
		$sqlArr['resume']=self::dataRoamResumeSql($objInfo['targettable'],$roamSubVal,$fieldWhere,$operation='delete',$type=true);
	    //拼装sqlArr
		//执行前是否替换
		$sqlParam['replace']?$sqlArr['replace']=$sqlParam['replace']:$sqlArr['replace']=false;
		//执行后是否返回值
		$sqlParam['return']?$sqlArr['return']=$sqlParam['return']:$sqlArr['return']=false;
		//执行类型,写入操作
		$sqlArr['type']='delete';
		$sqlArr['sql']=$sql;
		$sqlArr['where']=$fieldWhere;
		return $sqlArr;
	}
	/**
	 +----------------------------------------------------------
	 * 数据漫游时的目标数据存在时的SQL语句  dataRoamResumeSql
	 +----------------------------------------------------------
	 * @access dataRoam
	 +----------------------------------------------------------
	 * @param mix data  写入标识
	 +----------------------------------------------------------
	 * @return string  sql
	 +----------------------------------------------------------
	 */
	static private function dataRoamResumeSql($targetTable,$data,$where,$operation='update',$type=true){
		
		$sql="Select ";
		$field="";
		//如果为删除，强制显示全部全部字段
		if($operation=='delete'){
			$type=true;
		}
		//如果$type为ture，执行全表数据存储
		if($type){
			$fullFieldsSql='SHOW FULL COLUMNS FROM '.$targetTable;
			$data=M($targetTable)->query($fullFieldsSql);
			foreach($data as $key => $val){
				$field.="`".$val['Field']."`,";
			}
		}else{
			foreach($data as $key => $val){
				$field.=$val['tfield'].",";
			}
		}
		$sql.=substr($field,0,-1)." from ".$targetTable.$where;
	    $result=M($targetTable)->query($sql);
	   //print_r(M($targetTable)->getLastSql());
	   //print_r($result);
	   //这是带where查询，我们只取单行记录
	    if($result[0]){
	    	switch($operation){
	    		case 'update':
	    			$sqlResume="Update ".$targetTable." SET ";
	    			$fieldVal="";
			    	foreach($result[0] as $subkey=>$subval){
			    	  $fieldVal.=" `".$subkey."`='".$subval."',";
			    	}
				    $sqlResume.=substr($fieldVal,0,-1).$where;
			    break;
	    		case 'delete':
	    			$sqlResume="INSERT INTO ".$targetTable." ( ";
	    			
	    				$sort=1;//初始化计数器
	    				$field="";//初始化字段名
	    				$fieldVal="";//初始化字段值
	    				foreach($result[0] as $subkey=>$subval){
	    					//第一个值不要，号
	    					if($sort==1){
		    					$field.=" `".$subkey."`";
		    					$fieldVal.=" '".$subval."'";
	    					}else{
	    						$field.=",`".$subkey."`";
	    						$fieldVal.=",'".$subval."'";
	    					}
	    					$sort++;
	    				}	    				    			
	    		       $sqlResume.=$field.' ) VALUES ( '.$fieldVal." ) ";
	    		break;
	    	}
	    }else{
	    	$sqlResume=false;
	    }
	  
// 	    print_r($sqlResume);
// 	    exit;
        //base64加密SQL语句，避免富文本干扰
		return $sqlResume;
	}
	/**
	 +----------------------------------------------------------
	 * 数据漫游时的数据转换项
	 * 暂时未用，数据级的基本用不上
	 +----------------------------------------------------------
	 * @access dataRoamExchange
	 +----------------------------------------------------------
	 * @param string $val  写入标识
	 +----------------------------------------------------------
	 * @return false|integer
	 +----------------------------------------------------------
	 */
	static private function dataRoamExchange($val){
		switch($val){
			case "createid"://创建人
				$result="1";
				//$aryval[$k]=getFieldBy($v,"id","name","LinkManInfomation");
				break;
			case "createtime"://创建人
				$result=strtotime(date("Y-m-d H:i:s"));
				break;
			case "createtime"://创建人
				$result=null;
				break;				
		}
		return $result;
	}	
	
	/**
	 +----------------------------------------------------------
	 * 数据漫游函数转换项
	 +----------------------------------------------------------
	 * @access dataRoamFunction
	 +----------------------------------------------------------
	 * @param string $val  写入标识
	 +----------------------------------------------------------
	 * @return false|integer
	 +----------------------------------------------------------
	 */
	static private function dataRoamFunction($function,$sourceVal,$sourceOldVal,$targetVal){		
		switch($function){
			case "plus"://增加值
				$sourceOldVal=$sourceOldVal?$sourceOldVal:0;
				$result="plus($sourceVal,$sourceOldVal,IFNULL(`".$targetVal."`,0))";
				//$aryval[$k]=getFieldBy($v,"id","name","LinkManInfomation");
				break;
			case "minus"://减少值
				$sourceOldVal=$sourceOldVal?$sourceOldVal:0;
				$result="minus($sourceVal,$sourceOldVal,IFNULL(`".$targetVal."`,0))";
				break;
		}
		return $result;
	}
	/**
	 +----------------------------------------------------------
	 * 修改或删除前老数据获取
	 +----------------------------------------------------------
	 * @access dataRoamFunction
	 +----------------------------------------------------------
	 * @param string $val  写入标识
	 +----------------------------------------------------------
	 * @return false|integer
	 +----------------------------------------------------------
	 */
	static private function dataRoamOldData($updateBackup){
		//得到本次修改前的数据记录
		//echo "select * from `".$updateBackup['randtable']."` where tablename='".$updateBackup['tablename']."' and createid='".$updateBackup['createid']."' and randname='".$updateBackup['randnum']."';";
		$updateBackupData=M()->query("select * from `".$updateBackup['randtable']."` where tablename='".$updateBackup['tablename']."' and createid='".$updateBackup['createid']."' and randnum='".$updateBackup['randnum']."';");
		$updateBackupData=unserialize(base64_decode($updateBackupData[0]['backupdata']));
		return $updateBackupData;
	}
	
	/**
	 +----------------------------------------------------------
	 * 数据漫游时的数据更新 dataRoamUpdate
	 +----------------------------------------------------------
	 * @access dataRoam
	 +----------------------------------------------------------
	 * @param mix data  写入标识
	 +----------------------------------------------------------
	 * @return string  sql
	 +----------------------------------------------------------
	 */
	static private function dataRoamUpdateWhere($object,$roamMasVal,$sourceTable,$targetTable){
		//首先获取来源与目标的关联关系
		$fieldWhere=" WHERE 1=1 ";	//条件
		$whereArr="";
		$map=array();
		$map['masid']=$roamMasVal['id'];
		$map['sourcetable']=$sourceTable;
		$map['targettable']=$targetTable;
		$whereArr=M('mis_system_data_roam_relation')->where($map)->select();
		//修改方法里没有关联条件直接返回null;
		if($whereArr){
			foreach($whereArr as $whereKey => $whereVal){
				//条件环节拼装
				$field="";//字段
				$fieldValue="";//字段值
				//数据
				$field=$whereVal['tfield'];
				//字段值：来源模型的元数据
				if(isset($object[$whereVal['sfield']])){
					$fieldValue= $object[$whereVal['sfield']];
				}else{
					$fieldValue=self::dataRoamExchange($whereVal['sfield']);
				}
				//更新值环节拼装
				$fieldWhere.=" AND `".$field."`='".$fieldValue."'";
			}
		}else{
			$fieldWhere="where 1>1";
		}
		return $fieldWhere;
	}	
	/**
	 *
	 * @Title: getCompareResult
	 * @Description: todo(传入漫游id 和目标表条件进行比对数据)
	 * @param unknown $masid
	 * @param unknown $where
	 * @return string|number
	 * @author renling
	 * @date 2015年4月3日 下午3:11:23
	 * @throws
	 */
	public function getCompareResult($masid,$where){
		//查询此数据漫游所有需要比较的字段
		$MisSystemDataRoamCompareDao=M("mis_system_data_roam_compare");
		$compareMap=array();
		$compareMap['masid']=$masid;
		$MisSystemDataRoamCompareList=$MisSystemDataRoamCompareDao->where($compareMap)->select();
		$MisSystemDataRoamMasAction=A("MisSystemDataRoamMas");
		//获取selectlist
		foreach ($MisSystemDataRoamCompareList as $key=>$val){
			//targettable 目标
			$targettableModel=D($val['targettable']);
			$targetMap=array();
			$targetMap['_string']=$where;
			//查询字段
			$targetList=$targettableModel->where($targetMap)->find();
			$roleexp=getSelectByName('roleexp', $val['roleinexp']);
			$result=$this->autoCaculate($targetList[$val['tfield']], html_entity_decode($roleexp), $targetList[$val['compare']]);
			$info="";
			if(!$result){
				//查询表字段信息
				$fieldsAll= $MisSystemDataRoamMasAction->changesourcefield($val['targettable'],'1');
				return $info=$fieldsAll[$val['tfield']]['showname']."(".getDigits($targetList[$val['tfield']]).")【".getSelectByName('roleinexp', $val['roleinexp'])."】".$fieldsAll[$val['compare']]['showname']."(".getDigits($targetList[$val['compare']]).")"."判断不成立,请查证后再提交!";
			}else{
				return $info=1;
			}
		}
	}
	/**
	 *
	 * @Title: autoCaculate
	 * @Description: todo(数据对比计算)
	 * @param unknown $val1
	 * @param unknown $oprate
	 * @param unknown $val2
	 * @return string|boolean
	 * @author renling
	 * @date 2015年4月3日 下午3:11:51
	 * @throws
	 */
	function autoCaculate($val1 , $oprate , $val2){
		if(!$val1 || !$oprate || !$val2){
			return '<error>parameter is error!</error>';
		}
		$oprateArr = array('>' , '<' ,'==','>=' , '<=' ,'!=');
		if(!in_array($oprate, $oprateArr)){
			return '<error>Operator is not defined!</error>';
		}
		switch ($oprate){
			case '>':
				return $val1 > $val2;
				break;
			case '<':
				return $val1 < $val2;
				break;
			case '==':
				return $val1 == $val2;
				break;
			case '>=':
				return $val1 >= $val2;
				break;
			case '<=':
				return $val1 <= $val2;
				break;
			case '!=':
				return $val1 != $val2;
				break;
			default:
				return  false;
				break;
		}
	}
	
	//临时表存储历史记录
	//这里用来存储临时缓存文件
	/**
	 * @Title: nvigateTO
	 * @Description:临时表存储历史记录
	 * @author liminggang
	 * @date 2014-10-13 下午8:22:48
	 * @paramate $model mix  $pkval int
	 * @return $updateBackup(临时表关键查找信息);
	 * @throws
	 */
	static private function dataRoamTrace($msg,$sqlinfo,$step,$randnum){	
		$result=M('mis_system_data_roam_test')->execute("INSERT INTO mis_system_data_roam_test (`roamid`,`msg`,`sqlinfo`,`step`,`randnum`,`createid`,`createtime`) values('".self::$dataRoamID."','".$msg."','".base64_encode($sqlinfo)."','".$step."','".$randnum."','".$_SESSION [C ( 'USER_AUTH_KEY' )]."','".time ()."')");
		if($result!==false){
			return false;
		}else{			
			return "追踪到错误：".M('mis_system_data_roam_test')->getLastSql();
		}	
	}	
}
?>
