<?php
/**
 * @Title: MisSaleTimingUpdateAction
 * @Package package_name
 * @Description: todo(定时更新商机是否超期)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-09-23 16:28:46
 * @version V1.0
*/
class MisSaleTimingUpdateAction extends CommonAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1){
			$map['status']= 1;
		}
	}
	public function lookuptimingupdate(){
			$name='MisSaleBusiness';
			$name1='MisSaleBusinessAllot';
			$model1 = D ( $name1 );
			$arr['endstatus'] = 0;
			$arr['turnstatus'] = 0;
			$time=strtotime(date("Y-m-d",time()));
			$result = $model1->where($arr)->select();
			
			foreach ($result as $value){
				if($value['endtime']<$time){
					$arrId[] = $value['id'];
					$arrBid[]=$value['bid'];
				}
			}
			if(!empty($arrId)){
				$data = array('endstatus'=>1);
				$condition = array('id'=>array('in',$arrId));
				$list=$model1->where($condition)->save($data);
				if (false !== $list) {
					
					if(!empty($arrBid)){
						$model2 = D ( $name );
						$condition2 = array('id'=>array('in',$arrBid),'businessstatus'=>array('neq','4'));
						$data2['businessstatus'] = 5;
						$list1=$model2->where($condition2)->save($data2);
						echo $model2->getLastSql();
					}
					
					
					//执行成功后，用A方法进行实例化，判断当前控制器中是否存在_after_update方法
					$module1=A($name1);
					if (method_exists($module1,"_after_update")) {
						call_user_func(array(&$module2,"_after_update"),$list);
					}
				}
			}
			
			 
			
		}
	
	
	
}