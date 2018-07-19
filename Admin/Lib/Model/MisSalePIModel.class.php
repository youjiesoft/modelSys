<?php
class MisSalePIModel extends CommonModel{
 	protected $trueTableName = 'mis_sale_profession_industry';
	public $_auto =array(
			array("createid","getMemberId",self::MODEL_INSERT,"callback"),
			array("createid","getMemberId",self::MODEL_UPDATE,"callback"),
			array("createtime","time",self::MODEL_INSERT,"function"),
			array("updatetime","time",self::MODEL_UPDATE,"function"),
			array('endtime','strtotime',self::MODEL_BOTH,'function'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
	public function professionlevel(){
		$model = M("mis_sale_profession");
		$list = $model->select();
		$newList=array();
		foreach($list as $key=>$val){
			//计算级数
			$level = '';
			$a = strlen($val['orderno']);
			if($a/4<1){
				$level =1;
			}else{
				$level = 1+($a-3)/4;
			}
			if($level==1){
				$newList['yiji'][] = array(
						"id"=>$val['id'],
						"name"=>$val['name'],
						); 
			}elseif($level==2){
				$newList['erji'][] = array(
						"id"=>$val['id'],
						"name"=>$val['name'],
						"erjiid" => $val['parentid'],
				);
			}elseif($level==3){
				$newList['sanji'][] = array(
						"id"=>$val['id'],
						"name"=>$val['name'],
						"sanjiid" => $val['parentid'],
				);
			}elseif($level==4){
				$newList['siji'][] = array(
						"id"=>$val['id'],
						"name"=>$val['name'],
						"sijiid" => $val['parentid'],
				);
			}
		}
		return json_encode($newList);
	}
}