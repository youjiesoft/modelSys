<?php 
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(会议室使用记录:视图展示) 
 * @author yuansl 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-7-4 下午2:37:02 
 * @version V1.0
 */
class MisMeetingUseRecordAction extends CommonAction{
	
	public function index(){
		//第一步、构造横纵坐标的数据名称
		$DATE_NUM = 5; //定义时间跨度为5天
		$temp = time(); //获取当前时间
		$step = 3600*24 ;
		$time_array = array(); //存储时间数组
		for($i=0;$i<$DATE_NUM;$i++ ){
			//构造横坐标
			$time_array[] = date('Y-m-d',$temp)."-上午";
			$time_array[] = date('Y-m-d',$temp)."-下午";
			$temp = $temp +$step ;
		}
		$this->assign("timeX",$time_array);
		//构造纵坐标
		$RoomModel = D("MisMeetingRoom");
		$roomList = $RoomModel->where("status = 1")->field("id,name")->select();
		$bt=$step/2;
		foreach($roomList as $key=>$val){
			$ds = array();
			$ds[] = array('hys'=>$val['name'],'type'=>1);
			$taday=strtotime(date('Y-m-d',time()));
			for($i=0;$i<$DATE_NUM*2;$i++ ){
				$ds[$taday] = array(
					'starttime'=>$taday+1,
					'endtime'=>$taday+$bt,
				);
				$taday+=$bt;
			}
			$roomList[$key]['sj'] = $ds;
		}
		//查询会议室使用记录信息
		$RoomApplyUseModel = D('MisMeetingUserMange');
		$rooMap['status'] = 1;
		$rooMap['auditState'] = 3;
		$rooMap['estimatedStrtime'] = array('gt',time());
		$allLawfulData = $RoomApplyUseModel->where($rooMap)->field("estimatedStrtime , estimatedEndtime , id, objid")->select();//集合所有合法数据
		
		foreach($roomList as $key=>$val){
			foreach($val['sj'] as $k=>$v){
				foreach($allLawfulData as $k1=>$v1){
					$ab = array();
					if($val['id'] == $v1['objid'] && $v['type']!=1){
						if($v1['estimatedStrtime']<= $v['endtime'] && $v1['estimatedEndtime']>=$v['starttime']){
							$ab = transTime($v1['estimatedStrtime'],"H:i")."~".transTime($v1['estimatedEndtime'],"H:i");
						}
					}
					if($ab){
						$roomList[$key]["sj"][$k]["zyhys"][] = $ab;
					}
				}
			}
		}
		$this->assign("rooms",$roomList);
		$this->display();
	}
}
?>