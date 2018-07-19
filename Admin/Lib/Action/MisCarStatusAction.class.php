<?php
/** 
 * @Title: MisCarStatusAction 
 * @Package package_name
 * @Description: todo(车辆运行状态) 
 * @author 杨东 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-6-1 下午4:29:38 
 * @version V1.0 
*/ 
class MisCarStatusAction extends CommonAction {
	/**
	 * @Title: _filter
	 * @Description: todo(构造检索条件)
	 * @param HASHMAP $map
	 * @author 杨东
	 * @date 2013-5-31 下午4:01:22
	 * @throws
	 */
	public function _filter(&$map){
		if ($_SESSION["a"] != 1) $map['status']=1;
	}
	
	/* (non-PHPdoc) 列表前置函数
	 * @see CommonAction::_before_index()
	 */
	public function _before_index(){
		//过虑字段
		$map['b.returnTag']=0;  //看上奇怪， 这是关联查询中，a.  是一个表的别表， 这个要拿到ＳＱＬ语句中去处理。
		//初始化迭制器
		$modelMSC = M('mis_system_car');
		$list = $modelMSC -> where($map)->select();
		//取车辆信息； 如果车辆有被申请占用，那么要取出请求表中，请求者的信息
		$list = $modelMSC->table('mis_system_car as a')->where($map)->join('mis_request_car as b ON a.id = b.carID')->select();
		foreach($list as $key=>$value) {	
			$codeValue = $value['code'];
			//dump($value);
			//dump($codeValue);
			//获取上传图片列表
			unset($map);
			$map["status"]  =1;
			$map["orderid"] =$value['carID'];
			$map["type"] =48;
			$m=M("mis_attached_record");
			$attarry=$m->where($map)->find();
			//$this->assign('attarry',$attarry);			
			
			//传到方法中去拿到目录下的所有图片
			//$list[$key]['pic'] = $this->getPic($codeValue);
			$list[$key]['pic'] =$attarry['attached'];
		}
		// dump($list);
		$this->assign('volist',$list);
		//把这个$path分配到模板当中， 如果没有图片时显示一个出错图片
		$this->assign('noPicPath','/Public/Uploads/carpic');
	}
	/**
	 * @Title: getPic
	 * @Description: todo(显示图片相关) 
	 * @param 传个值过来一个咱径  $code
	 * @return boolean|multitype:  
	 * @author 杨东 
	 * @date 2013-6-1 下午4:31:18 
	 * @throws 
	*/  
	private function getPic($code){
		$path = '../Public/Uploads/carpic/'.$code."/";
		$opathError = '../Public/Uploads/carpic/';
		$tem =$output= array();
		$opath = str_replace('../Public', '__PUBLIC__', $path);
		if(!file_exists($path)){
			return false;
		}else{
			foreach (new DirectoryIterator($path) as $file) {
				if(!$file->isDot()){
					//只有扩展名是jpg才可以
					$fileExt = strtolower(substr(strrchr(basename($file->getfilename()), '.'),1));
					if($fileExt=="jpg" ||$fileExt=="gif" || $fileExt=="png" ||$fileExt=="tif" )
					{
						$arr['path']=$opath.'/'. $file->getFilename()."?rand=".mt_rand();
						$arr['file']=$file->getFilename();
						$arr['type']=$file->getType();
						array_push($tem,$arr);
					}
				}
			}
		}
		$imglength = count($tem);
		if($imglength>=2){
			$output = array_slice($tem, 0,2); 
		}elseif($imglength<2 && $imglength>0){
			$output = $tem;
		}
		return $output;
	}
}
?>